<?php

if(!defined('IN_GAME')) {
    exit('Access Denied');
}

/**
 * 处理nouveau版本中加入的特殊物品
 * 包括鱼篓子等
 *
 * @param int $itmn 物品在物品栏中的位置
 * @param array &$data 玩家数据
 * @return bool 是否成功处理
 */
function item_nouveau_booster1($itmn, &$data) {
    global $log, $mode, $cmd, $command, $nosta;
    extract($data, EXTR_REFS);

    // 如果是选择鱼篓子中的物品
    if ($command == 'choose_fish' && isset($clbpara['fish_basket'])) {
        // 获取鱼篓子的位置和物品
        $basket_position = $clbpara['fish_basket']['position'];
        $basket_items = $clbpara['fish_basket']['items'];

        // 获取选择的物品索引
        $chosen_index = isset($_POST['choose']) ? intval($_POST['choose']) : -1;

        if ($chosen_index < 0 || !isset($basket_items[$chosen_index])) {
            $log .= '你沒有選擇任何物品，或者選擇的物品不存在。<br>';
            $mode = 'command';
            $cmd = '';
            return true;
        }

        // 获取选择的物品
        $chosen_item = $basket_items[$chosen_index];

        // 将物品放入玩家物品栏
        global $itm0, $itmk0, $itme0, $itms0, $itmsk0, $itmpara0;
        $itm0 = $chosen_item['itm'];
        $itmk0 = $chosen_item['itmk'];
        $itme0 = $chosen_item['itme'];
        $itms0 = $chosen_item['itms'];
        $itmsk0 = $chosen_item['itmsk'];
        $itmpara0 = isset($chosen_item['itmpara']) ? $chosen_item['itmpara'] : '';

        // 从鱼篓子中移除该物品
        unset($basket_items[$chosen_index]);

        // 重新索引数组
        $basket_items = array_values($basket_items);

        // 更新鱼篓子
        if (empty($basket_items)) {
            // 如果鱼篓子为空，移除它
            $log .= '你從魚簍子中取出了<span class="yellow">' . $itm0 . '</span>。<br>';
            $log .= '魚簍子已經空了，你將它丟棄了。<br>';

            ${'itm'.$basket_position} = '';
            ${'itmk'.$basket_position} = '';
            ${'itme'.$basket_position} = 0;
            ${'itms'.$basket_position} = 0;
            ${'itmsk'.$basket_position} = '';
            ${'itmpara'.$basket_position} = '';
        } else {
            // 更新鱼篓子的内容
            ${'itme'.$basket_position} = count($basket_items); // 更新容量
            ${'itms'.$basket_position} = count($basket_items); // 更新已使用空间
            ${'itmpara'.$basket_position} = json_encode($basket_items, JSON_UNESCAPED_UNICODE);

            $log .= '你從魚簍子中取出了<span class="yellow">' . $itm0 . '</span>。<br>';
            $log .= '魚簍子中還有 ' . count($basket_items) . ' 件物品。<br>';
        }

        // 清除临时数据
        unset($clbpara['fish_basket']);

        // 调用物品获取函数
        include_once GAME_ROOT.'./include/game/itemmain.func.php';
        itemget($data);

        $mode = 'command';
        $cmd = '';
        return true;
    }

    // 如果是打开鱼篓子
    $itm = ${'itm' . $itmn};
    $itmk = ${'itmk' . $itmn};
    $itmsk = ${'itmsk' . $itmn};
    $itmpara = ${'itmpara' . $itmn};

    if ($itm == '魚簍子' && $itmk == 'Z' && $itmsk == 'Z') {
        // 解析鱼篓子中的物品
        $basket_items = json_decode($itmpara, true);
        if (!$basket_items || empty($basket_items)) {
            $log .= '這個魚簍子是空的！<br>';
            return true;
        }

        // 设置为特殊模式，显示鱼篓子界面
        $mode = 'fish_basket';
        $cmd = '';

        // 保存鱼篓子的位置，以便后续处理
        $clbpara['fish_basket'] = array(
            'position' => $itmn,
            'items' => $basket_items
        );

        // 返回 true，表示已经处理了鱼篓子
        return true;
    }

    // 处理技能书物品
    if ($itmk == 'VS') {
        // 现实逃避论 ～风中残烛之卷：获得奇机技能
        if ($itm == '現實逃避論～風中殘燭之卷' && $itmsk == 'tl_2ndchance') {
            global $cskills, $now;
            $flag = getclubskill('tl_2ndchance', $clbpara);
            if ($flag) {
                $log .= "你仔細閲讀了<span class='red'>{$itm}</span>，書中詳細描述了在危機時刻如何保持最後一絲生機的秘訣。<br>";
                $log .= "哇！沒想到這本書裏竟然介紹了<span class='yellow'>「{$cskills['tl_2ndchance']['name']}」</span>的原理！<br>";
                $log .= "獲得了技能<span class='yellow'>「{$cskills['tl_2ndchance']['name']}」</span>！<br>";
                $log .= "你心滿意足地把<span class='red'>{$itm}</span>吃進了肚裏。<br>";
                //addnews($now, 'getsk_tl_2ndchance', $name, $itm, $nick);
            } else {
                $log .= "什麼嘛！原來裏面都是些你看過的東西了，你沒有從書中學到任何新東西。<br>";
                $log .= "你一怒之下把這本破書撕了個稀巴爛！<br>";
            }

                // 消耗物品
                ${'itm'.$itmn} = '';
                ${'itmk'.$itmn} = '';
                ${'itmsk'.$itmn} = '';
                ${'itme'.$itmn} = 0;
                ${'itms'.$itmn} = 0;
                ${'itmpara'.$itmn} = '';


            return true;
        }

        // 现实逃避论 ～一转攻势之卷：获得起迹技能
        if ($itm == '現實逃避論～一轉攻勢之卷' && $itmsk == 'tl_oncemore') {
            global $cskills, $now;
            $flag = getclubskill('tl_oncemore', $clbpara);
            if ($flag) {
                $log .= "你仔細閲讀了<span class='red'>{$itm}</span>，書中詳細描述瞭如何在生死一線之際轉危為安的秘訣。<br>";
                $log .= "哇！沒想到這本書裏竟然介紹了<span class='yellow'>「{$cskills['tl_oncemore']['name']}」</span>的原理！<br>";
                $log .= "獲得了技能<span class='yellow'>「{$cskills['tl_oncemore']['name']}」</span>！<br>";
                $log .= "你心滿意足地把<span class='red'>{$itm}</span>吃進了肚裏。<br>";
                //addnews($now, 'getsk_tl_oncemore', $name, $itm, $nick);
            } else {
                $log .= "什麼嘛！原來裏面都是些你看過的東西了，你沒有從書中學到任何新東西。<br>";
                $log .= "你一怒之下把這本破書撕了個稀巴爛！<br>";
            }

            // 消耗物品
            ${'itm'.$itmn} = '';
            ${'itmk'.$itmn} = '';
            ${'itmsk'.$itmn} = '';
            ${'itme'.$itmn} = 0;
            ${'itms'.$itmn} = 0;
            ${'itmpara'.$itmn} = '';

            return true;
        }

        // 现实逃避论 ～全卷：同时获得奇机和起迹技能
        if ($itm == '現實逃避論～全卷' ) {
            global $cskills, $now;
            $flag1 = getclubskill('tl_2ndchance', $clbpara);
            $flag2 = getclubskill('tl_oncemore', $clbpara);

            if ($flag1 || $flag2) {
                $log .= "你仔細閲讀了<span class='red'>{$itm}</span>，這是一本完整的生存指南，詳細描述瞭如何在絕境中求生的各種技巧。<br>";

                if ($flag1) {
                    $log .= "哇！沒想到這本書裏竟然介紹了<span class='yellow'>「{$cskills['tl_2ndchance']['name']}」</span>的原理！<br>";
                    $log .= "獲得了技能<span class='yellow'>「{$cskills['tl_2ndchance']['name']}」</span>！<br>";
                    //addnews($now, 'getsk_tl_2ndchance', $name, $itm, $nick);
                }

                if ($flag2) {
                    $log .= "哇！沒想到這本書裏竟然還介紹了<span class='yellow'>「{$cskills['tl_oncemore']['name']}」</span>的原理！<br>";
                    $log .= "獲得了技能<span class='yellow'>「{$cskills['tl_oncemore']['name']}」</span>！<br>";
                    //addnews($now, 'getsk_tl_oncemore', $name, $itm, $nick);
                }

                $log .= "你心滿意足地把<span class='red'>{$itm}</span>吃進了肚裏。<br>";
            } else {
                $log .= "什麼嘛！原來裏面都是些你看過的東西了，你沒有從書中學到任何新東西。<br>";
                $log .= "你一怒之下把這本破書撕了個稀巴爛！<br>";
            }

            // 消耗物品
            ${'itm'.$itmn} = '';
            ${'itmk'.$itmn} = '';
            ${'itmsk'.$itmn} = '';
            ${'itme'.$itmn} = 0;
            ${'itms'.$itmn} = 0;
            ${'itmpara'.$itmn} = '';

            return true;
        }
    }

    // 核子核心武器改造物品
    if ($itm == '☢核子核心☢' && $itmk == 'Y') {
        // 检查是否装备了武器
        if (empty($wep) || $weps == 0) {
            $log .= "你必須裝備武器才能使用<span class='red'>{$itm}</span>。<br>";
            return true;
        }

        // 正确获取当前武器的itmpara数据 - 使用get_itmpara函数确保正确解析
        $weapon_para = get_itmpara($weppara);

        // 如果武器已经是核武器，则不能再次改造
        if (!empty($weapon_para['isNuclearWeapon'])) {
            $log .= "你的<span class='yellow'>{$wep}</span>已經是核武器了，不需要再次改造。<br>";
            return true;
        }

        // 添加isNuclearWeapon键值
        $weapon_para['isNuclearWeapon'] = 1;

        // 更新武器的itmpara数据
        $weppara = $weapon_para;

        // 更新武器名称 - 避免重复添加☢符号
        if (strpos($wep, '☢') === false) {
            $wep = "☢" . $wep;
        }

        $log .= "你將<span class='red'>{$itm}</span>安裝到了你的武器上。<br>";
        $log .= "你的武器變成了<span class='yellow'>{$wep}</span>！現在它可以對戰鬥區域內的所有人造成傷害了。<br>";

        // 消耗物品
        ${'itm'.$itmn} = '';
        ${'itmk'.$itmn} = '';
        ${'itmsk'.$itmn} = '';
        ${'itme'.$itmn} = 0;
        ${'itms'.$itmn} = 0;
        ${'itmpara'.$itmn} = '';

        return true;
    }

    // 如果没有匹配的物品，返回 false
    return false;
}

?>
