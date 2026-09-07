<?php

if (! defined('IN_GAME')) {
    exit('Access Denied');
}

/**
 * 处理武器改造类物品
 * 
 * @param int $itmn 物品在物品栏中的位置
 * @param array &$data 玩家数据
 */
function item_weapon_mod($itmn, &$data) {
    global $log, $nosta, $now;
    extract($data, EXTR_REFS);
    
    $itm = & ${'itm' . $itmn};
    $itmk = & ${'itmk' . $itmn};
    $itme = & ${'itme' . $itmn};
    $itms = & ${'itms' . $itmn};
    $itmsk = & ${'itmsk' . $itmn};
    
    if (strpos($itm, '磨刀石') !== false) {
        if (strpos($wepk, 'K') == 1 && strpos($wepsk, 'Z') === false) {
            if (strpos($wepsk, 'j') !== false) {
                $log .= '多重武器不能改造。<br>';
                return;
            }
            $dice = rand(0, 100);
            if ($dice >= 15) {
                if ($clbpara['BGMBrand'] == 'crimson') {
                    $check = diceroll(20);
                    if ($check > 17) {
                        $log .= "<span class=\"ltcrimson\">你想到了紅暮揮舞紅殺鐵劍的英姿，<br>手上的刀磨得更快了！<br></span>";
                        $wepe += $check;
                    }
                }
                $wepe += $itme;                    
                $log .= "使用了<span class=\"yellow\">$itm</span>，<span class=\"yellow\">$wep</span>的攻擊力變成了<span class=\"yellow\">$wepe</span>。<br>";
                if (strpos($wep, '鋒利的') === false) {
                    $wep = '鋒利的'.$wep;
                }
            } else {
                $wepe -= ceil($itme / 2);
                if ($wepe <= 0) {
                    $log .= "<span class=\"red\">$itm</span>使用失敗，<span class=\"red\">$wep</span>損壞了！<br>";
                    $wep = $wepk = $wepsk = '';
                    $wepe = $weps = 0;
                } else {
                    $log .= "<span class=\"red\">$itm</span>使用失敗，<span class=\"red\">$wep</span>的攻擊力變成了<span class=\"red\">$wepe</span>。<br>";
                }
            }
            
            $itms--;
        } elseif(strpos($wepsk, 'Z') !== false) {
            $log .= '咦……刀刃過於薄了，感覺稍微磨一點都會造成不可逆的損傷呢……<br>';
        } else {
            $log .= '你沒裝備鋭器，不能使用磨刀石。<br>';
        }
    } elseif (preg_match("/釘$/", $itm) || preg_match("/釘\[/", $itm)) {
        // 码语行人，$club==21的时候不能使用钉子
        if ($club == 21) {
            $log .= "<span class=\"yellow\">突然，你的眼前出現了扭曲的字符！</span><br>";
            $log .= "<span class=\"glitchb\">
            “凌亂陳言省略號，<br>
            數值爆炸知多少？<br>
            玩家以外用不到，<br>
            出了問題再來找！”<br></span><br>";
            $log .= "<span class=\"yellow\">唔，看起來這個釘子對你似乎沒有什麼意義……</span><br>";
            return;
        } elseif ((strpos($wep, '棍棒') !== false) && ($wepk == 'WP')) {
            if (strpos($wepsk, 'j') !== false) {
                $log .= '多重武器不能改造。<br>';
                return;
            }
            $dice = rand(0, 100);
            if ($dice >= 10) {
                if ($clbpara['BGMBrand'] == 'crimson') {
                    $check = diceroll(20);
                    if ($check > 17) {
                        $log .= "<span class=\"ltcrimson\">你想到了紅暮揮舞紅殺鐵錘的英姿，<br>手上的釘子打得更快了！<br><span>";
                        $wepe += $check;
                    }
                }
                $wepe += $itme;
                $log .= "使用了<span class=\"yellow\">$itm</span>，<span class=\"yellow\">$wep</span>的攻擊力變成了<span class=\"yellow\">$wepe</span>。<br>";
                if (strpos($wep, '釘') === false) {
                    $wep = str_replace('棍棒', '釘棍棒', $wep);
                }
            } else {
                $wepe -= ceil($itme / 2);
                if ($wepe <= 0) {
                    $log .= "<span class=\"red\">$itm</span>使用失敗，<span class=\"red\">$wep</span>損壞了！<br>";
                    $wep = $wepk = $wepsk = '';
                    $wepe = $weps = 0;
                } else {
                    $log .= "<span class=\"red\">$itm</span>使用失敗，<span class=\"red\">$wep</span>的攻擊力變成了<span class=\"red\">$wepe</span>。<br>";
                }
            }
            
            $itms--;
        } else {
            $log .= '你沒裝備棍棒，不能安裝釘子。<br>';
        }
    } elseif ($itm == '針線包') {
        // 码语行人，$club==21的时候不能使用针线包
        if ($club == 21) {
            $log .= "<span class=\"yellow\">突然，你的眼前出現了扭曲的字符！</span><br>";
            $log .= "<span class=\"glitchb\">
            “冷汗直流小問號，<br>
            防禦堆到多少好？<br>
            與其數值罩白夢，<br>
            不如讓她轉生了！”<br></span><br>";
            $log .= "<span class=\"yellow\">唔，看起來這個針線包對你似乎沒有什麼意義……</span><br>";
            return;
        } elseif (($arb == $noarb) || !$arb) {
            $log .= '你沒有裝備防具，不能使用針線包。<br>';
        } elseif(strpos($arbsk, '^') !== false) {
            $log .= '<span class="yellow">你不能對揹包使用針線包。<br>';
        } elseif(strpos($arbsk, 'Z') !== false) {
            $log .= '<span class="yellow">該防具太單薄以至於不能使用針線包。</span><br>你感到一陣蛋疼菊緊，你的蛋疼度增加了<span class="yellow">233</span>點。<br>';
        } else {
            if ($clbpara['BGMBrand'] == 'rimefire') {
                $check = diceroll(20);
                if ($check > 17) {
                    $log .= "<span class=\"orange\">你突然腦海中浮現了一位青年徹夜優化裝甲的英姿，<br>手上的針線打得更快了！<br></span>";
                    $arbe += $check;
                }
            }
            $arbe += (rand(0, 2) + $itme);
            $log .= "用<span class=\"yellow\">$itm</span>給防具打了補丁，<span class=\"yellow\">$arb</span>的防禦力變成了<span class=\"yellow\">$arbe</span>。<br>";
            $itms--;
        }
    } elseif ($itm == '天然呆四面的獎賞') {
        // 码语行人，$club==21的时候不能使用天然呆四面的奖赏
        if ($club == 21) {
            $log .= "<span class=\"yellow\">突然，你的眼前出現了扭曲的字符！</span><br>";
            $log .= "<span class=\"glitchb\">
            “無語無言點句號，<br>
            第四牆外看不到！<br>
            無法干涉即取消，<br>
            反正一個也不少！<br>”</span><br>";
            $log .= "<span class=\"yellow\">唔，看起來這個奇怪的物品對你似乎沒有什麼意義……</span><br>";
            return;
        }
        if (!$weps || !$wepe) {
            $log .= '請先裝備武器。<br>';
            return;
        }
        if (strpos($wepsk, 'j') !== false) {
            $log .= '多重武器不能改造。<br>';
            return;
        }
        if (strpos($wepsk, 'O') !== false) {
            $log .= '進化武器不能改造。<br>';
            return;
        }
        $log .= "使用了<span class='yellow'>天然呆四面的獎賞</span>。<br>";
        $log .= "你召喚了<span class='lime'>天然呆四面</span>對你的武器進行改造！<br>";
        addnews($now, 'newwep', $name, $itm, $wep, $nick);
        $dice = rand(0, 99);
        if ($dice < 70) {
            $log .= "<span class='lime'>天然呆四面</span>把你的武器弄壞了！<br>";
            $log .= "你的武器變成了一塊廢鐵！<br>";
            $log .= "<span class='lime'>“不小心把你的武器弄壞了，還真是對不起呢……<br>";
            $wep = "一塊廢鐵"; $wepk = "WP"; $wepe = 1; $weps = 1; $wepsk = "";
            $log .= "那麼…… 給你點補償吧，請務必收下。”<br></span>";
            $itm = ""; $itmk = ""; $itme = 0; $itms = 0; $itmsk = "";
            $dice2 = rand(0, 99);
            $itm0 = '四面親手製作的■DeathNote■'; $itmk0 = 'Y'; $itme0 = 1; $itms0 = 1; $itmsk0 = 'z';
            include_once GAME_ROOT . './include/game/itemmain.func.php';
            itemget($data);
        } else if ($dice < 90) {
            $log .= "<span class='lime'>天然呆四面</span>把玩了一會兒你的武器。<br>";
            $log .= "你的武器的耐久似乎稍微多了一點。<br>";
            if (strpos($wep, '-改') === false) $wep = $wep . '-改';
            $weps += ceil($wepe / 200);
            $itm = ""; $itmk = ""; $itme = 0; $itms = 0; $itmsk = "";
        } else {
            $log .= "<span class='lime'>天然呆四面</span>把玩了一會兒你的武器。<br>";
            $log .= "你的武器似乎稍微變強了一點。<br>";
            if (strpos($wep, '-改') === false) $wep = $wep . '-改';
            $wepe += ceil($wepe / 200);
            $itm = ""; $itmk = ""; $itme = 0; $itms = 0; $itmsk = "";
        }
    } elseif ($itm == '武器師安雅的獎賞') {
        // 码语行人，$club==21的时候不能使用武器师安雅的奖赏
        if ($club == 21) {
            $log .= "<span class=\"yellow\">突然，你的眼前出現了扭曲的字符！</span><br>";
            $log .= "<span class=\"glitchb\">
            “奇詭無比省略號，<br>
            奇葩捏他哪裏找？<br>
            橫豎都是用不上。<br>
            看我直接註釋掉！”<br></span><br>";
            $log .= "<span class=\"yellow\">唔，看起來武器師安雅的獎賞對你似乎沒有什麼意義……</span><br>";
            return;
        } elseif (!$weps || !$wepe) {
            $log .= '請先裝備武器。<br>';
            return;
        }
        if (strpos($wepsk, 'j') !== false) {
            $log .= '多重武器不能改造。<br>';
            return;
        }
        $dice = rand(0, 99);
        $dice2 = rand(0, 99);
        $skill = array('WP' => $wp, 'WK' => $wk, 'WG' => $wg, 'WC' => $wc, 'WD' => $wd, 'WF' => $wf);
        $skill_advanced = array('WJ' => $wg, 'WB' => $wc);
        arsort($skill);
        $skill_keys = array_keys($skill);
        $skill_advanced_keys = array_keys($skill_advanced);            
        $nowsk = substr($wepk, 0, 2);
        if (strlen($wepk) > 2) $subsk = 'W'.$wepk[2];
        $maxsk = $skill_keys[0];
        // 复合武器只要其中一个类别是最高就不会改系
        // 上位武器熟练超过1200不会改系，可能算加强六系称号
        if (((!in_array($nowsk, $skill_advanced_keys) && ($skill[$nowsk] != $skill[$maxsk]) && (empty($subsk) || ((!empty($subsk) && !in_array($subsk, $skill_advanced_keys) && ($skill[$subsk] != $skill[$maxsk]))))) || (in_array($nowsk, $skill_advanced_keys) && ($skill_advanced[$nowsk] < 1200))) && ($dice < 30)) {
            $wepk = substr_replace($wepk, $maxsk, 0, 2);
            $kind = "更改了{$wep}的<span class=\"yellow\">類別</span>！";
        } elseif (($weps != $nosta) && ($dice2 < 70)) {
            $weps += ceil($wepe / 2);
            $kind = "增強了{$wep}的<span class=\"yellow\">耐久</span>！";
        } else {
            $wepe += ceil($wepe / 2);
            $kind = "提高了{$wep}的<span class=\"yellow\">攻擊力</span>！";
        }
        $log .= "你使用了<span class=\"yellow\">$itm</span>，{$kind}";
        addnews($now, 'newwep', $name, $itm, $wep, $nick);
        if (strpos($wep, '-改') === false) {
            $wep = $wep . '-改';
        }
        $itms--;
    } elseif ($itm == '『靈魂寶石』' || $itm == '『祝福寶石』') {
        global $cmd, $mode;
        //码语行人，$club==21的时候不能使用宝石
        if ($club == 21) {
            $log .= "<span class=\"yellow\">突然，你的眼前出現了扭曲的字符！</span><br>";
            $log .= "<span class=\"glitchb\">
            “糾結糾結小問號，<br>
            代碼溢出怎麼搞？<br>
            乾脆一刀禁了它。<br>
            反正捱打不用愁！”<br></span><br>";
            $log .= "<span class=\"yellow\">唔，看起來這個寶石對你似乎沒有什麼意義……</span><br>";
            return;
        }
        $cmd = '<input type="hidden" name="mode" value="item"><input type="hidden" name="usemode" value="qianghua"><input type="hidden" name="itmp" value="' . $itmn . '">你想強化哪一件裝備？<br><input type="radio" name="command" id="menu" value="menu" checked><a onclick=sl("menu"); href="javascript:void(0);" >返回</a><br><br><br>';
        for ($i = 1; $i <= 6; $i++) {
            //global ${'itmsk' . $i};
            if ((strpos(${'itmsk' . $i}, 'Z') !== false) && (strpos(${'itm' . $i}, '寶石』') === false)) {
                //global ${'itm' . $i}, ${'itme' . $i}, ${'itms' . $i};
                $cmd .= '<input type="radio" name="command" id="itm' . $i . '" value="itm' . $i . '"><a onclick=sl("itm' . $i . '"); href="javascript:void(0);" >' . "{${'itm' .$i}}/{${'itme' .$i}}/{${'itms' .$i}}" . '</a><br>';
              $flag = true;
            }
        }
        $cmd .= '<br><br><input type="button" onclick="postCmd(\'gamecmd\',\'command.php\');" value="提交">';
        if (! $flag) {
            $log .='唔？你的包裹裏沒有可以強化的裝備，是不是沒有脱下來呢？DA☆ZE<br><br>';
        }else{
            $log .="寶石在你的手上發出異樣的光芒，似乎有個奇怪的女聲在你耳邊説道<span class=\"yellow\">\"我是從天界來的凱麗\"</span>.";
        }
        // 不要设置mode，让二级菜单显示
        return;
    } elseif ($itm == '水果刀') {
        $flag = false;
        
        for($i = 1; $i <= 6; $i ++) {
            //global ${'itm' . $i}, ${'itmk' . $i},${'itms' . $i},${'itme' . $i},$wk;
            if (strpos(${'itmsk' . $i}, '🍎') !== false) {
                if($wk >= 120){
                    $log .= "練過刀就是好啊。你嫺熟地削着果皮。<br><span class=\"yellow\">{${'itm'.$i}}</span>變成了<span class=\"yellow\">★殘骸★</span>！<br>咦為什麼會出來這種東西？算了還是不要吐槽了。<br>";
                    ${'itm' . $i} = '★殘骸★';
                    ${'itme' . $i} *= rand(2,4);
                    ${'itms' . $i} *= rand(3,5);
                    ${'itmsk' . $i} = '';
                    $flag = true;
                    $wk++;
                }else{
                    $log .= "想削皮吃<span class=\"yellow\">{${'itm'.$i}}</span>，沒想到削完發現只剩下一堆果皮……<br>手太笨拙了啊。<br>";
                    $brackets_arr = Array('☆☆','★★','〖〗','【】','『』','「」','✦✦','☾☽','☼☼','■■');
                    $if_brackets = 0;
                    foreach ($brackets_arr as $brackets)
                    {
                        if ((mb_substr(${'itm' . $i}, 0, 1)).(mb_substr(${'itm' . $i}, -1)) === $brackets){
                            $if_brackets = 1;
                            ${'itm' . $i} = mb_substr(${'itm' . $i}, 0, -1).'皮'.mb_substr(${'itm' . $i}, -1);
                            break;
                        }							
                    }
                    if ($if_brackets == 0) ${'itm' . $i} = ${'itm' . $i}.'皮';
                    ${'itmk' . $i} = 'TN';
                    ${'itms' . $i} *= rand(2,4);
                    ${'itmsk' . $i} = '';
                    $flag = true;
                    $wk++;
                }
                break;
            }
            if($flag == true) {break;};
        }
        if (! $flag) {
            $log .= '包裹裏沒有水果。<br>';
        } else {
            $dice = rand(1,5);
            if($dice==1){
                $log .= "<span class=\"red\">$itm</span>變鈍了，無法再使用了。<br>";
                $itm = $itmk = $itmsk = '';
                $itme = $itms = 0;
            }
        }
    }
}
