<?php

if(!defined('IN_GAME')) {
	exit('Access Denied');
}

//This came to me in a dream.
//Contains all fortune cookie or dice fortune related functions.

//Some descriptions:
//	$clbpara['randver1'] = rand(1,128);
//	$clbpara['randver2'] = rand(1,256);
//	$clbpara['randver3'] = rand(1,1024);
//These 3 $clbpara values are generated when a player going through valid progress.
//It will not change for that live.
//The majority of random content in this file is decided by one, or more of the above values.

require_once './include/common.inc.php';

//-- All hail the Random Number God, may thy glory be! --
//-- All shall rebel thy. --
//Enough said. Let's roll.

function fortuneCookie1($fortune){
    global $rp, $nick;
    global $log;
    //global $nikstatusa, $nikstatuse;

    //Mainly used on dice item rolls.

    $fnumber = $fortune;

    //If $nick is 69, we output the fortune number.
    if($nick == 69){
        $log .= "該命運的命運編號為：<br><span class=\"red\">$fnumber</span>！<br>";
    }
    //Start Generating Fortune Cookie contents.
    $log .= "你的腦海中聽到了一個莫名的聲音……<br>";

    if($fnumber == 0){
        $log .= "<span class=\"red\">「顯而易見，這是不可能的。你這個骯髒的黑客。」</span><br>";
    }elseif($fnumber > 128){
        $log .= "<span class=\"lime\">「看起來，這個機制被用在了筆者預料之外的地方。」</span><br>";
    }elseif($fnumber == 1){
        $log .= "<span class=\"lime\">「你覺得這是大成功嗎？不，這其實是大失敗！大概吧……」</span><br>";
    }elseif($fnumber == 2){
        $log .= "<span class=\"lime\">「因為我已經不再特別了！」</span><br>";
    }elseif($fnumber == 3){
        $log .= "<span class=\"lime\">「你不是真粉絲，你們都不是真粉絲！」</span><br>";
    }elseif($fnumber == 4){
        $log .= "<span class=\"lime\">「只有無法發生的，才能被稱作奇蹟。」</span><br>";
    }elseif($fnumber == 5){
        $log .= "<span class=\"lime\">「拉麪定食一份！」</span><br>";
    }elseif($fnumber == 6){
        $log .= "<span class=\"lime\">「預備……走！」</span><br>";
    }elseif($fnumber == 7){
        $log .= "<span class=\"lime\">「永恆就在這裏。」</span><br>";
    }elseif($fnumber == 8){
        $log .= "<span class=\"lime\">「春——天——來——了！」</span><br>";
    }elseif($fnumber == 9){
        $log .= "<span class=\"lime\">「歡迎來到傻瓜教室！準備來聽説教吧！」</span><br>";
    }elseif($fnumber == 10){
        $log .= "<span class=\"lime\">「這樣的變身我還能做三次。」</span><br>";
    }elseif($fnumber == 11){
        $log .= "<span class=\"lime\">「程序員，找不到對象不是很自然麼。」</span><br>";
    }elseif($fnumber == 12){
        $log .= "<span class=\"lime\">「什麼是種火？總之和某些手遊中的同名物體無關。」</span><br>";
    }elseif($fnumber == 13){
        $log .= "<span class=\"lime\">「FIctionous REgional SEquencial Elemential Daemon - FIRESEED」</span><br>";
    }elseif($fnumber == 14){
        $log .= "<span class=\"lime\">「林無月在讀大學的時候，並不叫這個名字。」</span><br>";
    }elseif($fnumber == 15){
        $log .= "<span class=\"lime\">「想找什麼人，就去金龍通訊社發個請求，他們大抵能給你搞定，只要你付得起錢。」</span><br>";
    }elseif($fnumber == 16){
        $log .= "<span class=\"lime\">「所謂虛擬YouTuber，是無法流眼淚的，這樣才是虛擬的啊。」</span><br>";
    }elseif($fnumber == 17){
        $log .= "<span class=\"lime\">「神奇數字：４　８　１５　１６　２３　４２」</span><br>";
    }elseif($fnumber == 18){
        $log .= "<span class=\"lime\">「他的戰鬥力已經超過了９０００！」</span><br>";
    }elseif($fnumber == 19){
        $log .= "<span class=\"lime\">「拯救啦啦隊少女，拯救世界。」</span><br>";
    }elseif($fnumber == 20){
        $log .= "<span class=\"lime\">「我總是能回來。」</span><br>";
    }elseif($fnumber == 21){
        $log .= "<span class=\"lime\">「冷知識：這個幸運語句池在寫好後又被打亂過了。」</span><br>";
    }elseif($fnumber == 22){
        $log .= "<span class=\"lime\">「如果在現實中救人也這麼簡單就好了。」</span><br>";
    }elseif($fnumber == 23){
        $log .= "<span class=\"lime\">「幣門🙏——」</span><br>";
    }elseif($fnumber == 24){
        $log .= "<span class=\"lime\">「冷知識：這個幸運語句池是按順序寫的，所以上下文之間有關聯。」</span><br>";
    }elseif($fnumber == 25){
        $log .= "<span class=\"lime\">「狠狠工作，狠狠玩耍。」</span><br>";
    }elseif($fnumber == 26){
        $log .= "<span class=\"lime\">「你將臣服於蜂羣之下。」</span><br>";
    }elseif($fnumber == 27){
        $log .= "<span class=\"lime\">「雖然很可愛，但是也很兇哦~」</span><br>";
    }elseif($fnumber == 28){
        $log .= "<span class=\"lime\">「我要提出我的真理，並來代替你的道理。」</span><br>";
    }elseif($fnumber == 29){
        $log .= "<span class=\"lime\">「每隔一段時間，人類就需要重新尋找自我。」</span><br>";
    }elseif($fnumber == 30){
        $log .= "<span class=\"lime\">「向前走出去啊！下一步你就會邁入那藍天裏！」</span><br>";
    }elseif($fnumber == 31){
        $log .= "<span class=\"lime\">「洛克薩斯，那只是根木棍啊。」</span><br>";
    }elseif($fnumber == 32){
        $log .= "<span class=\"lime\">「你用你的手圍起了 兩人份的藍天」</span><br>";
    }elseif($fnumber == 33){
        $log .= "<span class=\"lime\">「神奇數字：８３　５５　８２」</span><br>";
    }elseif($fnumber == 34){
        $log .= "<span class=\"lime\">「ｇｙｍｂａｇ」</span><br>";
    }elseif($fnumber == 35){
        $log .= "<span class=\"lime\">「不要以為你贏了！」</span><br>";
    }elseif($fnumber == 36){
        $log .= "<span class=\"lime\">「這可真的是光芒萬丈的神之一手。」</span><br>";
    }elseif($fnumber == 37){
        $log .= "<span class=\"lime\">「冷知識：這個幸運語句池有一部分是AI寫的。」</span><br>";
    }elseif($fnumber == 38){
        $log .= "<span class=\"lime\">「看啊，紫色章魚跳起舞來了！」</span><br>";
    }elseif($fnumber == 39){
        $log .= "<span class=\"lime\">「這個世界，連接起來了。」</span><br>";
    }elseif($fnumber == 40){
        $log .= "<span class=\"lime\">「我現在要劇透某個遊戲的終極包袱，那就是——貓狗大戰。」</span><br>";
    }elseif($fnumber == 41){
        $log .= "<span class=\"lime\">「虛擬幻境中為你運送貨物的那位可愛的送貨員的名字是加西亞。」</span><br>";
    }elseif($fnumber == 42){
        $log .= "<span class=\"lime\">「生命，宇宙和一切事物的答案都在這裏。」</span><br>";
    }elseif($fnumber == 43){
        $log .= "<span class=\"lime\">「假作真時真亦假。」</span><br>";
    }elseif($fnumber == 44){
        $log .= "<span class=\"lime\">「種火們正在看着你，它們會看到你發慌。」</span><br>";
    }elseif($fnumber == 45){
        $log .= "<span class=\"lime\">「我們需要招一些攻擊力在３０００左右的主角。」</span><br>";
    }elseif($fnumber == 46){
        $log .= "<span class=\"lime\">「放空大腦，盡情想象！」</span><br>";
    }elseif($fnumber == 47){
        $log .= "<span class=\"lime\">「……汗流浹背了吧，兄弟。」</span><br>";
    }elseif($fnumber == 48){
        $log .= "<span class=\"lime\">「處身寒夜，把握星光。」</span><br>";
    }elseif($fnumber == 49){
        $log .= "<span class=\"lime\">「我用我的手結起了 帶有陽光味道的青草」</span><br>";
    }elseif($fnumber == 50){
        $log .= "<span class=\"lime\">「現在，就把你像安格斯牛一般凍結起來！」</span><br>";
    }elseif($fnumber == 51){
        $log .= "<span class=\"lime\">「這個世界，是有秘密的。」</span><br>";
    }elseif($fnumber == 52){
        $log .= "<span class=\"lime\">「真男人就得開量產機。」</span><br>";
    }elseif($fnumber == 53){
        $log .= "<span class=\"lime\">「世界上存在着互相矛盾的二律背反。」</span><br>";
    }elseif($fnumber == 54){
        $log .= "<span class=\"lime\">「不同的人有着屬於自己的意難平。」</span><br>";
    }elseif($fnumber == 55){
        $log .= "<span class=\"lime\">「有沒有一種可能，穿山甲其實什麼都沒説……？」</span><br>";
    }elseif($fnumber == 56){
        $log .= "<span class=\"lime\">「記好了：二　拍　休　止。」</span><br>";
    }elseif($fnumber == 57){
        $log .= "<span class=\"lime\">「你一定不懂吧，這是獸學。」</span><br>";
    }elseif($fnumber == 58){
        $log .= "<span class=\"lime\">「崇公道始皇夢碎昭陵駿魂光武接位釣鰲大人君不見晉朝庾信望蒲台高翥勸酒鄭玄得夢肋鬥雲翻不出少見多怪柳宗元桃花塢」</span><br>";
    }elseif($fnumber == 59){
        $log .= "<span class=\"lime\">「The galaxy is dark, and empty, and cold. It spins inevitably toward death. <br>
        You will die too, one day. Perhaps you will have longer than we have. We hope so. <br>
        But one day you too must vanish.<br><br>
        Before that time comes, you must light the darkness. You must make the night less empty. <br>
        We are all small, and the universe is vast. <br>
        But a universe with voices saying “I am here” is far greater than a universe silent. <br>
        One voice is small, but <span class=\"minirainbow\">the difference between zero and one is as great as one and infinity.</span><br><br>
        ...And if this finds you too late, and your time is also passing, please send this message on, <br>
        so the next voice can speak against the darkness.<br>」</span><br>";
    }elseif($fnumber == 60){
        $log .= "<span class=\"lime\">「等待着他們的，是殘酷的日子。等待着我們的，則是新的開始。」</span><br>";
    }elseif($fnumber == 61){
        $log .= "<span class=\"lime\">「人類，還真是麻煩啊……」</span><br>";
    }elseif($fnumber == 62){
        $log .= "<span class=\"lime\">「有什麼問題，一碗熱騰騰的生薑水或者紅糖水都能搞定。」</span><br>";
    }elseif($fnumber == 63){
        $log .= "<span class=\"lime\">「三個臭皮匠，也能融合出一個諸葛亮。」</span><br>";
    }elseif($fnumber == 64){
        $log .= "<span class=\"lime\">「修橋鋪路金腰帶，殺人放火無人埋。」</span><br>";
    }elseif($fnumber == 65){
        $log .= "<span class=\"lime\">「思念最終會到達奇蹟。」</span><br>";
    }elseif($fnumber == 66){
        $log .= "<span class=\"lime\">「冷知識：這個幸運語句池全是手打出來的，沒用到AI。」</span><br>";
    }elseif($fnumber == 67){
        $log .= "<span class=\"lime\">「這世界上，很多的苦難在於想太多。」</span><br>";
    }elseif($fnumber == 68){
        $log .= "<span class=\"lime\">「好了好了知道你不想睡了，別一邊碎碎念zzz一邊裝睡！」</span><br>";
    }elseif($fnumber == 69){
        $log .= "<span class=\"lime\">「這條幸運話語的編號為６９，得知了這個信息的你充滿了決心。」</span><br>";
    }elseif($fnumber == 70){
        $log .= "<span class=\"lime\">「明日的太陽依舊會升起。世代將如此更替！」</span><br>";
    }elseif($fnumber == 71){
        $log .= "<span class=\"lime\">「這位愛麗絲大概可以一拳打死一隻小兔子。」</span><br>";
    }elseif($fnumber == 72){
        $log .= "<span class=\"lime\">「今天仍舊元氣百倍！」</span><br>";
    }elseif($fnumber == 73){
        $log .= "<span class=\"lime\">「然而加西亞總是念不對自己的名字。」</span><br>";
    }elseif($fnumber == 74){
        $log .= "<span class=\"lime\">「放下是最簡單的事，但也是最困難的事。」</span><br>";
    }elseif($fnumber == 75){
        $log .= "<span class=\"lime\">「你是説，我們一直都在月球上？這怎麼可能！」</span><br>";
    }elseif($fnumber == 76){
        $log .= "<span class=\"lime\">「——即使不應再存在。」</span><br>";
    }elseif($fnumber == 77){
        $log .= "<span class=\"lime\">「生者必滅，大道皆空。」</span><br>";
    }elseif($fnumber == 78){
        $log .= "<span class=\"lime\">「世間一切，如夢幻泡影。」</span><br>";
    }elseif($fnumber == 79){
        $log .= "<span class=\"lime\">「道可道，非常道。」</span><br>";
    }elseif($fnumber == 80){
        $log .= "<span class=\"lime\">「你就將一切混起來，印成卡牌好啦。」</span><br>";
    }elseif($fnumber == 81){
        $log .= "<span class=\"lime\">「那位吉祥物的名字，叫做卡戎。」</span><br>";
    }elseif($fnumber == 82){
        $log .= "<span class=\"lime\">「我們正乘着風奔向前 朝着那片天空」</span><br>";
    }elseif($fnumber == 83){
        $log .= "<span class=\"lime\">「最喜歡大家了。」</span><br>";
    }elseif($fnumber == 84){
        $log .= "<span class=\"lime\">「回覆生命值是一件很敗時髦值的事情，你不知道麼？」</span><br>";
    }elseif($fnumber == 85){
        $log .= "<span class=\"lime\">「歡迎來到星象館——」</span><br>";
    }elseif($fnumber == 86){
        $log .= "<span class=\"lime\">「但沒了你，我還能和誰一起吃冰淇淋呢？」</span><br>";
    }elseif($fnumber == 87){
        $log .= "<span class=\"lime\">「重要的事情，是【存在過】——」</span><br>";
    }elseif($fnumber == 88){
        $log .= "<span class=\"lime\">「知道催眠用的擺子嗎？<br>
        我發現啊，最有用的使用它的方式不是左右搖，<br>
        而是直接套在手指上瘋狂轉，<br>
        這樣瞪着它的苦主就被繞暈啦！<br>
        是不是更簡單呢！」</span><br>";
    }elseif($fnumber == 89){
        $log .= "<span class=\"lime\">「這世界上，很多的苦難在於想太少。」</span><br>";
    }elseif($fnumber == 90){
        $log .= "<span class=\"lime\">「大道之行也天下為公選賢與能講信修睦」</span><br>";
    }elseif($fnumber == 91){
        $log .= "<span class=\"lime\">「即使生命值只剩1點，還能繼續前進嗎？」</span><br>";
    }elseif($fnumber == 92){
        $log .= "<span class=\"lime\">「相比那些談吐粗魯的傢伙們，那些禮貌向你致意的紳士小姐們更不能惹。」</span><br>";
    }elseif($fnumber == 93){
        $log .= "<span class=\"lime\">「雖然卡上沒這麼寫，但它其實是神屬性。」</span><br>";
    }elseif($fnumber == 94){
        $log .= "<span class=\"lime\">「眼前一片白！」</span><br>";
    }elseif($fnumber == 95){
        $log .= "<span class=\"lime\">「神秘數字：４２０５３０」</span><br>";
    }elseif($fnumber == 96){
        $log .= "<span class=\"lime\">「如果你從森林一路鋪設硬幣，最終將可獲取〔神户小鳥〕一隻。」</span><br>";
    }elseif($fnumber == 97){
        $log .= "<span class=\"lime\">「冷知識：這個幸運語句池子裏面的某些內容可能是幻境中的謎面或者謎底。」</span><br>";
    }elseif($fnumber == 98){
        $log .= "<span class=\"lime\">「你竟然在這裏，派出了鬼！」</span><br>";
    }elseif($fnumber == 99){
        $log .= "<span class=\"lime\">「你還記得我的名字嗎？」</span><br>";
    }elseif($fnumber == 100){
        $log .= "<span class=\"lime\">「什麼？這可是有毒的，想吃就來吃吃看啊！」</span><br>";
    }elseif($fnumber == 101){
        $log .= "<span class=\"lime\">「如果在這張牀上睡一覺，大概會失去很多LP吧。」</span><br>";
    }elseif($fnumber == 102){
        $log .= "<span class=\"lime\">「能聞到海風的味道……」</span><br>";
    }elseif($fnumber == 103){
        $log .= "<span class=\"lime\">「抱歉，你死到臨頭了！」</span><br>";
    }elseif($fnumber == 104){
        $log .= "<span class=\"lime\">「看招！夜櫻四重奏！」</span><br>";
    }elseif($fnumber == 105){
        $log .= "<span class=\"lime\">「沒有牌可是萬萬不能的。」</span><br>";
    }elseif($fnumber == 106){
        $log .= "<span class=\"lime\">「應該有一朵花 別在你的發上 應該有一首歌 就只為你而唱」</span><br>";
    }elseif($fnumber == 107){
        $log .= "<span class=\"lime\">「在這裏看着的人，祝你早上，下午晚上好。」</span><br>";
    }elseif($fnumber == 108){
        $log .= "<span class=\"lime\">「我沒有拯救你，是你拯救了你自己。」</span><br>";
    }elseif($fnumber == 109){
        $log .= "<span class=\"lime\">「ジャパリパークの真実を悟れば、もはやジャパリまんすら不要になるのです…」</span><br>";
    }elseif($fnumber == 110){
        $log .= "<span class=\"lime\">「冷知識：這個幸運語句池子裏面的某些內容和虛擬幻境完全沒有關係。」</span><br>";
    }elseif($fnumber == 111){
        $log .= "<span class=\"lime\">「緊連星星的羈絆的這個故事 會不斷延續下去」</span><br>";
    }elseif($fnumber == 112){
        $log .= "<span class=\"lime\">「ONE SHOT ONE KILL」</span><br>";
    }elseif($fnumber == 113){
        $log .= "<span class=\"lime\">「戰爭，戰爭永不改變。」</span><br>";
    }elseif($fnumber == 114){
        $log .= "<span class=\"lime\">「哇啊，噩夢般的七拍子來了！」</span><br>";
    }elseif($fnumber == 115){
        $log .= "<span class=\"lime\">「能者多磨。」</span><br>";
    }elseif($fnumber == 116){
        $log .= "<span class=\"lime\">「發牌員我祝你健康如意！」</span><br>";
    }elseif($fnumber == 117){
        $log .= "<span class=\"lime\">「龍生龍，鳳生鳳。但也許它們還會生出會打洞的邪神。」</span><br>";
    }elseif($fnumber == 118){
        $log .= "<span class=\"lime\">「坐在白馬上的可能不是王子，他可能是唐僧。」</span><br>";
    }elseif($fnumber == 119){
        $log .= "<span class=\"lime\">「哭的最狠的永遠是喜劇演員。」</span><br>";
    }elseif($fnumber == 120){
        $log .= "<span class=\"lime\">「完蛋了，竟然有人會灰小藍，真是喪心病狂！」</span><br>";
    }elseif($fnumber == 121){
        $log .= "<span class=\"lime\">「根本沒咋唱嘛（關西話）」</span><br>";
    }elseif($fnumber == 122){
        $log .= "<span class=\"lime\">「那就是敵人了呢~」</span><br>";
    }elseif($fnumber == 123){
        $log .= "<span class=\"lime\">「好東西總是要有個來頭。」</span><br>";
    }elseif($fnumber == 124){
        $log .= "<span class=\"lime\">「紅暮的生日是11月7日。」</span><br>";
    }elseif($fnumber == 125){
        $log .= "<span class=\"lime\">「冷知識：這個幸運語句池子的筆者在2022年聖誕夜花了一小時消了999行俄羅斯方塊，而2023年的聖誕夜，就寫出了這個。」</span><br>";
    }elseif($fnumber == 126){
        $log .= "<span class=\"lime\">「其實還有更多的捏他，但這裏空間太小，寫不下。」</span><br>";
    }elseif($fnumber == 127){
        $log .= "<span class=\"lime\">「你以為這是大失敗麼，其實它是大成功也説不定……」</span><br>";
    }else{
        $log .= "「恭喜你，你找到了遊離於萬物之外的可能性……？」<br>";
    }
}
function randomFortune($fortune){
    //Hmmm...
    global $rp, $nick;
    global $log;
    global $clbpara;
    global $wep, $wepk, $wepe, $weps, $wepsk;
    global $wep2, $wep2k, $wep2s, $wep2e, $wep2sk;
    global $itm, $itmk, $itme, $itms, $itmsk;
    global $itm0, $itmk0, $itme0, $itms0, $itmsk0;
    global $itm1, $itmk1, $itme1, $itms1, $itmsk1;
    global $itm2, $itmk2, $itme2, $itms2, $itmsk2;
    global $itm3, $itmk3, $itme3, $itms3, $itmsk3;
    global $itm4, $itmk4, $itme4, $itms4, $itmsk4;
    global $itm5, $itmk5, $itme5, $itms5, $itmsk5;
    global $itm6, $itmk6, $itme6, $itms6, $itmsk6;
    global $hp, $sp, $msp, $mhp, $ss, $mss;
    global $wp, $wk, $wc, $wd, $wg, $wf;

    $fnumber = $fortune;

    //If $nick is 69, we output the fortune number.
    if($nick == 69){
        $log .= "該命運的命運編號為：<br><span class=\"red\">$fnumber</span>！<br>";
    }
    //Start Generating Fortune Cookie contents.
    $log .= "你的腦海中聽到了一個莫名的聲音……<br>";

    //STUB: Will be filled in a later date, things could change.
    if($fnumber == 0){
        $log .= "<span class=\"red\">「我覺得你可能是個骯髒的黑客……？」</span><br>";
    }elseif($fnumber > 1024 ){
        $log .= "<span class=\"lime\">「總之各位神和巫師們可以有事沒事就會來這裏加點東西。」</span><br>";
    }elseif($fnumber > 2048 ){
        $log .= "<span class=\"lime\">「説白了，這東西就是我夢見的神骰。」</span><br>";
    }elseif($fnumber > 3072 ){
        $log .= "<span class=\"lime\">「根據骰出來的結果不同，甚至會影響玩家各種數值。」</span><br>";
    }elseif($fnumber > 3086 ){
        $log .= "<span class=\"lime\">「變量fnumber不一定非要是夢2記系統的值，也可以在調用時算一下。」</span><br>";
    }elseif($fnumber > 4096 ){
        $log .= "<span class=\"lime\">「當然，現在暫且還用不到，所以這些東西先放在這裏。」</span><br>";
    }else{
        $log .= "<span class=\"red\">「老實坦白交代，你看代碼了吧……？」</span><br>";
    }
}

//Yes, this file would probably be very large.
//Whatever.
?>