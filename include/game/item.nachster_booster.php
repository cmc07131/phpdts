<?php

if (! defined('IN_GAME')) {
    exit('Access Denied');
}

/**
 * 處理nachster版本中加入的雜項物品
 * 包括小葉子的妙妙箱、歌單系列、人生重來炮等
 * 
 * @param int $itmn 物品在物品欄中的位置
 * @param array &$data 玩家數據
 */
function item_nachster_booster($itmn, &$data) {
    global $log, $db, $tablepre, $now, $plsinfo, $event_bgm, $elements_info, $nosta;
    extract($data, EXTR_REFS);
    
    $itm = & ${'itm' . $itmn};
    $itmk = & ${'itmk' . $itmn};
    $itme = & ${'itme' . $itmn};
    $itms = & ${'itms' . $itmn};
    $itmsk = & ${'itmsk' . $itmn};
    
    if ($itm == '小葉子的妙妙箱') {
        // A multiuse item that will provide various of items for you, mainly traps.
        // However, there will be an increasing possibity that this item will self-explode.
        // And when it does, there will also be a possibity that you'll lose HP and SP.
        // Very low chance of insta-death.

        // init itm0.
        $itm0 = '';
        $itmk0 = '';
        $itme0 = 0;
        $itms0 = 0;
        $itmsk0 = '';
        $itmpara = '';

        // Par 低維生物's suggestion, the explode-rate will be stored in its $itmsk.
        $log .= "你下定決心，打開了這個可疑的<span class='yellow'>$itm</span>，開始翻找起來……<br>";
        // Getting the item's current self-destruct rate.
        $harukaBoxExplodeRate = intval($itmsk);
        // Generate a random number based on the user's 1st Yume value.
        $harukaBoxCheck = diceroll($clbpara['randver1']);

        if ($harukaBoxCheck <= 17) {
            // Get random low-mid effect trap.
            $log .= "你從裏面翻找出了看起來能作為<span class='yellow'>略微有趣的陷阱</span>的東西！<br>";

            $itm0 = '略微有趣的玻璃珠';
            $itmk0 = 'TN';
            $itme0 = diceroll($clbpara['randver1']);
            $itms0 = diceroll(5);
            $itmsk0 = '';
            // 確保效果值和耐久值不會為0
            if ($itme0 == 0) {
                $itme0 = 1;
            }
            if ($itms0 == 0) {
                $itms0 = 1;
            }
        } elseif ($harukaBoxCheck <= 23) {
            // Get random HB item.
            $log .= "你從裏面翻找出了看起來能作為<span class='yellow'>有趣的補給</span>的東西！<br>";

            $itm0 = '有趣的零食';
            $itmk0 = 'HB';
            $itme0 = diceroll($clbpara['randver1']) * diceroll(3);
            $itms0 = diceroll(17);
            $itmsk0 = 'z';
            // 確保效果值和耐久值不會為0
            if ($itme0 == 0) {
                $itme0 = 1;
            }
            if ($itms0 == 0) {
                $itms0 = 1;
            }
        } elseif ($harukaBoxCheck <= 42) {
            // Get random mid effect true damage trap.
            $log .= "你從裏面翻找出了看起來能作為<span class='yellow'>精心製作的陷阱</span>的東西！<br>";

            $itm0 = '精心製作的玻璃珠陣';
            $itmk0 = 'TNt';
            $itme0 = diceroll($clbpara['randver2']);
            $itms0 = diceroll(5);
            $itmsk0 = '';
            // 確保效果值和耐久值不會為0
            if ($itme0 == 0) {
                $itme0 = 1;
            }
            if ($itms0 == 0) {
                $itms0 = 1;
            }
        } elseif ($harukaBoxCheck <= 61) {
            // Get random high effect trap.
            $log .= "你從裏面翻找出了看起來能作為<span class='yellow'>非常有趣的陷阱</span>的東西！<br>";

            $itm0 = '非常有趣的玻璃珠';
            $itmk0 = 'TN';
            $itme0 = diceroll($clbpara['randver3']);
            $itms0 = diceroll(5);
            $itmsk0 = '';
            // 確保效果值和耐久值不會為0
            if ($itme0 == 0) {
                $itme0 = 1;
            }
            if ($itms0 == 0) {
                $itms0 = 1;
            }
        } elseif ($harukaBoxCheck <= 80) {
            // Get random percent damage trap.
            $log .= "你從裏面翻找出了看起來能作為<span class='yellow'>十分強力的陷阱</span>的東西！<br>";

            $itm0 = '強而有力的玻璃珠';
            $itmk0 = 'TN8';
            $itme0 = 1;
            $itms0 = diceroll(2);
            $itmsk0 = 'x';
            // 確保耐久值不會為0
            if ($itms0 == 0) {
                $itms0 = 1;
            }
        } elseif ($harukaBoxCheck <= 109) {
            // Get high true damage trap.
            $log .= "你從裏面翻找出了看起來能作為<span class='yellow'>精心製作的可怕陷阱</span>的東西！<br>";

            $itm0 = '精心製作的可怕玻璃珠陣';
            $itmk0 = 'TNt';
            $itme0 = diceroll($clbpara['randver3']);
            $itms0 = diceroll(5);
            $itmsk0 = '';
            // 確保效果值和耐久值不會為0
            if ($itme0 == 0) {
                $itme0 = 1;
            }
            if ($itms0 == 0) {
                $itms0 = 1;
            }
        } else {
            // Get Chaos Normal Trap.
            $log .= "你從裏面翻找出了一些<span class='yellow'>不可名狀</span>的東西！<br>它似乎可以當作陷阱使用……<br>";

            $itm0 = '不可名狀之物';
            $itmk0 = 'TN';
            $itme0 = diceroll(114514);
            $itms0 = diceroll(69);
            $itmsk0 = '';
            // 確保效果值和耐久值不會為0
            if ($itme0 == 0) {
                $itme0 = 1;
            }
            if ($itms0 == 0) {
                $itms0 = 1;
            }
        }

        // Troll the player if itms0 somehow rolled an 0. YSK: I encountered that 4 times in a row.
        if ($itms0 == 0) {
            $log .= "然而，<span class='yellow'>$itm0</span>卻伴隨着一陣少女銀鈴般的笑聲，<br>在你的手上化作一陣青煙消失了！<br>靠！<br>";
            $itm0 = '';
            $itmk0 = '';
            $itme0 = 0;
            $itms0 = 0;
            $itmsk0 = '';

            // Refund some of explode rate.
            //$harukaBoxCheck -= 30;
        }

        // Add to explode rate.
        $harukaBoxExplodeRate += $harukaBoxCheck;
        if ($harukaBoxExplodeRate < 667) {
            $log .= "<span class='yellow'>妙妙箱不懷好意地顫抖了一下。</span>但最終什麼都沒發生！<br>";
            // Write explode rate back to itmsk.
            $itmsk = strval($harukaBoxExplodeRate);
        } else {
            // BOOM!!
            $log .= "<span class='yellow'>妙妙箱不懷好意地顫抖了一下。</span>然後華麗地在你的手上炸開了！<br>";
            // Destroy this item.
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
            // Also Destroy item0.
            $itm0 = $itmk0 = $itmsk0 = '';
            $itme0 = $itms0 = 0;                
            // Get damage.
            $harukaBoxDamage = diceroll($clbpara['randver2']) * (diceroll(3) + 1);
            // Calculate Damage.
            if ($hp < $harukaBoxDamage) {
                $dflag = diceroll(1024);
                if ($dflag > 1020) {
                    // YOU WA SHOCK!!
                    include_once GAME_ROOT . './include/state.func.php';
                    $log .= '你在一片火焰中失去了知覺。<br>';
                    death('event', '', 0, $itm);
                } else {
                    $log .= "你受到了<span class='yellow'>巨大的</span>傷害！你感覺你整個人都要折在這裏了！<br>";
                    $hp = 1;
                    $sp = 1;
                }
            } else {
                $hp -= $harukaBoxDamage;
                $sp -= $harukaBoxDamage;
                if ($sp < 1) {
                    $sp = 1;
                }
                $log .= "你受到了<span class='yellow'>$harukaBoxDamage</span>點傷害！<br>";
                $inf .= 'a';
                $log .= "你的雙手也被炸得血肉模糊！真是不幸啊！<br>";
            }
        }
    } elseif ($itm == '隨機數之神的庇佑') {
        $log .= "你將<span class='yellow'>$itm</span>捧在手心……<br>
        突然，從天上傳來一個慵懶的聲音：<br>
        <span class=\"blueseed\">“現在還沒到我的上班時間呢！”<br>
        “不過既然你提前抽出來了，我也給你點好處，那麼載入既定事項……”</span><br>
        然後你看到天上出現了一行字：【實行L5改造】<br>";
        $log .= '你突然感覺到一種不可思議的力量貫通全身！<br>';
        $wp = $wk = $wg = $wc = $wd = $wf = 8010;
        $att = $def = 13337;
        //$club = 15; 因為是神力嘛！↓但是下面這個還是要適用的。
        addnews($now, 'suisidefail', $name, $nick);
        // 銷燬物品
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '【歌單】紅暮') {
        // Songlists. They change your BGM, but more importantly...
        // They place a Brand on your character named BGMBrand in $clbpara.
        // It will have various hidden effects, search for BGMBrand for details.

        if ($clbpara['BGMBrand'] == 'rixolamal') {
            $log .= "一種神奇的力量阻止了音樂播放器的啓動！<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }

        $log .= "你打開了手上的音樂播放器，裏面傳出了這樣的聲音：<br>
        <span class=\"ltcrimson\">”你的選擇很不錯，我這裏為你準備了一些勁爆的搖滾樂。<br>
        一定能讓你在這場戰鬥中熱血沸騰的。”——紅暮<br><br></span>
        <span class=\"yellow\">你的音樂播放列表被替換了！<br></span>";
        $clbpara['event_bgmbook'] = $event_bgm['crimsontracks'];
        $clbpara['BGMBrand'] = 'crimson';
        // Destroy this item.
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '【歌單】藍凝') {
        if ($clbpara['BGMBrand'] == 'rixolamal') {
            $log .= "一種神奇的力量阻止了音樂播放器的啓動！<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }

        $log .= "你打開了手上的音樂播放器，裏面傳出了這樣的聲音：<br>
        <span class=\"ltazure\">”姐姐似乎給你準備了搖滾樂，但我覺得還是我的更好一點。<br>
        這些歌曲都是上個年代的流行曲風，夢幻般的人聲和幻境也更相稱吧？<br>
        欸？你説這不就僅僅是音樂，沒有人聲麼？為什麼會這樣呢？”——藍凝<br><br></span>
        <span class=\"yellow\">你的音樂播放列表被替換了！<br></span>";
        if ($clbpara['randver1'] < 64) {
            $clbpara['event_bgmbook'] = $event_bgm['altazuretracks'];
        } else {
            $clbpara['event_bgmbook'] = $event_bgm['azuretracks'];
        }
        $clbpara['BGMBrand'] = 'azure';
        // Destroy this item.
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '【歌單】芙蓉') {
        if ($clbpara['BGMBrand'] == 'rixolamal') {
            $log .= "一種神奇的力量阻止了音樂播放器的啓動！<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }

        $log .= "你打開了手上的音樂播放器，裏面傳出了這樣的聲音：<br>
        <span class=\"tmagenta\">”幹我們這行的，得時刻保持冷靜優雅。<br>
        所以我給你準備了古典音樂，確切地説，是李斯特的《巡禮之年》第一部。<br>
        這可是被人稱作是李斯特的大成之作的作品，Enjoy~”——芙蓉<br><br></span>
        <span class=\"ltcrimson\">”……做好身份隔離，芙蓉。”——紅暮<br><br></span>
        <span class=\"yellow\">你的音樂播放列表被替換了！<br></span>";
        $clbpara['event_bgmbook'] = $event_bgm['fleurtracks'];
        $clbpara['BGMBrand'] = 'fleur';
        // Destroy this item.
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '【歌單】丁香') {
        if ($clbpara['BGMBrand'] == 'rixolamal') {
            $log .= "一種神奇的力量阻止了音樂播放器的啓動！<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }

        $log .= "你打開了手上的音樂播放器，裏面傳出了這樣的聲音：<br>
        <span class=\"clan\">”欸？我也要提交一批歌單嗎……？<br>
        那麼我就儘量嘗試一下……<br>
        就這些如何？雖然我覺得這可能不適合這個遊戲吧……”——丁香<br><br></span>
        <span class=\"sienna\">”適合不適合另説，但這起名太差勁了——就地丟棄，請。”——芙蓉<br><br></span>
        <span class=\"yellow\">你的音樂播放列表被替換了！<br></span>";
        $clbpara['event_bgmbook'] = $event_bgm['lilatracks'];
        $clbpara['BGMBrand'] = 'lila';
        // Destroy this item.
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '【歌單】冰炎') {
        if ($clbpara['BGMBrand'] == 'rixolamal') {
            $log .= "一種神奇的力量阻止了音樂播放器的啓動！<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }

        $log .= "你打開了手上的音樂播放器，裏面傳出了這樣的聲音：<br>
        <span class=\"orange\">”虛擬幻境我自然是知道的。高速動作PVP對吧？<br>
        要為這裏提供一點音樂……嗎。<br>
        那麼就來點聽起來很像某馳名遊戲系列的配樂的曲子吧！”——冰炎<br><br></span>
        <span class=\"ltcrimson\">”微妙。”——紅暮<br><br></span>
        <span class=\"yellow\">你的音樂播放列表被替換了！<br></span>";
        $clbpara['event_bgmbook'] = $event_bgm['rimefiretracks'];
        $clbpara['BGMBrand'] = 'rimefire';
        // Destroy this item.
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '【歌單】瑞克·拉瑪爾') {
        $log .= "你打開了手上的音樂播放器，裏面傳出了這樣的聲音：<br>
        <span class=\"orange\">”哦，你是想反叛隨機數大神吧！<br>
        我知道的，搖骰子總是會讓人心潮澎湃，那麼就讓我這位大英雄幫你一把吧！<br>
        音樂是其次，歡迎來到骰子的反叛世界！”——瑞克·拉瑪爾<br><br></span>
        <span class=\"ltcrimson\">”這……這個不是都市傳説麼？快去查一查。”——紅暮<br><br></span>
        <span class=\"yellow\">你的音樂播放列表被替換了！<br></span>";
        $clbpara['event_bgmbook'] = $event_bgm['rixolamaltracks'];
        $clbpara['BGMBrand'] = 'rixolamal';
        // Some init...
        $clbpara['traitorRoll'] = 0;
        // Destroy this item.
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '【歌單】小兔子警報！') {
        if ($clbpara['BGMBrand'] == 'rixolamal') {
            $log .= "一種神奇的力量阻止了音樂播放器的啓動！<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }

        if ($clbpara['touchedByBunny'] == 0) {
            $rp -= 120;
        }
        $log .= "你打開了手上的奇怪物品，裏面傳出了這樣的聲音：<br>
        <span class=\"lime\">”為什麼突然會給遊戲加入歌單這種東西……？<br>
        那麼為了更好地偽裝，我也注入個歌單進來。<br>
        畢竟我平時碼代碼就是聽這些的。順路啦。”——？？？？<br><br></span>
        
        <span class=\"yellow\">你的音樂播放列表被替換了！<br></span>";
        if ($clbpara['randver3'] < 512) {
            $clbpara['event_bgmbook'] = $event_bgm['christracks'];
        } else {
            $log .= "<span class=\"tmagenta\">”哈，抓到你了。<br>順便……這個啊……要用我喜歡的語言來唱。”——芙蓉<br></span>";
            $clbpara['event_bgmbook'] = $event_bgm['altchristracks'];
        }
        $clbpara['BGMBrand'] = 'christine';
        $clbpara['touchedByBunny'] += 1;
        // Destroy this item.
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '【歌單】林無月') {
        if ($clbpara['BGMBrand'] == 'rixolamal') {
            $log .= "一種神奇的力量阻止了你按下按鈕！<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }

        $log .= "你按下了手中遙控器的按鈕。<br>
        <span class=\"yellow\">你重置了你的音樂播放列表！<br></span>";
        unset($clbpara['event_bgmbook']);
        unset($clbpara['BGMBrand']);
        // Destroy this item.
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '人生重來炮') {
        // detect if you are actually able to use this.
        if ($pls > 100) {
            $log .= "你點燃了這門炮的引線，然後嘗試將頭伸進炮筒之中。<br>
            <span class=\"yellow\">但是大炮突然就這麼消失了！這是怎麼回事呢？<br></span>";
            // destroy this item.
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;    
        }
        if ($mhp <= 200) {
            $log .= "你點燃了這門炮的引線，然後嘗試將頭伸進炮筒之中。<br>
            <span class=\"yellow\">但是你體能已經太弱，在成功將頭伸進去之前，大炮就在你面前發射了！<br></span>
            <span class=\"red\">你被炮彈射了一臉，受到了巨大的傷害！<br>";
            $hp = 1;
            // destroy this item.
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;                
        }
        $log .= "你點燃了這門炮的引線，然後迅速將頭伸進了炮筒之中！<br>
        <span class=\"yellow\">只聽轟地一聲，你被炮彈擊出了千米之外，你感覺身體內的什麼東西煥然一新了……<br></span>";
        // Reset... some values...
        $clbpara['randver1'] = rand(1, 128);
        $clbpara['randver2'] = rand(1, 256);
        $clbpara['randver3'] = rand(1, 1024);
        // process damage
        $mhp -= 200;
        $hp = $mhp;
        $msp -= 200;
        $sp = $msp;
        $log .= "<span class=\"red\">你受到了相當的傷害，齜牙咧嘴地站了起來。<br></span>";
        // process area change
        $pls = rand(1, count($plsinfo) - 2);
        // destroy this item.
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
    } elseif ($itm == '善良之刃') {
        // fake a death message.
        $log .= "你覺得這個幻境太過危險，真的呆不下去了！<br>
            <span class=\"yellow\">於是你將這把匕首對着自己，噗嘰一聲就刺了下去！<br></span>";
        // it will require 200+ rage.
        if ($rage <= 200) {
            $log .= "匕首的刀刃卻被彈開了！<br>
            從匕首中傳來了惡意的嘲笑：<br>
            <span class=\"yellow\">”桀桀桀，連自裁的決心都沒有，你還真是個軟蛋！”<br></span>
            你出離憤怒，一腳將匕首踩碎了。<br>
            <br>
            你被整蠱物品嘲諷，非常生氣！<br>";
            $rage = 200;
            // destroy this item.
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        } else {
            $log .= "白刀子進，白刀子出！<br>
            你被中刀的衝擊擊飛，落在了地上。<br>
            好疼。<br>
            <span class=\"yellow\">等下……白刀子……出？<br></span>
            你聽到了你的死亡報告，但還是毫髮無傷地站了起來。<br>
            想死而不能，這可是太遜了……<br>
            你不禁嘆出一口氣。<br>";

            $rage = 0;
            // add fake death news - Event Death.
            addnews($now, 'death13', $name, 0);
            // add fake death chat.
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('3','$now','$name','$pls','我覺得我還可以搶救一下……')");
            // destroy this item.
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }
    }elseif($itm == '😂我太酷啦！😂') {
        $log .= "你毅然決然地高喊了一句：“我·太·酷·啦~”<br>一拳頭錘碎了這個奇形怪狀的按鈕。<br>隨後，在失去意識之前，你感覺你的身體飛上了天空。<br>";
        # Also produce a chatlog
        $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('0','$now','$name','','「我·太·酷·啦~」')");

        # Do an initial coin toss
        $selfdestructdice1 = diceroll(1);
        $selfdestructdice2 = diceroll(6);
        
        if ($selfdestructdice1 > 0){
            # You'll self destruct into a bunch of happy items, to bring smile to others.
            $happyitemname = $name . "的存在意義";
            # Firstly, we look at your stats to see how strong those would be, and how many of them would it be.
            $happyitemeffect = round($mhp / 20);
            $happyitemnumber = round($exp / 20);
            # Then, we look at the dice result to see what would you explode into.
            if ($selfdestructdice2 == 1){
                $happyitemkind = "HH";
            }elseif ($selfdestructdice2 == 2){
                $happyitemkind = "HS";
            }elseif ($selfdestructdice2 == 3){
                $happyitemkind = "PH";
            }elseif ($selfdestructdice2 == 4){
                $happyitemkind = "PS";
            }elseif ($selfdestructdice2 == 5){
                $happyitemkind = "HM";
            }elseif ($selfdestructdice2 == 6){
                $happyitemkind = "TO";
            }else{
                $happyitemkind = "T";
            }

            # Producing a valid arealist
            $rndhappypls= rand(1,count($plsinfo)-2);

            # Process the item insertation process.
            # But, before that, a special treatment for map traps:
            if ($selfdestructdice2 == 6){
                # Insert traps into maptrap table.
                for ($i = 0; $i < $happyitemnumber; $i++){
                    $rndhappypls= rand(1,count($plsinfo)-2);
                    $db->query("INSERT INTO {$tablepre}maptrap (itm, itmk, itme, itms, itmsk, pls) VALUES ('$happyitemname', '$happyitemkind', '$happyitemeffect', '1', '$pid', '$rndhappypls')");
                }
                $log .= "你的身體在高空中炸出了一片煙花。<br>
                在那煙花中，那曾經屬於你的存在落在了幻境的地面上，鑽進了地底下。<br>
                想必，這會為大家帶來驚喜吧……<br>";
            }else{
                # Insert items into mapitem table.
                for ($i = 0; $i < $happyitemnumber; $i++){
                    $rndhappypls= rand(1,count($plsinfo)-2);
                    $db->query("INSERT INTO {$tablepre}mapitem (itm, itmk, itme, itms, itmsk, pls) VALUES ('$happyitemname', '$happyitemkind', '$happyitemeffect', '1', '$pid', '$rndhappypls')");
                }
                $log .= "你的身體在高空中炸出了一片煙花。<br>
                在那煙花中，那曾經屬於你的存在落在了幻境的地面上。<br>
                想必，這會為大家帶來笑容吧……<br>";
            }
            # Then we produce a chat for this feat.
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('2','$now','【幻境自檢】','','檢測到未經授權的地圖物品！')");

        }else{
            # Nothing happens, you just self destruct.
            $log .= "你的身體在高空中炸成了一片煙花，<br>
            給虛擬幻境的天空帶來了五彩的紅霞。<br>
            大家看到這祥瑞的天象，紛紛露出了笑容。<br>
            這大概就是……「笑容世界」吧。<br>
            大逃殺真是塔洛西啊！<br>";	
        }
        # Then we kill you to end everything.
        include_once GAME_ROOT . './include/state.func.php';
        death ( 'sdestruct', '', 0, $itm );
        # But wait, since you exploded, you can't leave a body!
        $db->query ( "UPDATE {$tablepre}players SET weps='0',arbs='0',arhs='0',aras='0',arfs='0',arts='0',itms0='0',itms1='0',itms2='0',itms3='0',itms4='0',itms5='0',itms6='0',money='0' WHERE pid = {$pid} " );
    } elseif($itm == '【我太帥啦！】') {
        # Joke Item, fill the user's bag with garbage items.
        $log .= "按下這個按鈕後，你突然有了一種神奇的想表現自己的慾望，<br>
            <span class=\"minirainbow\">於是你突然從手中具現出了一大堆卡牌，然後自顧自擺起了陣法！</span><br>
            等你回過神來，你發現你的揹包裏面到處都是莫名其妙的卡牌。<br>
            希望這真的值得……<br>";
        $itm1 = '腦內印出的超雷龍-雷龍 ★8'; $itm2 = '腦內印出的命運英雄 毀滅鳳凰人 ★8'; $itm3 = '腦內印出的槍管上膛獰猛龍 ★8'; 
        $itm4 = '勇者衍生物 ★4'; $itm5 = '腦內印出的流離的獅鷲騎手 ★7'; $itm6 = '腦內印出的T.G.超圖書館員 ★5';
        $itme1 = $itme2 = $itme3 = $itme5 = $itme6 = 1;
        $itme4 = 20;
        $itmk1 = $itmk2 = $itmk3 = 'WC08';
        $itms1 = $itms2 = $itms3 = $itms4 = $itms5 = $itms6 = 1;
        $itmk4 = 'WC04'; $itmk5 = 'WC07'; $itmk6 = 'WC05';
        $itmsk1 = $itmsk2 = $itmsk3 = $itmsk4 = $itmsk5 = $itmsk6 = '';
        # Destroy the item.
        //$itm = $itmk = $itmsk = '';
        //$itme = $itms = 0;
        # Sign
        $clbpara['iAmHandsome'] += 1;
    } elseif($itm == '【我太棒啦！】') {
        # Joke Item, shred the user's HP and SP, then convert them into health item.
        $log .= "按下這個按鈕後，你突然覺得你很棒，<br>
        於是舉起雙拳就像大猩猩一樣擂起胸膛。<br>
        <span class=\"minirainbow\">但你用力過猛，感覺體內的什麼東西竟然被吐了出來！</span><br>
        希望這真的值得……<br>";
        $lossdice = diceroll(92);
        $oldhp = $hp;
        $oldsp = $sp;
        $hp = round($hp * ($lossdice / 100));
        $sp = round($sp * ($lossdice / 100));
        $diff = ($oldhp + $oldsp) - ($hp + $sp);

        $itm0 = $name . "的力量";
        $itme0 = $diff;
        $itmk0 = 'HB';
        $itms0 = 1;
        $itmsk0 = '';
        # Destroy the item.
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
        # Sign
        $clbpara['iAmGreat'] += 1;
    } elseif($itm == '【我太強啦！】') {
        # Joke Item, Alerting the position of the user by generate a chatlog and decrease their $mhp by 100.
        if ($mhp < 100) {
            $log .= "你作勢想按下按鈕，但立刻覺得你似乎還不夠強……<br>還是算了吧。<br>";
        }else{
            # Output some log.
            $log .= "按下這個按鈕後，你突然想讓戰場上的各位看到你強大的一面，於是你吐氣揚聲，大吼一句：<br>
            <span class=\"minirainbow\">“我　太　強　啦！”</span><br>
            然而，因為你喊得太用力了，你吐出了一口鮮血！<br>
            <span class=\"minirainbow\">你的最大生命值減少了100點！</span><br>
            希望這真的值得……<br>";
            $mhp -= 100;
            if ($hp>$mhp) $hp = $mhp;
            $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('0','$now','$name','','「我　太　強　啦！」')");
            # Destroy the item.
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
            # Sign
            $clbpara['iAmStrong'] += 1;
        }
    } elseif($itm == '【我太牛啦！】') {
        # Joke Item, Aleating the position of the user, then turn their $mhp and $msp into money.
        $log .= "按下這個按鈕後，你突然覺得你很牛Ｂ。於是你仰天長嘯：<br>
        <span class=\"minirainbow\">“我身上錢很多，快來撩我！”</span><br>
        然後，你覺得眼前一黑，你的身上真的多出了很多錢！<br>
        希望這真的值得……<br>";
        $lossdice = diceroll(98);
        $oldmhp = $mhp;
        $oldmsp = $msp;
        $mhp = round($mhp * ($lossdice / 100));
        $msp = round($msp * ($lossdice / 100));
        $hp = $mhp; $sp = $msp;
        $diff = ($oldmhp + $oldmsp) - ($mhp + $msp);
        $money += $diff;
        $log .= "你的最大生命值和最大體力值被轉換成了<span class=\"yellow\">$diff</span>點金錢！<br>";
        $db->query("INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('0','$now','$name','','「我身上錢很多，快來撩我！」')");
        # Destroy the item.
        $itm = $itmk = $itmsk = '';
        $itme = $itms = 0;
        # Sign
        $clbpara['iAmRich'] += 1;
    } elseif ($itm == '稜鏡八面體'){
        $log .= "你使用了<span class=\"yellow b\">{$itm}</span>。<br>";
        $theitem = array('itm' => &$itm, 'itmk' => &$itmk, 'itme' => &$itme,'itms' => &$itms,'itmsk' => &$itmsk);
        octitem_rotate($theitem, $itmn, 1);
    }
}

function octitem_rotate(&$theitem, $rotpos, $showlog = 0)
{
	global $log;
	$itm=&$theitem['itm']; $itmk=&$theitem['itmk'];
	$itme=&$theitem['itme']; $itms=&$theitem['itms']; $itmsk=&$theitem['itmsk'];
	$oct_colors_words = array('<span class="red">紅</span>','<span class="lime">綠</span>','<span class="clan">藍</span>','<span class="yellow">黃</span>','<span class="gold">金</span>','<span class="linen">銀</span>','<span class="mtgblack">黑</span>','<span class="mtgwhite">白</span>');
	
	if (strlen($itmsk) != 16)
	{
		$oct_seq = range(0, 7);
		shuffle($oct_seq);
		$oct_colors = range(0, 7);
		shuffle($oct_colors);
	}
	else
	{
		$itmsk_arr = str_split($itmsk);
		$oct_seq = array_slice($itmsk_arr, 0, 8);
		$oct_colors = array_slice($itmsk_arr, 8);
	}
	
	//改變選中面和另兩個面的顏色
	$oct_colors[$rotpos] = ($oct_colors[$rotpos] + 1) % 8;
	$rotpos2 = ($rotpos + 1) % 8;
	$oct_colors[$rotpos2] = ($oct_colors[$rotpos2] + 1) % 8;
	$rotpos3 = ($rotpos + 2) % 8;
	$oct_colors[$rotpos3] = ($oct_colors[$rotpos3] + 1) % 8;
	$itmsk = implode('', $oct_seq).implode('', $oct_colors);
	
	if ($showlog)
	{
		$log .= "<br><span class=\"yellow b\">{$itm}</span>八個面的顏色為：<br>";
		foreach ($oct_seq as $v)
		{
			$log .=	$oct_colors_words[$oct_colors[$v]].' ';
		}
		//$log .= "測試：真實序列為".implode('', $oct_colors);
		$log .= "<br>";
	}
	
	//結果檢查
	$oc_count = count(array_unique($oct_colors));
	if ($oc_count == 1)
	{
		if ($showlog)
		{
			$log .= "<span class=\"yellow b\">{$itm}</span>的形狀發生了變化……<br>";
		}
		$itm = '★稜鏡八面體模樣的彩色糖果★'; $itmk = 'HM';
		$itme = 88; $itms = 8; $itmsk = 'x';
	}
}
