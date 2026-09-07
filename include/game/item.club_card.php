<?php

if (! defined('IN_GAME')) {
    exit('Access Denied');
}

/**
 * 处理社团卡物品
 * 这些物品会改变玩家的社团属性
 * 
 * @param int $itmn 物品在物品栏中的位置
 * @param array &$data 玩家数据
 */
function item_club_card($itmn, &$data) {
    global $log, $db, $tablepre, $now, $elements_info, $sparkle;
    extract($data, EXTR_REFS);
    
    $itm = & ${'itm' . $itmn};
    $itmk = & ${'itmk' . $itmn};
    $itme = & ${'itme' . $itmn};
    $itms = & ${'itms' . $itmn};
    $itmsk = & ${'itmsk' . $itmn};
    
    if ($itmk == 'ZB') { // 社团卡
        if ($club) {
            $log .= "你已經是有身份的人了！不能再使用稱號卡。<br>";
            $db->query("INSERT INTO {$tablepre}shopitem (kind,num,price,area,item,itmk,itme,itms,itmsk) VALUES ('18','1','20','0','$itm','$itmk','$itme','$itms','$itmsk')");
            $log .= "<span class='yellow'>$itm</span>像是有生命一般從你的手上脱離，飛回了商店！";
        }
        // 处理不能成为合法社团的情况
        elseif ($itme == 15) { // L5状态
            $log .= "【DEBUG】進入L5狀態<br>";
            $log .= '你突然感覺到一種不可思議的力量貫通全身！<br>';
            $wp = $wk = $wg = $wc = $wd = $wf = 8010;
            $att = $def = 13337;
            changeclub(15, $data);
            addnews($now, 'suisidefail', $name, $nick);
        } elseif ($itme == 17 || $itme > 22) { // 状态机社团以及不存在的社团
            $log .= "但是什麼都沒有發生！";
        } elseif ($itme == 20) { // 元素大师特殊处理
            // 规则怪谈类型文案
            $log .= "你拿起<span class='yellow'>$itm</span>左右端詳着……<br>
            然後，它突然就在你的眼前消失了！<br>
            在你尋思着出了什麼事情之後，你的面前突然多了幾條類似於規則的玩意。<br>
            【特殊程序·元素大師使用規則】<br>
            <br>
            【其之一】這世上的一切都由六種元素組成。<br>
            【其之二】每種元素都能組成一種武器或防具。<br>
            【其之三】當你撿到物品後，便可將其提煉成元素。<br>
            【其之四】此外，看起來沒有用的屍體也可被提煉，不過後果自負。<br>
            【其之五】提煉時偶爾會蹦出特殊信息，最好將它們記錄下來。<br>
            【其之六】提煉出的元素，可以通過「元素合成」產出各種物品。<br>
            【其之七】相對是這個世界的攝理之一，如果過於追求數字，就無法體現特殊性。<br>
            正在你讀着這些規則的時候，它們也在你的眼前慢慢消失……<br>";
            $log .= "最後變成了一個<span class='sparkle'>{$sparkle}元素口袋{$sparkle}</span>！<br>";
            $log .= "在你將這個口袋收起來時，突然胸口一緊，你的眼前跳出了更多的文字：<br>
            【其之零】在D.T.S.的虛擬環境中，不存在將物品單純地放在一起就能合成的手段。<br>
            然後，一行新的文字替代了這條規則：<br>
            【其之零】一切都是數字的假象而已。<br>
            正在你回味着這句話的時候，一切已經恢復如初。";
            // 社团变更
            changeclub(20, $data);
            // 获取初始元素与第一条配方
            $dice = rand(0, 5);
            $dice2 = rand(0, 1);
            $dice3 = rand(0, 3);
            ${'element' . $dice} += 500 + $dice;
            $clbpara['elements'] = Array();
            $clbpara['elements']['tags'] = Array($dice => Array('dom' => Array(0 => 1), 'sub' => Array(0 => 1)));
            $clbpara['elements']['info']['d']['d1'] = 1;
            // 初始化元素合成缓存文件
            include_once GAME_ROOT . './include/game/elementmix.func.php';
            emix_spawn_info();
        } elseif ($itme == 21) { // 码语行人特殊处理
            // Let's have some fun !
            $clbpara['dialogue'] = 'club21entry';
            // 社团变更
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('0','$now','$name','','「Ρжжηψψρип ρип, ρжжηψψρжжρип ρип」')");
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('0','$now','$name','','「ρψψρип ρип, ρип ρип ρжжηψψρжж ρδ」')");
            changeclub(21, $data);
            // And we inflict some pretty damage as entry fee.
            $hp = $hp / 3;
            $sp = 1;
        } elseif ($itme == 22) { // 偶像大师特殊处理
            //$log .= "再等等吧……<br>";
            $clbpara['dialogue'] = 'club22entry';
            changeclub(22, $data);
        } else { // 直接将社团卡的效果写入玩家club
            changeclub($itme, $data);
            $log .= "你的稱號被改動了！";
        }
        // 销毁物品
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    }
}
