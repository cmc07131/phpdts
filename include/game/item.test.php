<?php

if (! defined('IN_GAME')) {
    exit('Access Denied');
}

/**
 * 处理测试物品
 * 这些物品主要用于测试游戏功能
 *
 * @param int $itmn 物品在物品栏中的位置
 * @param array &$data 玩家数据
 */
function item_test($itmn, &$data) {
    global $log, $db, $tablepre, $now, $pid, $event_bgm, $cmd, $mode;
    extract($data, EXTR_REFS);

    $itm = & ${'itm' . $itmn};
    $itmk = & ${'itmk' . $itmn};
    $itme = & ${'itme' . $itmn};
    $itms = & ${'itms' . $itmn};
    $itmsk = & ${'itmsk' . $itmn};

    if ($itm == 'NPC戰鬥測試儀') {
        include_once GAME_ROOT.'./include/game/revcombat.func.php';
        $pa = fetch_playerdata_by_pid(1);
        $pd = fetch_playerdata_by_pid(2);
        \revcombat\rev_combat_prepare($pa, $pd, 1);
    } elseif ($itm == 'QUEST調試終端') {
        include_once GAME_ROOT.'./include/game/quest.func.php';
        if (!quest_debug_offer($data)) {
            $log .= '<span class="yellow">當前沒有可用的QUEST。</span><br>';
            $mode = 'command';
        }
    } elseif ($itm == '顯現戰鬥測試儀') {
        //Mod the above item, YOU'll enter fight with a player entry matching the item's $itme value.
        include_once GAME_ROOT.'./include/game/revcombat.func.php';
        $pa = fetch_playerdata_by_pid($pid);
        $pd = fetch_playerdata_by_pid($itme);
        \revcombat\rev_combat_prepare($pa, $pd, 1);
    } elseif ($itm == '戰鬥顯現測試儀') {
        //Mod the above item, A player entry matching item's $itme value will enter a fight with YOU.
        include_once GAME_ROOT.'./include/game/revcombat.func.php';
        $pa = fetch_playerdata_by_pid($itme);
        $pd = fetch_playerdata_by_pid($pid);
        \revcombat\rev_combat_prepare($pa, $pd, 1);
    } elseif ($itm == '對話測試器') {
        // 简单对话测试
        // Regarding making dialogues with choices:
        // The user's choice will be stored in $clbpara['choice_index'] and $clbpara['choice_text'].
        // {"dialogue_id":"testingDialog","choice_index":"1","choice_text":"选项B"}
        $clbpara['dialogue'] = 'testingDialog';
        $clbpara['noskip_dialogue'] = 0;
    } elseif ($itm == '事件BGM替換器') {
        // 这是一个触发事件BGM的案例，只要输入$clbpara['event_bgmbook'] = Array('事件曲集名'); 即可将当前曲集替换为特殊事件BGM
        // 特殊事件曲集'event_bgmbook'的优先级高于地图曲集'pls_bgmbook'，前者存在时后者不会生效
        //global $clbpara,$event_bgm;
        //include_once config('audio',$gamecfg);
        $log.="【DEBUG】你目前的播放列表被替換為了{$event_bgm['test'][0]}！<br>特殊的事件曲集不會被其他曲集覆蓋，除非你使用下面的道具。<br>";
        $clbpara['event_bgmbook'] = $event_bgm['test'];
    } elseif ($itm == '事件BGM還原器') {
        // 这是一个取消事件BGM的案例，只要unset($clbpara['event_bgmbook']);就可以将当前曲集替换为地图曲集或默认曲集；
        // 如果你想播放另一个事件曲集，也可以$clbpara['event_bgmbook'] = Array('另一个事件曲集名');
        //global $clbpara;
        $log.="【DEBUG】你目前的播放列表還原為了默認播放列表！<br>";
        unset($clbpara['event_bgmbook']);
    } elseif ($itm == '成就重置裝置') {
        //使用会重置对应属性编号的成就进度
        include_once GAME_ROOT.'./include/game/achievement.func.php';
        reset_achievement_rev($itmsk, $name);
    } elseif ($itm == '測試用元素口袋') {
        //global $elements_info;
        $log.="【DEBUG】你不知道從哪裏摸出來一大堆元素！<br>";
        foreach($elements_info as $e_key => $e_info) {
            //global ${'element'.$e_key};
            ${'element'.$e_key} += 100000;
            $log.="獲得了100000份".$elements_info[$e_key]."！<br>";
        }
        //初始化元素合成缓存文件
        include_once GAME_ROOT.'./include/game/elementmix.func.php';
        emix_spawn_info();
    } elseif ($itm == '測試用元素大師社團卡') {
        //-----------------------//
        //这是一张测试用卡 冴冴可以挑一些用得上的放在使用社团卡后执行的事件里
        //global $elements_info,$sparkle;
        //未选择社团情况下才可以用社团卡
        if($club) {
            $log.="你已經是有身份的人了！不能再使用社團卡。<br>";
        } else {
            //反正是测试用的 发段怪log
            $log.="你拿起<span class='yellow'>$itm</span>左右端詳着……<br>
            你將目光掃過卡片上若隱若現的紋理，突然發現這張卡內似乎別有洞天。<br>
            透過紋理，你看到一羣奇裝異服的小人們，圍坐在一處頗具古典風格的露天廣場上。<br>
            廣場中央有一人，正抬手指天，慷慨陳詞。<br>
            你聽不到它們在説什麼，但演講者那極富感染力的動作勾起了你的好奇心，<br>
            你不由自主得沿着它指的方向望去——<br>
            <br>
            潔白如鏡的天穹上，倒映出的是你的臉。<br>
            <br>
            你趕忙移開視線，但小人們已經發現了你。<br>
            從廣場再到遠處的平原上，數以十計、百計、千計、萬計，
            一眼望不到頭的小人們從你視野的盡頭湧出，擠向你所在的方向。<br>
            你一時慌亂，下意識地便將手裏的卡片丟了出去。<br>
            眼前亦真亦幻的怪異景象登時消失不見了。<br>
            <br>
            你低下頭，發現腳下的卡片已經被燒掉了一半，<br>
            在被火焰燒灼得捲曲起的邊緣處，漏出了某樣東西的一角。<br>
            你撿起卡片，甩了甩，便看到一個足足有卡片五倍甚至四倍大的東西從裏面掉了出來！<br>";
            $log.="<br>獲得了<span class='sparkle'>{$sparkle}元素口袋{$sparkle}</span>！<br>";
            $log.="……這到底是怎麼一回事呢？<br><br>";
            //社团变更
            changeclub(20, $data);
            //获取初始元素与第一条配方
            $dice = rand(0, 5);
            //global ${'element'.$dice};
            ${'element'.$dice} += 200+$dice;
            //初始化元素合成缓存文件
            include_once GAME_ROOT.'./include/game/elementmix.func.php';
            emix_spawn_info();
            //销毁道具
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }
    } elseif ($itm == '測試用楓火歌者社團卡') {
        //-----------------------//
        //未选择社团情况下才可以用社团卡
        if($club) {
            $log.="你已經是有身份的人了！不能再使用社團卡。<br>";
        } else {
            $log.="<br>加入了了<span class='sparkle'>{$sparkle}楓火歌者{$sparkle}</span>！<br>";
            //社团变更
            changeclub(22, $data);
            //销毁道具
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        }
        //-----------------------//
    } elseif ($itm == '提示紙條A') {
        $log .= '你讀着紙條上的內容：<br>"執行官其實都是幻影，那個紅暮的身上應該有召喚幻影的玩意。"<br>"用那個東西然後打倒幻影的話能用遊戲解除鑰匙出去吧。"<br>';
    } elseif ($itm == '提示紙條B') {
        $log .= '你讀着紙條上的內容：<br>"我設下的靈裝被殘忍地清除了啊……"<br>"不過資料沒全部清除掉。<br>用那個碎片加上傳奇的畫筆和天然屬性……"<br>"應該能重新組合出那個靈裝。"<br>';
    } elseif ($itm == '提示紙條C') {
        $log .= '你讀着紙條上的內容：<br>"小心！那個叫紅暮的傢伙很強！"<br>"不過她太依賴自己的槍了，有什麼東西能阻擋那傷害的話……"<br>';
    } elseif ($itm == '提示紙條D') {
        $log .= '你讀着紙條上的內容：<br>"我不知道另外那個孩子的底細。如果我是你的話，不會隨便亂惹她。"<br>"但是她貌似手上拿着符文冊之類的東西。"<br>"也許可以利用射程優勢？！"<br>"你知道的，法師的射程都不咋樣……"';
    } elseif ($itm == '提示紙條E') {
        $log .= '你讀着紙條上的內容：<br>"生存並不能靠他人來餵給你知識，"<br>"有一套和元素有關的符卡的公式是沒有出現在幫助裏面的，用邏輯推理好好推理出正確的公式吧。"<br>"金木水火土在這裏都能找到哦～"<br>';
    } elseif ($itm == '提示紙條F') {
        $log .= '你讀着紙條上的內容：<br>"餵你真的是全部買下來了麼……"<br>"這樣的提示紙條不止這六種，其他的紙條估計被那兩位撒出去了吧。"<br>"總之祝你好運。"<br>';
    } elseif ($itm == '提示紙條G') {
        $log .= '你讀着紙條上的內容：<br>"上天保佑，"<br>"請不要在讓我在模擬戰中被擊墜了！"<br>"空羽 上。"<br>';
    } elseif ($itm == '提示紙條H') {
        $log .= '你讀着紙條上的內容：<br>"在研究施設裏面出了大事的SCP竟然又輸出了新的樣本！"<br>"按照董事長的意見就把這些傢伙當作人體試驗吧！"<br>署名看不清楚……<br>';
    } elseif ($itm == '提示紙條I') {
        $log .= '你讀着紙條上的內容：<br>"嗯……"<br>"製作神卡所用的各種認證都可以在商店裏面買到。"<br>"其實卡片真的有那麼強大的力量麼？"<br>';
    } elseif ($itm == '提示紙條J') {
        $log .= '你讀着紙條上的內容：<br>"知道麼？"<br>"果醬麪包果然還是甜的好，哪怕是甜的生薑也能配製出如地雷般爆炸似的美味。"<br>"祝你好運。"<br>';
    } elseif ($itm == '提示紙條K') {
        $log .= '你讀着紙條上的內容：<br>"水符？"<br>"你當然需要水，然後水看起來是什麼顏色的？"<br>"找一個顏色類似的東西合成就有了吧。"<br>';
    } elseif ($itm == '提示紙條L') {
        $log .= '你讀着紙條上的內容：<br>"木符？"<br>"你當然需要樹葉，然後説到樹葉那是什麼顏色？"<br>"找一個顏色類似的東西合成就有了吧。"<br>';
    } elseif ($itm == '提示紙條M') {
        $log .= '你讀着紙條上的內容：<br>"火符？"<br>"你當然需要找把火，然後説到火那是什麼顏色？"<br>"找一個顏色類似的東西合成就有了吧。"<br>';
    } elseif ($itm == '提示紙條N') {
        $log .= '你讀着紙條上的內容：<br>"土符？"<br>"説到土那就是石頭吧，然後説到石頭那是什麼顏色？"<br>"找一個顏色類似的東西合成就有了吧。"<br>';
    } elseif ($itm == '提示紙條O') {
        $log .= '你讀着紙條上的內容：<br>"紙條O？"<br>"你確定你看到的是O而不是0？"<br>"大概需要看看眼睛？"<br>';
    } elseif ($itm == '提示紙條P') {
        $log .= '你讀着紙條上的內容：<br>"金符？這個的確很繞人……"<br>"説到金那就是鍊金，然後這是21世紀了，煉製一個金色方塊需要什麼？"<br>"總之祝你好運。"<br>';
    } elseif ($itm == '提示紙條Q') {
        $log .= '你讀着紙條上的內容：<br>"據説在另外的空間裏面；"<br>"一個吸血鬼因為無聊就在她所居住的地方灑滿了大霧，"<br>"真任性。"<br>';
    } elseif ($itm == '提示紙條R') {
        $log .= '你讀着紙條上的內容：<br>"知道麼，"<br>"東方幻想鄉這作遊戲裏面EXTRA的最終攻擊"<br>"被老外們稱作『幻月的Rape Time』，當然對象是你。"<br>';
    } elseif ($itm == '提示紙條S') {
        $log .= '你讀着紙條上的內容：<br>"土水符？"<br>"哈哈哈那肯定是需要土和水啦，可能還要額外的素材吧。"<br>"總之祝你好運。"<br>';
    } elseif ($itm == '提示紙條T') {
        $log .= '你讀着紙條上的內容：<br>"我一直對虛擬現實中的某些跡象很在意……"<br>"這種未名的威壓感是怎麼回事？"<br>"總之祝你好運。"<br>';
    } elseif ($itm == '提示紙條U') {
        $log .= '你讀着紙條上的內容：<br>"紙條啥的……"<br>"希望這張紙條不會成為你的遺書。"<br>"總之祝你好運。"<br>';
    } elseif ($itm == '人品探測器') {
        //global $rp;
        $log .= '你讀着紙條上的內容：<br>"你的RP值為'.$rp.'。"<br>"總之祝你好運。"<br>';
    } elseif ($itm == '儀水鏡') {
        //global $rp;
        $log .= '水面上映出了你自己的臉，你仔細端詳着……<br>';
        if ($rp < 40) {
            $log .= '你的臉看起來十分白皙。<br>';
        } elseif ($rp < 200) {
            $log .= '你的臉看起來略微有點黑。<br>';
        } elseif ($rp < 550) {
            $log .= '你的臉上貌似籠罩着一層黑霧。<br>';
        } elseif ($rp < 1200) {
            $log .= '你的臉已經和黑炭差不多了，趕快去洗洗！<br>';
        } elseif ($rp < 5499) {
            $log .= '你印堂漆黑，看起來最近要有血光之災！<br>';
        } elseif ($rp > 5500) {
            $log .= '水鏡中已經黑的如墨一般了。<br>希望你的H173還在……<br>';
        } else {
            $log .= '你的臉從水鏡中消失了。<br>';
        }
    }elseif ($itm == '風祭河水'){
        //global $rp, $wp, $wk, $wg, $wc, $wd, $wf;
        $slv_dice = rand ( 1, 20 );
            if ($slv_dice < 8) {
            $log .= "你一口乾掉了<span class=\"yellow\">$itm</span>，不過好像什麼都沒有發生！";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        } elseif ($slv_dice < 16) {
            $rp = $rp - 10*$slv_dice;
            $log .= "你感覺身體稍微輕了一點點。<br>";
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        } elseif ($slv_dice < 20) {
            $rp = 0 ;
            $log .= "你頭暈腦脹地躺到了地上，<br>感覺整個人都被救濟了。<br>你努力着站了起來。<br>";
            $wp = $wk = $wg = $wc = $wd = $wf = 100;
            $itm = $itmk = $itmsk = '';
            $itme = $itms = 0;
        } else {
            $log .= '你頭暈腦脹地躺到了地上，<br>感覺整個人都被救濟了。<br>';
            include_once GAME_ROOT . './include/state.func.php';
            $log .= '然後你失去了意識。<br>';
            //$bid = 0;
            death ( 'salv', '', 0, $itm );
        }
    }elseif(strpos($itm,'RP回覆設備')!==false){
        //global $rp;
        $rp = 0;
        $log .= "你使用了<span class=\"yellow\">$itm</span>。你的RP歸零了。<br>";
    } elseif ($itm == 'itmpara調試開關') {
        // 切换 itmpara 调试模式
        if(isset($clbpara['SetItmparaDebug']) && $clbpara['SetItmparaDebug'] === true) {
            $clbpara['SetItmparaDebug'] = false;
            $log .= "你關閉了 itmpara 調試模式。<br>現在物品的 tooltip 中不會顯示調試信息。<br>";
        } else {
            $clbpara['SetItmparaDebug'] = true;
            $log .= "你開啓了 itmpara 調試模式。<br>現在物品的 tooltip 中會顯示詳細的調試信息。<br>";
        }
    } elseif ($itm == '對話選擇測試器') {
        // 带选择的对话测试
        $clbpara['dialogue'] = 'choiceTestingDialog';
        $clbpara['noskip_dialogue'] = 1; // 设置为不可跳过的对话
    }elseif ($itm == '調制解調器'){
        if(!empty($gamevars['apis']))
        {
            $log .= '你將這件長得很像貓的東西放在了地上……目送它慢悠悠地爬走了。<br>';
            if($gamevars['api'] < $gamevars['apis'])
            {
                $gamevars['api']++;
                save_gameinfo();
                $log .= '<span class="yellow">好像有什麼東西恢復了！</span><br>';
            }
            else
            {
                $log .= '<span class="yellow">但是什麼也沒有發生！</span><br>';
            }
            $itms--;
        }
        else
        {
            $log .= '這件長得很像貓的東西該怎麼用呢？<br>';
        }
    }

}
