<?php
if (!defined('IN_GAME')) {
    exit('Access Denied');
}

// QUEST item handler / QUEST物品处理

include_once GAME_ROOT.'./include/game/quest.func.php';
include_once GAME_ROOT.'./include/game.func.php';

// 消耗Q6侦探眼镜充能 / Consume a Q6 detective-glasses charge
function quest_q6_consume_clue_charge(&$charges, $nosta, $is_replacement)
{
    // 已付费目标异常消失时，替代NPC不再次消耗充能。
    // A replacement for an abnormally missing paid target costs no extra charge.
    if (!$is_replacement && $charges != $nosta) $charges--;
}

function item_quest($itmn, &$data)
{
    global $log, $now, $db, $tablepre, $nosta, $areanum, $plsinfo;
    extract($data, EXTR_REFS);

    $itm = & ${'itm' . $itmn};
    $itmk = & ${'itmk' . $itmn};
    $itme = & ${'itme' . $itmn};
    $itms = & ${'itms' . $itmn};
    $itmsk = & ${'itmsk' . $itmn};
    $itmpara_raw = & ${'itmpara' . $itmn};
    $itmpara = get_itmpara($itmpara_raw);

    if (empty($itmpara['IsQuestItem'])) return false;

    $qid = isset($itmpara['QuestID']) ? $itmpara['QuestID'] : '';
    $action = isset($itmpara['QuestAction']) ? $itmpara['QuestAction'] : '';
    if (empty($qid)) return false;

    quest_init_state($clbpara);

    // Q1: summon target
    if ($qid == 'Q1' && $action == 'summon') {
        if (empty($clbpara['quest']['active']['Q1'])) {
            $log .= '你沒有正在進行的獵殺任務。<br>';
            return true;
        }
        $npc_id = quest_spawn_npc('Q1', $data, 'hunt');
        if ($npc_id) {
            $clbpara['quest']['active']['Q1']['linked_npc_id'] = $npc_id;
            $clbpara['quest']['active']['Q1']['step'] = 2;
            $clbpara['quest']['active']['Q1']['step_desc'] = '擊殺目標並完成任務';
            $log .= '目標已亂入戰場。<br>';
        }
        if ($itms != $nosta) $itms--;
        return true;
    }

    // Q2: summon protected NPC
    if ($qid == 'Q2' && $action == 'summon') {
        if (empty($clbpara['quest']['active']['Q2'])) {
            $log .= '你沒有正在進行的護送任務。<br>';
            return true;
        }
        $npc_id = quest_spawn_npc('Q2', $data, 'protect', array('buff_level' => 1));
        if ($npc_id) {
            $clbpara['quest']['active']['Q2']['linked_npc_id'] = $npc_id;
            $clbpara['quest']['active']['Q2']['buff_level'] = 1;
            $clbpara['quest']['active']['Q2']['step'] = 1;
            $clbpara['quest']['active']['Q2']['step_desc'] = '守護目標並維持其存活';
            // 同步守护道具 / Sync guard item
            quest_spawn_item('q2_guard', $data, array('LinkedNPCID' => $npc_id, 'BuffLevel' => 1));
            $log .= '保護目標已現身。<br>';
        }
        if ($itms != $nosta) $itms--;
        return true;
    }

    // Q2: guard item
    if ($qid == 'Q2' && $action == 'guard') {
        if (empty($clbpara['quest']['active']['Q2'])) {
            $log .= '你沒有正在進行的護送任務。<br>';
            return true;
        }
        $linked_npc = !empty($itmpara['LinkedNPCID']) ? $itmpara['LinkedNPCID'] : 0;
        if (empty($linked_npc) || !quest_is_npc_alive($linked_npc)) {
            $log .= '目標已不在戰場，任務失敗。<br>';
            quest_fail('Q2', $data, 'protected_npc_dead');
            return true;
        }

        $npcdata = fetch_playerdata_by_pid($linked_npc);
        $npcdata['clbpara'] = get_clbpara($npcdata['clbpara']);
        $buff_level = !empty($itmpara['BuffLevel']) ? intval($itmpara['BuffLevel']) : 1;
        $hp_cost = max(10, $buff_level * 5);
        $heal = max(20, $buff_level * 10);
        if ($hp <= $hp_cost) {
            $log .= '你的生命不足，無法繼續守護。<br>';
            return true;
        }
        $hp -= $hp_cost;
        $npcdata['hp'] = min($npcdata['mhp'], $npcdata['hp'] + $heal);
        $buff_level = min(9, $buff_level + 1);
        $itmpara['BuffLevel'] = $buff_level;
        $itmpara_raw = json_encode($itmpara, JSON_UNESCAPED_UNICODE);
        $log .= "你分擔了{$hp_cost}點生命，目標恢復了{$heal}點生命。<br>";

        // 更新NPC状态 / Update NPC
        $npcdata['clbpara']['buff_level'] = $buff_level;
        $db->query("UPDATE {$tablepre}players SET hp='{$npcdata['hp']}', clbpara='".json_encode($npcdata['clbpara'], JSON_UNESCAPED_UNICODE)."' WHERE pid='{$linked_npc}'");

        // 达到成功条件
        list($questcfg,) = quest_get_config();
        $ban_success = !empty($questcfg['Q2']['ban_success']) ? $questcfg['Q2']['ban_success'] : 1;
        if ($areanum >= $ban_success) {
            $clbpara['quest']['active']['Q2']['ready_to_claim'] = 1;
            $clbpara['quest']['active']['Q2']['step_desc'] = '目標存活，返回交付任務';
            // 变更为领奖道具 / Convert to reward item
            $reward = get_questiteminfo();
            if (!empty($reward['q2_reward'])) {
                $itm = $reward['q2_reward']['itm'];
                $itmk = $reward['q2_reward']['itmk'];
                $itme = $reward['q2_reward']['itme'];
                $itmsk = $reward['q2_reward']['itmsk'];
                $itmpara_raw = json_encode($reward['q2_reward']['itmpara'], JSON_UNESCAPED_UNICODE);
            }
        }
        return true;
    }

    // Q2: reward
    if ($qid == 'Q2' && $action == 'reward') {
        if (!empty($clbpara['quest']['active']['Q2']) && !empty($clbpara['quest']['active']['Q2']['ready_to_claim'])) {
            quest_complete('Q2', $data);
            if ($itms != $nosta) $itms--;
        } else {
            $log .= '護送任務尚未完成。<br>';
        }
        return true;
    }

    // Q3: stat check
    if ($qid == 'Q3' && $action == 'check') {
        list($questcfg,) = quest_get_config();
        $req = !empty($questcfg['Q3']['requirements']) ? $questcfg['Q3']['requirements'] : array();
        $pass = true;
        if (!empty($req['min_att']) && $att < $req['min_att']) $pass = false;
        if (!empty($req['min_def']) && $def < $req['min_def']) $pass = false;
        if (!empty($req['min_ss']) && $ss < $req['min_ss']) $pass = false;
        if ($pass) {
            quest_complete('Q3', $data);
            if ($itms != $nosta) $itms--;
        } else {
            $log .= '檢驗未通過，尚需努力。<br>';
        }
        return true;
    }

    // Q4: summon phantom
    if ($qid == 'Q4' && $action == 'summon') {
        // 检查任务是否激活 / Check if quest is active
        if (empty($clbpara['quest']['active']['Q4'])) {
            $log .= '你沒有正在進行的昔日重現任務。<br>';
            return true;
        }
        list($questcfg,) = quest_get_config();
        $target_pls = !empty($questcfg['Q4']['target_pls']) ? $questcfg['Q4']['target_pls'] : 0;
        if (!empty($target_pls) && $pls != $target_pls) {
            $log .= '此地沒有任何迴響。<br>';
            return true;
        }
        $npc_id = quest_spawn_npc('Q4', $data, 'phantom', array(), array('pls' => $pls));
        if ($npc_id) {
            $clbpara['quest']['active']['Q4']['linked_npc_id'] = $npc_id;
            $clbpara['quest']['active']['Q4']['step'] = 2;
            $clbpara['quest']['active']['Q4']['step_desc'] = '以花束安撫幻影';
            // 发放花束道具 / Spawn flower item for comfort action
            quest_spawn_item('q4_flower', $data);
            $log .= '幻影在你眼前浮現。<br>';
        }
        if ($itms != $nosta) $itms--;
        return true;
    }

    // Q5: summon subject
    if ($qid == 'Q5' && $action == 'summon') {
        if (empty($clbpara['quest']['active']['Q5'])) {
            $log .= '你沒有正在進行的救贖任務。<br>';
            return true;
        }
        $npc_id = quest_spawn_npc('Q5', $data, 'purify');
        if ($npc_id) {
            $clbpara['quest']['active']['Q5']['linked_npc_id'] = $npc_id;
            $clbpara['quest']['active']['Q5']['step'] = 1;
            $clbpara['quest']['active']['Q5']['step_desc'] = '削弱實驗體並淨化';
            quest_spawn_item('q5_purifier', $data, array('LinkedNPCID' => $npc_id));
            $log .= '實驗體已出現。<br>';
        }
        if ($itms != $nosta) $itms--;
        return true;
    }

    // Q5: purify item (out of battle)
    if ($qid == 'Q5' && $action == 'purify') {
        $linked_npc = !empty($itmpara['LinkedNPCID']) ? $itmpara['LinkedNPCID'] : 0;
        if ($linked_npc && quest_is_npc_alive($linked_npc)) {
            $npcdata = fetch_playerdata_by_pid($linked_npc);
            list($questcfg,) = quest_get_config();
            $threshold = !empty($questcfg['Q5']['hp_threshold']) ? $questcfg['Q5']['hp_threshold'] : 20;
            if ($npcdata['hp'] <= round($npcdata['mhp'] * $threshold / 100)) {
                quest_complete('Q5', $data);
                if ($itms != $nosta) $itms--;
                return true;
            }
        }
        $log .= '實驗體仍過於狂暴，尚無法淨化。<br>';
        return true;
    }

    // Q6: clue
    if ($qid == 'Q6' && $action == 'clue') {
        if (empty($clbpara['quest']['active']['Q6'])) {
            $log .= '你沒有正在進行的躲貓貓任務。<br>';
            return true;
        }

        list($questcfg,) = quest_get_config();
        $need = !empty($questcfg['Q6']['candy_need']) ? intval($questcfg['Q6']['candy_need']) : 3;
        $need = max(1, $need);
        $qstate = &$clbpara['quest']['active']['Q6'];
        $progress = isset($qstate['progress']) ? intval($qstate['progress']) : 0;
        if ($progress >= $need) {
            $log .= '你已經收集齊了糖果，可以直接交付任務。<br>';
            return true;
        }

        // 同一时间只允许一个躲猫猫目标，防止重复使用眼镜刷出多个NPC。
        // Only one hide-and-seek target may exist at a time to prevent duplicate NPC spawns.
        $linked_npc = !empty($qstate['linked_npc_id']) ? intval($qstate['linked_npc_id']) : 0;
        if ($linked_npc && quest_is_npc_alive($linked_npc)) {
            $target_name = isset($qstate['target_pls'], $plsinfo[$qstate['target_pls']])
                ? $plsinfo[$qstate['target_pls']] : '某個地方';
            $log .= '偵探眼鏡顯示：搗蛋鬼仍然藏在'.$target_name.'。<br>';
            return true;
        }

        // 旧绑定目标已不存在时，重新定位属于免费替代，不再消耗充能。
        // Relocating a missing linked target is a free replacement, not a new charge.
        $is_replacement = $linked_npc > 0;
        $plslist = array_values(get_safe_plslist());
        if (empty($plslist)) {
            $log .= '偵探眼鏡暫時找不到安全的藏身處。<br>';
            return true;
        }
        $target_pls = $plslist[array_rand($plslist)];
        $npc_id = quest_spawn_npc('Q6', $data, 'hide', array(), array('pls' => $target_pls));
        if ($npc_id) {
            $qstate['target_pls'] = $target_pls;
            $qstate['linked_npc_id'] = $npc_id;
            $qstate['step'] = 1;
            $qstate['step_desc'] = '尋找第'.($progress + 1).'/'.$need.'個搗蛋鬼';
            $log .= '偵探眼鏡顯示：搗蛋鬼藏在'.$plsinfo[$target_pls].'。<br>';
            // NPC生成失败时不消耗道具，避免任务永久卡住。
            // Consume a charge only after the NPC was spawned successfully.
            quest_q6_consume_clue_charge($itms, $nosta, $is_replacement);
        } else {
            $log .= '偵探眼鏡沒有鎖定目標，請稍後再試。<br>';
        }
        return true;
    }

    // Q6: candy (turn in)
    if ($qid == 'Q6' && $action == 'candy') {
        list($questcfg,) = quest_get_config();
        $need = !empty($questcfg['Q6']['candy_need']) ? $questcfg['Q6']['candy_need'] : 3;
        if ($itms >= $need) {
            $itms -= $need;
            quest_complete('Q6', $data);
            if ($itms <= 0 && $itms != $nosta) {
                $itm = $itmk = $itmsk = $itmpara_raw = '';
                $itme = $itms = 0;
            }
        } else {
            $log .= '糖果數量不足。<br>';
        }
        return true;
    }

    // Q7: summon idol
    if ($qid == 'Q7' && $action == 'summon') {
        if (empty($clbpara['quest']['active']['Q7'])) {
            $log .= '你沒有正在進行的握手會任務。<br>';
            return true;
        }
        $npc_id = quest_spawn_npc('Q7', $data, 'idol');
        if ($npc_id) {
            $clbpara['quest']['active']['Q7']['linked_npc_id'] = $npc_id;
            $clbpara['quest']['active']['Q7']['step_desc'] = '完成應援挑戰';
            $log .= '偶像來到戰場，準備開始應援。<br>';
        }
        if ($itms != $nosta) $itms--;
        return true;
    }

    // Reward items: consume to finalize
    if ($action == 'reward') {
        if ($itms != $nosta) $itms--;
        $log .= '你提交了任務憑證。<br>';
        return true;
    }

    return true;
}
