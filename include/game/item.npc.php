<?php

if (! defined('IN_GAME')) {
    exit('Access Denied');
}

/**
 * 处理NPC相关物品
 * 这些物品会影响NPC的生成、移动等
 *
 * @param int $itmn 物品在物品栏中的位置
 * @param array &$data 玩家数据
 */
function item_npc($itmn, &$data) {
    global $log, $now, $db, $tablepre, $hack, $gamevars;
    extract($data, EXTR_REFS);

    $itm = & ${'itm' . $itmn};
    $itmk = & ${'itmk' . $itmn};
    $itme = & ${'itme' . $itmn};
    $itms = & ${'itms' . $itmn};
    $itmsk = & ${'itmsk' . $itmn};

    if ($itm == '杏仁豆腐的ID卡') {
        include_once GAME_ROOT . './include/system.func.php';
        $duelstate = duel($now, $itm);
        if ($duelstate == 50) {
            $log .= "<span class=\"yellow\">你使用了{$itm}。</span><br><span class=\"evergreen\">“幹得不錯呢，看來咱應該專門為你清掃一下戰場……”</span><br><span class=\"evergreen\">“所有的NPC都離開戰場了。好好享受接下來的殺戮吧，祝你好運。”</span>——林無月<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        } elseif ($duelstate == 51) {
            $log .= "你使用了<span class=\"yellow\">{$itm}</span>，不過什麼反應也沒有。<br><span class=\"evergreen\">“咱已經幫你準備好舞台了，請不要要求太多哦。”</span>——林無月<br>";
        } else {
            $log .= "你使用了<span class=\"yellow\">{$itm}</span>，不過什麼反應也沒有。<br><span class=\"evergreen\">“表演的時機還沒到呢，請再忍耐一下吧。”</span>——林無月<br>";
        }
    } elseif ($itm == '挑戰者之印') {
        include_once GAME_ROOT . './include/system.func.php';
        $log .= '你已經呼喚了幻影執行官，現在尋找並擊敗他們，<br>並且搜尋他們的ID卡吧！<br>';
        addnpc(7, 0, 1);
        addnpc(7, 1, 1);
        addnpc(7, 2, 1);
        if ($clbpara['randver1'] < 64){
            $log .= '【DEBUG】你觸發了測試內容！<br>新機制執行官已額外部署進戰場！<br>現在尋找並擊敗他們，<br>並且搜尋他們的ID卡吧！<br>';
            addnpc(7, 3, 1);
            addnpc(7, 4, 1);
            addnpc(7, 5, 1);
        }
        addnews($now, 'secphase', $name, $nick);
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '挑戰者之印Ⅱ') {
        include_once GAME_ROOT . './include/system.func.php';
        $log .= '你已經呼喚了幻影執行官，現在尋找並擊敗他們，<br>並且搜尋他們的ID卡吧！<br>';
        addnpc(7, 3, 1);
        addnpc(7, 4, 1);
        addnpc(7, 5, 1);
        addnews($now, 'secphase', $name, $nick);
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '破滅之詩') {
        $rp = 0;
        $clbpara['dialogue'] = 'thiphase';
        $clbpara['console'] = 1;
        $clbpara['achvars']['thiphase'] += 1;
        include_once GAME_ROOT . './include/system.func.php';
        $log .= '在你唱出那單一的旋律的霎那，<br>整個虛擬世界起了翻天覆地的變化……<br>';
        addnpc(4, 0, 1);
        include_once GAME_ROOT . './include/game/item2.func.php';
        $log .= '世界響應着這旋律，產生了異變……<br>';
        wthchange($itm, $itmsk);
        addnews($now, 'thiphase', $name, $nick);
        $hack = 1;
        $gamevars['apis'] = $gamevars['api'] = 3;
        $log .= '因為破滅之歌的作用，全部鎖定被打破了！<br>';
        movehtm();
        addnews($now, 'hack2', $name, $nick);
        save_gameinfo();
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '黑色碎片') {
        include_once GAME_ROOT . './include/system.func.php';
        $log .= '你已經呼喚了一個未知的存在，現在尋找並擊敗她，<br>並且搜尋她的遊戲解除鑰匙吧！<br>';
        addnews($now, 'dfphase', $name, $nick);
        addnpc(12, 0, 1);

        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '✦鑰匙碎片') {
        include_once GAME_ROOT . './include/system.func.php';
        $log .= '嗯……？只有碎片也能用嗎？<br>好像將一小部分NPC部署進了遊戲內……<br>';
        //思念体 4*3
        addnpc(2, 0, 2);
        addnpc(2, 1, 2);
        addnpc(2, 2, 2);
        addnpc(2, 3, 2);
        addnpc(2, 4, 2);
        addnpc(2, 5, 2);
        addnpc(2, 6, 2);
        addnpc(2, 7, 2);
        addnews($now, 'key0', $name, $nick);
        $itms--;
        if ($itms <= 0) destory_single_item($data, $itmn, 1);
    } elseif ($itm == '✦NPC鑰匙·一階段') {
        include_once GAME_ROOT . './include/system.func.php';
        $log .= '已解鎖一階段NPC！<br>似乎大量NPC已經部署至遊戲內……<br>';
        //职人 1*6
        addnpc(11, 0, 1);
        addnpc(11, 1, 1);
        addnpc(11, 2, 1);
        addnpc(11, 3, 1);
        addnpc(11, 4, 1);
        addnpc(11, 5, 1);
        //妖精幻象 1*3
        addnpc(13, 0, 1);
        addnpc(13, 1, 1);
        addnpc(13, 2, 1);
        addnews($now, 'key1', $name, $nick);
        $itms--;
        if ($itms <= 0) {
            $log .= "<span class=\"red\">$itm</span>用光了。<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }
    } elseif ($itm == '✦✦NPC鑰匙·二階段') {
        include_once GAME_ROOT . './include/system.func.php';
        $log .= '已解鎖二階段NPC！<br>似乎兇惡NPC已經部署至遊戲內……<br>';
        //杏仁豆腐 2*2
        addnpc(5, 0, 1);
        addnpc(5, 1, 1);
        addnpc(5, 0, 1);
        addnpc(5, 1, 1);
        //猴子 1*2
        addnpc(6, 0, 1);
        addnpc(6, 0, 1);
        //假蓝凝
        addnpc(9, 0, 1);
        addnews($now, 'key2', $name, $nick);
        $itms--;
        if ($itms <= 0) {
            $log .= "<span class=\"red\">$itm</span>用光了。<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }
    } elseif ($itm == '✦種火鑰匙') {
        include_once GAME_ROOT . './include/system.func.php';
        $log .= '雖然不知道你究竟想幹啥，<br>但總之你放出了更多的種火……<br>';
        //种火 5*10
        addnpc(92, 0, 10);
        addnpc(92, 1, 10);
        addnpc(92, 2, 10);
        addnpc(92, 3, 10);
        addnpc(92, 4, 10);
        addnews($now, 'key3', $name, $nick);
        $itms--;
        if ($itms <= 0) {
            $log .= "<span class=\"red\">$itm</span>用光了。<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }
    } elseif ($itm == '✦【自律AI呼喚器】') {
        //Call in 30 type 93 NPCs, 6 each.
        //get player's 1st Yume value - different value results in different NPC.
        //There are 5 sets - K, C, G, P, D.
        include_once GAME_ROOT . './include/system.func.php';
        $log .= '你將這根權杖一般的鑰匙狠狠插在了地面上，<br>很快，大批NPC就從空中降落到了戰場上！<br>';
        if ($clbpara['randver1'] < 21) {
            // 1st set - WK High School Oni Girls
            addnpc(93, 0, 6);
            addnpc(93, 1, 6);
            addnpc(93, 2, 6);
            addnpc(93, 3, 6);
            addnpc(93, 4, 6);
        } elseif ($clbpara['randver1'] < 42) {
            // 2nd set - WC Idol Magical Girls
            addnpc(93, 5, 6);
            addnpc(93, 6, 6);
            addnpc(93, 7, 6);
            addnpc(93, 8, 6);
            addnpc(93, 9, 6);
        } elseif ($clbpara['randver1'] < 63) {
            // 3rd set - WG Mecha Girls
            addnpc(93, 10, 6);
            addnpc(93, 11, 6);
            addnpc(93, 12, 6);
            addnpc(93, 13, 6);
            addnpc(93, 14, 6);
        } elseif ($clbpara['randver1'] < 84) {
            // 4th set - WP Martial Arts Girls
            addnpc(93, 15, 6);
            addnpc(93, 16, 6);
            addnpc(93, 17, 6);
            addnpc(93, 18, 6);
            addnpc(93, 19, 6);
        } else {
            // 5th set - WD Explosive Girls
            addnpc(93, 20, 6);
            addnpc(93, 21, 6);
            addnpc(93, 22, 6);
            addnpc(93, 23, 6);
            addnpc(93, 24, 6);
        }
        addnews($now, 'key4', $name, $nick);
        $itms--;
        if ($itms <= 0) {
            $log .= "<span class=\"red\">$itm</span>用光了。<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }
        } elseif ($itm == '【我想要領略真正的紅殺之力】') {
            // 召唤红暮与蓝凝（从旧版逻辑迁移，恢复原有功能）
            include_once GAME_ROOT . './include/system.func.php';
            $log .= '你拿起了這個球狀物體，重重地向天空拋去！<br>地圖上空出現了紅殺組織的龍虎徽標！<br>';
            addnpc(19, 0, 1);
            addnpc(19, 1, 1);
            // 发布新闻：需要将当前位置传入c参数以显示【地点】
            addnews($now, 'keyuu', $name, '', $pls, $nick);
            // 系统广播
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('2','$now','【紅暮】','','切，真是少見的要求，那麼我會在【無月之影】等着你們的挑戰！')");
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('2','$now','【藍凝】','','英雄就該姍姍來遲，我會和姐姐一起迎接你們！')");
            // 销毁物品
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;

    }
}
