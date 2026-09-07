<?php

if (! defined('IN_GAME')) {
    exit('Access Denied');
}

/**
 * 处理合成物品
 * 这些物品会触发特殊的合成机制
 * 
 * @param int $itmn 物品在物品栏中的位置
 * @param array &$data 玩家数据
 */
function item_synthesis($itmn, &$data) {
    global $log, $db, $tablepre, $now, $plsinfo;
    extract($data, EXTR_REFS);
    
    $itm = & ${'itm' . $itmn};
    $itmk = & ${'itmk' . $itmn};
    $itme = & ${'itme' . $itmn};
    $itms = & ${'itms' . $itmn};
    $itmsk = & ${'itmsk' . $itmn};
    
    if ($itmk == 'ZA') {
        if ($itm == '→【單兵撤退按鈕】←') {
            $log .= "你按下了這個按鈕。<br>但似乎什麼都沒有發生。<br>按鈕就這樣消失了。<br>在你覺得你買到了假冒偽劣產品時，你聽到了來自紅暮的廣播。<br>";
            // 销毁物品
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('2','$now','【紅暮】','','如果你們發現了什麼帶有異樣顏色的代碼斷片，千萬別合成它們，老實帶過來給我就行。')");
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('2','$now','【紅暮】','','大家請注意，虛擬幻境系統似乎遭到了來自不明人士的入侵。')");
            // 播撒合成用物品
            $kitm1 = "［ＩＮＮＯＣＥＮＣＥ］";
            $kitm2 = "［ＤＩＬＩＧＥＮＣＥ］";
            $kitm3 = "［ＣＯＮＳＣＩＥＮＣＥ］";
            $rndpls1 = rand(1, count($plsinfo) - 2);
            $rndpls2 = rand(1, count($plsinfo) - 2);
            $rndpls3 = rand(1, count($plsinfo) - 2);
            $db->query("INSERT INTO {$tablepre}mapitem (itm, itmk, itme, itms, itmsk, pls) VALUES ('$kitm1', 'XA', '1', '1', '', '$rndpls1')");
            $db->query("INSERT INTO {$tablepre}mapitem (itm, itmk, itme, itms, itmsk, pls) VALUES ('$kitm2', 'XA', '1', '1', '', '$rndpls2')");
            $db->query("INSERT INTO {$tablepre}mapitem (itm, itmk, itme, itms, itmsk, pls) VALUES ('$kitm3', 'XA', '1', '1', '', '$rndpls3')");
            $plsname1 = $plsinfo[$rndpls1];
            $plsname2 = $plsinfo[$rndpls2];
            $plsname3 = $plsinfo[$rndpls3];
            $log .= "然後，你聽到了來自藍凝的私聊——<br><span class=\"clan\">【藍凝】就給你一些提示吧，你需要找到三個代碼斷片進行合成：{$kitm1}，{$kitm2}與{$kitm3}，它們分別位於{$plsname1}，{$plsname2}與{$plsname3}。<br>【藍凝】別謝我，問就是我免貴姓雷了。祝你好運！</span>";
            $log .= "<br>看起來，在脱出幻境之前，你需要玩一把尋寶遊戲了……";
        } elseif ($itm == '→【神器任意門】←') {
            $log .= "你將這個門扉種在了地上。<br>但門扉突然消失了。<br>在你覺得你撿到了個笑話時，你聽到了來自紅暮的廣播。<br>";
            // 销毁物品
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('2','$now','【紅暮】','','如果你們發現了什麼帶有異樣顏色的代碼斷片，千萬別合成它們，老實帶過來給我就行。')");
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('2','$now','【紅暮】','','大家請注意，虛擬幻境系統似乎遭到了來自不明人士的入侵。')");
            // 播撒合成用物品
            $kitm1 = "［ΨТОВХ］";
            $kitm2 = "［ЫΑИЙВХΨ］";
            $kitm3 = "［ΩЙΑТΨ］";
            $rndpls1 = rand(1, count($plsinfo) - 2);
            $rndpls2 = rand(1, count($plsinfo) - 2);
            $rndpls3 = rand(1, count($plsinfo) - 2);
            $db->query("INSERT INTO {$tablepre}mapitem (itm, itmk, itme, itms, itmsk, pls) VALUES ('$kitm1', 'XB', '1', '1', '', '$rndpls1')");
            $db->query("INSERT INTO {$tablepre}mapitem (itm, itmk, itme, itms, itmsk, pls) VALUES ('$kitm2', 'XB', '1', '1', '', '$rndpls2')");
            $db->query("INSERT INTO {$tablepre}mapitem (itm, itmk, itme, itms, itmsk, pls) VALUES ('$kitm3', 'XB', '1', '1', '', '$rndpls3')");
            $plsname1 = $plsinfo[$rndpls1];
            $plsname2 = $plsinfo[$rndpls2];
            $plsname3 = $plsinfo[$rndpls3];
            $log .= "然後，你聽到了來自不明人士的私聊——<br><span class=\"lime\">【？？？】就給你一些提示吧，你需要找到三個代碼斷片進行合成：{$kitm1}，{$kitm2}與{$kitm3}，它們分別位於{$plsname1}，{$plsname2}與{$plsname3}。<br>【？？？】祝你好運！</span>";
            $log .= "<br>看起來，在脱出幻境之前，你需要玩一把尋寶遊戲了……";
        } else {
            $log .= "你啓動了單人脱出機構。<br>";
            // 销毁物品
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('2','$now','【紅暮】','','如果你們發現了什麼帶有異樣顏色的代碼斷片，千萬別合成它們，老實帶過來給我就行。')");
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('2','$now','【紅暮】','','大家請注意，虛擬幻境系統似乎遭到了來自不明人士的入侵。')");
            // 播撒合成用物品
            $kitm1 = "［ｒｍ］";
            $kitm2 = "［－ｒ］";
            $kitm3 = "［－ｆ］";
            $rndpls1 = rand(1, count($plsinfo) - 2);
            $rndpls2 = rand(1, count($plsinfo) - 2);
            $rndpls3 = rand(1, count($plsinfo) - 2);
            $db->query("INSERT INTO {$tablepre}mapitem (itm, itmk, itme, itms, itmsk, pls) VALUES ('$kitm1', 'XC', '1', '1', '', '$rndpls1')");
            $db->query("INSERT INTO {$tablepre}mapitem (itm, itmk, itme, itms, itmsk, pls) VALUES ('$kitm2', 'XC', '1', '1', '', '$rndpls2')");
            $db->query("INSERT INTO {$tablepre}mapitem (itm, itmk, itme, itms, itmsk, pls) VALUES ('$kitm3', 'XC', '1', '1', '', '$rndpls3')");
            $plsname1 = $plsinfo[$rndpls1];
            $plsname2 = $plsinfo[$rndpls2];
            $plsname3 = $plsinfo[$rndpls3];
            $log .= "然後，你聽到了來自不明人士的私聊——<br><span class=\"lime\">【？？？】就給你一些提示吧，你需要找到三個代碼斷片進行合成：{$kitm1}，{$kitm2}與{$kitm3}，它們分別位於{$plsname1}，{$plsname2}與{$plsname3}。<br>【？？？】祝你好運！</span>";
            $log .= "<br>看起來，在脱出幻境之前，你需要玩一把尋寶遊戲了……";
        }
    }
}
