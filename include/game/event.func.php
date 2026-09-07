<?php
if(!defined('IN_GAME')) {
	exit('Access Denied');
}

function event(){
	global $mode,$log,$hp,$sp,$inf,$pls,$rage,$money;
	global $mhp,$msp,$wp,$wk,$wg,$wc,$wd,$wf;
	global $rp,$killnum,$state;
	//没有事件的地图返回默认值0，有事件的地图返回1。地图内没有事件会继续推进探索判定。
	$event = 0;
	$dice1 = rand(0,5);
	$dice2 = rand(20,40);//原为rand(5,10)
	if($pls == 0) { //无月之影
	} elseif($pls == 1) { //端点
	} elseif($pls == 2) { //现RF高校
		$log = ($log . "突然，一個戴着面具的怪人出現了！<BR>");
		if($dice1 == 2){
			$log = ($log . "“嗚嘛嗚——！”<br>被怪人<span class=\"red\">打中了頭</span>！<BR>");
			$inf = str_replace('h','',$inf);
			$inf = ($inf . 'h');
		}elseif($dice1 == 3){
			$log = ($log . "“嗚嘛嗚——！”<br>被怪人打中了，<span class=\"red\">受到{$dice2}點傷害</span>！<BR>");
			$hp-=$dice2;
		}elseif($rp <=45){
			$log = ($log . "“嗚嘛嗚——！”<br>怪人給了你一個錢包！裏面有<span class=\"red\">{$dice2}個1元硬幣</span>！<BR>");
			$money = $money + $dice2 * 1;
			event_rp_up(15);
			//$rp = $rp + 15;
		}else{
			$log = ($log . "呼，總算逃脱了。<BR>");
		}
		$event = 1;
	} elseif($pls == 3) { //雪之镇
		if($rp <=70){
			$log = ($log . "突然，一位拿着紙袋的少女向你撞來！<BR>");
			if($dice1 == 2){
				$log = ($log . "你身體一側，成功迴避了被撞倒的厄運。<BR>你看着少女面朝下重重地摔在地上，轉頭走開了。<BR>");
				event_rp_up(40);
				//$rp = $rp + 40;
			}
			else{
				$log = ($log . "你迴避不及，被少女撞個正着！<BR>你面朝下地重重地摔在地上。");
				$inf = str_replace('h','',$inf);
				$inf = ($inf . 'h');	
				event_rp_up(25);
				//$rp = $rp + 25;
				$log = ($log . "不過知道少女不是故意找茬後，<BR>你原諒了她，並且和她分享了雕魚燒，你感覺全身舒暢。");
				$hp = $mhp;
				$sp = $msp;
			}
		}else{
			$log = ($log . "突然，一位少女向你撞來！<BR>");
			if($dice1 == 2){
				$log = ($log . "你身體一側，成功迴避了被撞倒的厄運。<BR>你看着少女面朝下重重地摔在地上，轉頭走開了。<BR>");
				event_rp_up(40);
				//$rp = $rp + 40;
			}
			else{
				$log = ($log . "你迴避不及，被少女撞個正着！<BR>你面朝下地重重地摔在地上。");
				$inf = str_replace('h','',$inf);
				$inf = ($inf . 'h');	
				event_rp_up(-5);
				//$rp = $rp - 5;
			}
		}	
		$event = 1;	
	} elseif($pls == 4) { //索拉利斯
	} elseif($pls == 5) { //指挥中心
	} elseif($pls == 6) { //梦幻馆
	} elseif($pls == 7) { //清水池
		$log = ($log . "糟糕，腳下滑了一下！<BR>");
		if($dice1 <= 3){
			$dice2 += 10;
			if($sp <= $dice2){
				$dice2 = $sp-1;
			}
			$sp-=$dice2;
			$log = ($log . "你摔進了池裏！<BR>從水池裏爬出來<span class=\"red\">消耗了{$dice2}點體力</span>。<BR>");
		}else{
			$log = ($log . "萬幸，你沒跌進池中。<BR>");
		}
		$event = 1;
	} elseif($pls == 8) { //白穗神社
	} elseif($pls == 9) { //墓地
	} elseif($pls == 10) { //麦斯克林
	} elseif($pls == 11) { //央中电视台 - 现对天使用作战本部
		$log = ($log . "哇！一個大錘向你錘來！<BR>");
		if($dice1 == 2){
			$log = ($log . "大錘重重地<span class=\"red\">砸到了腿上</span>，好疼！<BR>");
			$inf = str_replace('f','',$inf);
			$inf = ($inf . 'f');
		}elseif($dice1 == 3){
			$log = ($log . "你被擊飛出了窗外，<span class=\"red\">受到{$dice2}點傷害</span>！<BR>");
			$hp-=$dice2;
		}else{
			$log = ($log . "你勉強躲過了大錘的攻擊。<BR>");
		}
		$event = 1;
	} elseif($pls == 12) { //夏之镇
		$log = ($log . "突然，天空出現一大羣烏鴉！<BR>");
		if($dice1 == 2){
			$log = ($log . "被烏鴉襲擊，<span class=\"red\">頭部受了傷</span>！<BR>");
			$inf = str_replace('h','',$inf);
			$inf = ($inf . 'h');
		}elseif($dice1 == 3){
			$log = ($log . "被烏鴉襲擊，<span class=\"red\">受到{$dice2}點傷害</span>！<BR>");
			$hp-=$dice2;
		}else{
			$log = ($log . "呼，總算擊退了。<BR>");
		}
		$event = 1;
	} elseif($pls == 13) { //三体星
	} elseif($pls == 14) { //光坂高校
	} elseif($pls == 15) { //守矢神社
		$log = ($log . "突然有妖怪襲擊你！<BR>");
		if($dice1 == 2){
			$log = ($log . "被妖怪嚇着了！你驚慌中<span class=\"red\">撞傷了自己的頭部</span>！<BR>");
			$inf = str_replace('h','',$inf);
			$inf = ($inf . 'h');
		}elseif($dice1 == 3){
			$log = ($log . "妖怪的彈幕使你<span class=\"red\">受到{$dice2}點傷害</span>！<BR>");
			$hp-=$dice2;
		}else{
			$log = ($log . "呼，所謂妖怪不過是個撐着紫傘的少女而已，沒什麼可害怕的。<BR>");
		}
		$event = 1;
	} elseif($pls == 16) { //常磐森林
		$log = ($log . "野生的皮卡丘從草叢中鑽出來了！<BR>");
		if($dice1 == 2){
			$log = ($log . "皮卡丘使用了電擊！<span class=\"red\">手臂被擊傷了</span>！<BR>");
			$inf = str_replace('a','',$inf);
			$inf = ($inf . 'a');
		}elseif($dice1 == 3){
			$log = ($log . "皮卡丘使用了電光石火！<span class=\"red\">受到{$dice2}點傷害</span>！<BR>");
			$hp-=$dice2;
		}else{
			$log = ($log . "成功地逃跑了。<BR>");
		}
		$event = 1;
	} elseif($pls == 17) { //常磐台中学
	} elseif($pls == 18) { //秋之镇
		$log = ($log . "突然，天空出現一大羣烏鴉！<BR>");
		if($dice1 == 2){
			$log = ($log . "被烏鴉襲擊，<span class=\"red\">頭部受了傷</span>！<BR>");
			$inf = str_replace('h','',$inf);
			$inf = ($inf . 'h');
		}elseif($dice1 == 3){
			$log = ($log . "被烏鴉襲擊，<span class=\"red\">受到{$dice2}點傷害</span>！<BR>");
			$hp-=$dice2;
		}else{
			$log = ($log . "呼，總算擊退了。<BR>");
		}
		$event = 1;
	} elseif($pls == 19) { //精灵中心
	} elseif($pls == 20) { //春之镇
	} elseif($pls == 21) { //圣Gradius学园
		global $gamestate;
		if($gamestate < 50){
			$log = ($log . "隸屬於時空部門G的特殊部隊『天使』正在實彈演習！<BR>你被捲入了彈幕中！<BR>");
			if($dice1 <= 1 ){
				$log = ($log . "在彈幕的狂風中，你有驚無險地迴避着彈幕，總算擦彈成功了。<BR>");
				if($dice2 == 40 && $rp > 120 && $killnum > 0){
					$log = ($log . "咦，頭頂上……好像有一名少女被彈幕擊中了……？<BR>“對不起、對不起！”伴隨着焦急的道歉聲，少女以及她乘坐的機體向你筆直墜落下來。<br>你還來不及反應，重達數十噸的機體便直接落在了你的頭上。<br>");
					include_once GAME_ROOT . './include/state.func.php';
					death('gradius');
					return;
				}
				elseif($dice2 == 30){
				$log = ($log . "接下來你看見駕駛着棕色機體的少女向你飛來。<BR>“實在對不起，我們看起來沒有放假的時候啊。危險躲藏在每個大意之中不是麼？”<br>她扔給了你些什麼東西，貌似是面額為573的『紙幣』？<br>“祝你好運！”少女這麼説完就飛走了。");
				$money = $money + 573;
				event_rp_up(100);
				//$rp = $rp + 100;
				}
			}
			else{
				$log = ($log . "在彈幕的狂風中，你徒勞地試圖迴避彈幕……<BR>擦彈什麼的根本做不到啊！<BR>你被少女們打成了篩子！<BR>");
				global $infwords;
				$infcache = '';
				foreach(Array('h','b','a','f') as $value){
					$dice3=rand(0,10);
					if($dice3<=6){
						$inf = str_replace($value,'',$inf);
						$infcache .= $value;
						$log .= "<span class=\"red\">彈幕造成你{$infwords[$value]}了！</span><br />";
					}
				}
				if(empty($infcache)){
					$inf = str_replace('b','',$inf);
					$inf .= 'b';
					$log .= "<span class=\"red\">彈幕造成你胸部受傷了！</span><br />";
				} else {$inf .= $infcache;}
	//			$inf = str_replace('h','',$inf);
	//			$inf = str_replace('b','',$inf);
	//			$inf = str_replace('a','',$inf);
	//			$inf = str_replace('f','',$inf);
	//			$inf = ($inf . 'hbaf');
				if($dice2 >= 39){
					$log = ($log . "並且，少女們的彈幕擊中了要害！<BR><span class=\"red\">你感覺小命差點就交代在這裏了</span>。<BR>");
					$hp = 1;
				}
				elseif($dice2 >= 36){
					$log = ($log . "並且，黑洞激光造成你<span class=\"blue\">凍結</span>了！<BR>");
					$inf = str_replace('i','',$inf);
					$inf = ($inf . 'i');
				}
				elseif($dice2 >= 32){
					$log = ($log . "並且，環形激光導致你<span class=\"red\">燒傷</span>了！<BR>");
					$inf = str_replace('u','',$inf);
					$inf = ($inf . 'u');
				}
				elseif($dice2 >= 27){
					$log = ($log . "並且，精神震盪彈導致你<span class=\"yellow\">全身麻痹</span>了！<BR>");
					$inf = str_replace('e','',$inf);
					$inf = ($inf . 'e');
				}
				elseif($dice2 >= 23){
					$log = ($log . "並且，音波裝備導致你<span class=\"grey\">混亂</span>了！<BR>");
					$inf = str_replace('w','',$inf);
					$inf = ($inf . 'w');
				}
				else{
					$log = ($log . "並且，干擾用強襲裝備導致你<span class=\"purple\">中毒</span>了！<BR>");
					$inf = str_replace('p','',$inf);
					$inf = ($inf . 'p');
				}
				$log = ($log . "你遍體鱗傷、連滾帶爬地逃走了。<BR>");
			}
		} else {
			$log = ($log . "特殊部隊『天使』的少女們不知道去了哪裏。<BR>");
		}
		$event = 1;
	} elseif($pls == 22) { //初始之树
	} elseif($pls == 23) { //幻想世界
	} elseif($pls == 24) { //永恒的世界
	} elseif($pls == 25) { //妖精驿站
	} elseif($pls == 26) { //键刃墓场
		global $gamestate,$db,$tablepre;
		$result = $db->query("SELECT pid,hp FROM {$tablepre}players WHERE type=4");
		if(!$db->num_rows($result)){$flag = 0;}//篝未加入战场，正常处理事件；
		else{$flag = 1;}//篝加入战场
		$dice=rand(0,10);
		if(!$flag)
		{
			if ($dice < 3){
				if ($rp < 40){
					$log = ($log . "在遠方你能感覺到什麼東西在……看着你。<BR>");
					event_rp_up(rand(10,25));
					//$rp = $rp + rand(10,25);
				}elseif ($rp < 500){
					$log = ($log . "在遠方你能感覺到什麼東西在……追蹤着你。<BR>");
					event_rp_up(rand(50,100));
					//$rp = $rp + rand(50,100);
				}elseif ($rp < 1000 && $killnum == 0){
					$log = ($log . "你覺得身後有什麼東西<BR>你回頭看了一眼，發現什麼都沒有。<BR>你稍微放鬆了點精神。<BR>");
					//$rp = $rp + rand(100,200);
					$spup = rand(50,100);
					//$hp = $mhp;
					$msp += $spup;
					$sp = $msp;		
					event_rp_up($spup*2);
					//$rp += $spup*2;	
				}elseif ($rp < 1000){
					$log = ($log . "不知道為什麼，你覺得雙腿一軟……<BR>");
					$spdown = round($rp/4);
					$sp -= $spdown;
					if($sp <= 0){$sp = 1;}
					//$sp = 17;
				}elseif ($rp < 5000 && $killnum == 0){
					$log = ($log . "你感覺你聽到了什麼Homo開頭的拉丁文單詞……可能是錯覺吧。<BR>");
				}elseif ($rp < 5000){
					$log = ($log . "你面前突然出現了一個黑裙白髮的少女身影！是K.A.G.A.R.I！<BR>");
					death_kagari(3);
				}else{
					$log = ($log . "你面前突然出現了一個黑裙白髮的少女身影！是K.A.G.A.R.I！<BR>");
					death_kagari(rand(1,2));
					//$log = ($log . "少女抬头看了你一眼，随后低下头去继续她的研究。<BR>");
				}
			}elseif ($dice < 6){
				if ($rp < 40){
					$log = ($log . "在遠方你能感覺到什麼東西在……看着你。<BR>");
					event_rp_up(rand(50,100));
					//$rp = $rp + rand(50,100);
				}elseif ($rp < 500){
					$log = ($log . "不知道為什麼，你覺得雙腿一軟……<BR>");
					$hpdown = round($rp/4);
					$hp -= $hpdown;
					if($hp <= 0 ){$hp = 1;}
					//$sp = $sp - 200;			
				}elseif ($rp < 1000 && $killnum == 0){
					$log = ($log . "你面前突然出現了一個黑裙白髮的少女身影！是K.A.G.A.R.I！<BR>少女的絲帶飛到你的面前，<BR>在你的臉上重重地颳了一下。<BR>");
					$inf = str_replace('h','',$inf);
					$inf = ($inf . 'h');
				}elseif ($rp < 1000){
					$log = ($log . "你面前突然出現了一個黑裙白髮的少女身影！是K.A.G.A.R.I！<BR>少女的絲帶飛到你的面前，<BR>在你的臉上重重地颳了一下。<BR>");
					$inf = str_replace('e','',$inf);
					$inf = ($inf . 'e');
				}elseif ($rp < 5000 && $killnum == 0){
					$log = ($log . "你面前突然出現了一個黑裙白髮的少女身影！是K.A.G.A.R.I！<BR>少女的絲帶飛到你的面前，<BR>在你的頭上重重地敲了一下。<BR>");
					$inf = str_replace('h','',$inf);
					$inf = str_replace('w','',$inf);
					$inf = ($inf . 'hw');
				}elseif ($rp < 5000){
					$log = ($log . "你面前突然出現了一個黑裙白髮的少女身影！是K.A.G.A.R.I！<BR>");
					death_kagari(3);
				}else{
					$log = ($log . "你面前突然出現了一個黑裙白髮的少女身影！是K.A.G.A.R.I！<BR>");
					death_kagari(rand(1,2));
					//$log = ($log . "少女抬头看了你一眼，随后低下头去继续她的研究。<BR>");
				}		
			}elseif ($dice < 9){
				if ($rp < 40){
					$log = ($log . "你感覺有什麼東西在注意着你的一舉一動。<BR>");
					event_rp_up(rand(200,400));
					//$rp = $rp + rand(200,400);
				}elseif ($rp < 500){
					$log = ($log . "你在兩把卡在地上的武器間隙中<BR>發現了一個裝滿奇怪的深色液體的保温瓶；<BR>你喝了一口，感覺體內有一種力量湧出來。<BR>");
					$mhpup = rand(25,50);
					$mhp = $mhp + $mhpup;
					$hp = $mhp;
					event_rp_up($mhpup*4);
					//$rp += $mhpup*4;
				}elseif ($rp < 1000 && $killnum == 0){
					$log = ($log . "你百無聊賴地坐了下來看着四周。<BR>突然你發現了一個黑白兩色的袋子！<BR>");
					$hp = round($mhp/10);
					if($hp <= 0){$hp = 1;}
					$sp = round($msp/10);
					if($sp <= 0){$sp = 1;}
	//				$mhp = 400;
	//				$msp = 400;
	//				$hp = 200;
	//				$sp = 200;
					$log = ($log . "但是你頭一昏<BR>然後你什麼都記不得了。<BR>你醒來的時候，才發現你已經七竅流血。<BR>");
					$skillupsum = 0;
					foreach(array('wp','wk','wg','wc','wd','wf') as $val){
						$up = rand(23,34);
						${$val} += $up;
						$skillupsum += $up;
					}
					$rp += $skillupsum*2;
	//				$wp = $wp + rand(75,150);
	//				$wk = $wk + rand(75,150);
	//				$wg = $wg + rand(75,150);
	//				$wc = $wc + rand(75,150);
	//				$wd = $wd + rand(75,150);
	//				$wf = $wf + rand(75,150);
				}elseif ($rp < 1000){
					$log = ($log . "你小心翼翼地在少女旁邊坐下，想看看她身下的『繪卷』<BR>結果被紅色的絲帶正中腿部。<BR>");
	//				$hp = 200;
	//				$sp = 200;
					$hp = round($mhp/8);
					if($hp <= 0){$hp = 1;}
	//				$sp = round($msp/10);
	//				if($sp <= 0){$sp = 1;}
					$inf = str_replace('f','',$inf);
					$inf = ($inf . 'f');
					$log = ($log . "你齜牙咧嘴地逃走了。<BR>");			
				}elseif ($rp < 5000){
					$log = ($log . "你面前突然出現了一個黑裙白髮的少女身影！是K.A.G.A.R.I！<BR>");
					death_kagari(3);
				}elseif ($rp > 5000){
					$log = ($log . "你面前突然出現了一個黑裙白髮的少女身影！是K.A.G.A.R.I！<BR>");
					death_kagari(3);
				}else{
					$log = ($log . "少女抬頭看了你一眼，隨後低下頭去繼續她的研究。<BR>");
				}		
			}else{
				if ($rp < 40){
					$log = ($log . "你感覺有什麼東西在你身後吹氣！<BR>太可怕了，還是趕快離開為妙！<BR>");
					event_rp_up(rand(500,1000));
					//$rp = $rp + rand(500,1000);
				}elseif ($rp < 500){
					$log = ($log . "你感覺有什麼東西貫穿了你的身體！<BR>太可怕了，還是趕快離開為妙！<BR>");
					$oldhp = $hp;$oldsp = $sp;
					$hp = 1;
					$sp = 1;
					event_rp_up( -round(($oldhp+$oldsp)/10));
					//$rp = $rp - round(($oldhp+$oldsp)/10);
				}elseif ($rp < 1000 && $killnum == 0){
					$log = ($log . "你感覺有什麼東西貫穿了你的身體！<BR>太可怕了，還是趕快離開為妙！<BR>");
					$skilldownsum = 0;
					foreach(array('wp','wk','wg','wc','wd','wf') as $val){
						$down = rand(1,round(${$val}/2));
						${$val} -= $down;
						$skilldownsum += $down;
					}
					event_rp_up( -round($skilldownsum/6));
					//$rp -= round($skilldownsum/6);
				}elseif ($rp < 1000){
					$log = ($log . "你突然感覺被一種無形的壓力直接壓在了地上，<BR>太可怕了，還是趕快離開為妙！<BR>");
					$mhp = round($mhp/2);
					if($mhp <= 37){$mhp = 37;}
					if($hp > $mhp){$hp = $mhp;}
					$msp = round($msp/2);
					if($msp <= 37){$msp = 37;}
					if($sp > $msp){$sp = $msp;}
					//$mhp = $msp = 100;
					event_rp_up( -37);
					//$rp = $rp - 37;
				}elseif ($rp < 5000){
					$log = ($log . "你面前突然出現了一個黑裙白髮的少女身影！是K.A.G.A.R.I！<BR>");
					death_kagari(3);
				}elseif ($rp > 5000){
					$log = ($log . "你面前突然出現了一個黑裙白髮的少女身影！是K.A.G.A.R.I！<BR>");
					death_kagari(3);
				}else{
					$log = ($log . "少女抬頭看了你一眼，隨後低下頭去繼續她的研究。<BR>");
				}		
			}
		}
		else
		{
			$log .= '你環顧四周，在斷壁殘垣間找尋着那個熟悉的身影……<br>但她似乎已經離開了。<br>';
		}
		$event = 1;
		//echo $rp;
	} elseif($pls == 27) { //花菱商厦
	} elseif($pls == 28) { //FARGO前基地
	} elseif($pls == 29) { //风祭森林
	} elseif($pls == 30) { //移动机库
	} elseif($pls == 31) { //太鼓实验室
	} elseif($pls == 32) { //SCP实验室
	} elseif($pls == 33) { //雏菊之丘
		global $gamestate,$db,$tablepre;
		$result = $db->query("SELECT pid,hp FROM {$tablepre}players WHERE type=4");
		if(!$db->num_rows($result)) $flag = 0;//篝未加入战场，正常处理事件；
		else{
			$result = $db->fetch_array($result);
			if($result['hp'] >0) $flag = 1;//篝加入战场
			else $flag = 2;//篝加入战场而且跪了
		}
		if(!$flag)
		{
			$dice=rand(0,10);
			if ($dice < 3){
				if ($rp < 40){
					$log = ($log . "少女抬頭看了你一眼，隨後低下頭去繼續她的研究。<BR>");
					event_rp_up(rand(10,25));
					//$rp = $rp + rand(10,25);
				}elseif ($rp < 500){
					$log = ($log . "少女抬頭看了你一眼，貌似對你的舉動很感興趣的樣子。<BR>");
					event_rp_up(rand(50,100));
					//$rp = $rp + rand(50,100);
				}elseif ($rp < 1000 && $killnum == 0){
					$log = ($log . "少女向你扔來一個保温瓶。<BR>裏面是類似於咖啡的液體；<BR>你喝了一口，感覺味道不怎麼樣。<BR>");
					//$rp = $rp + rand(100,200);
					$spup = rand(50,100);
					//$hp = $mhp;
					$msp += $spup;
					$sp = $msp;		
					event_rp_up($spup*2);
					//$rp += $spup*2;	
				}elseif ($rp < 1000){
					$log = ($log . "不知道為什麼，你覺得雙腿一軟……<BR>");
					$spdown = round($rp/4);
					$sp -= $spdown;
					if($sp <= 0){$sp = 1;}
					//$sp = 17;
				}elseif ($rp < 5000 && $killnum == 0){
					$log = ($log . "看見少女離開了，你好奇地向少女身下的那幅不明『繪卷』上看去……<BR>");
					$mhp = $mhp - rand(5,10);
					if($mhp <= 37){$mhp = 37;}
					$hp = 1;
					$msp = $msp - rand(10,20);
					if($msp <= 37){$msp = 37;}
					$sp = 1;
					//$sp = 1;
					$inf = str_replace('h','',$inf);
					$inf = str_replace('b','',$inf);
					$inf = str_replace('a','',$inf);
					$inf = str_replace('f','',$inf);
					$inf = ($inf . 'hbaf');
					$log = ($log . "不能承受繪捲上所述的知識量，你渾身冒血連滾帶爬地逃走了。<BR>");
				}elseif ($rp < 5000){
					death_kagari(rand(1,2));
				}else{
					death_kagari(3);
					//$log = ($log . "少女抬头看了你一眼，随后低下头去继续她的研究。<BR>");
				}
			}elseif ($dice < 6){
				if ($rp < 40){
					$log = ($log . "少女抬頭看了你一眼，貌似對你的舉動很感興趣的樣子。<BR>");
					event_rp_up(rand(50,100));
					//$rp = $rp + rand(50,100);
				}elseif ($rp < 500){
					$log = ($log . "不知道為什麼，你覺得雙腿一軟……<BR>");
					$hpdown = round($rp/4);
					$hp -= $hpdown;
					if($hp <= 0 ){$hp = 1;}
					//$sp = $sp - 200;			
				}elseif ($rp < 1000 && $killnum == 0){
					$log = ($log . "少女的絲帶飛到你的面前，<BR>在你的臉上重重地颳了一下。<BR>");
					$inf = str_replace('h','',$inf);
					$inf = ($inf . 'h');
				}elseif ($rp < 1000){
					$log = ($log . "少女的絲帶飛到你的面前，<BR>在你的臉上重重地颳了一下。<BR>");
					$inf = str_replace('e','',$inf);
					$inf = ($inf . 'e');
				}elseif ($rp < 5000 && $killnum == 0){
					$log = ($log . "少女的絲帶飛到你的面前，<BR>在你的頭上重重地敲了一下。<BR>");
					$inf = str_replace('h','',$inf);
					$inf = str_replace('w','',$inf);
					$inf = ($inf . 'hw');
				}elseif ($rp < 5000){
					death_kagari(rand(1,2));
				}else{
					death_kagari(3);
					//$log = ($log . "少女抬头看了你一眼，随后低下头去继续她的研究。<BR>");
				}		
			}elseif ($dice < 9){
				if ($rp < 40){
					$log = ($log . "少女抬頭開始注意你的一舉一動。<BR>");
					event_rp_up(rand(200,400));
					//$rp = $rp + rand(200,400);
				}elseif ($rp < 500){
					$log = ($log . "少女向你扔來一個保温瓶。<BR>裏面是奇怪的深色液體；<BR>你喝了一口，感覺體內有一種力量湧出來。<BR>");
					$mhpup = rand(25,50);
					$mhp = $mhp + $mhpup;
					$hp = $mhp;
					event_rp_up($mhpup*4);
					//$rp += $mhpup*4;
				}elseif ($rp < 1000 && $killnum == 0){
					$log = ($log . "你小心翼翼地在少女旁邊坐下，（竟然沒被她趕走！）<BR>看着她身下的『繪卷』<BR>");
					$hp = round($mhp/10);
					if($hp <= 0){$hp = 1;}
					$sp = round($msp/10);
					if($sp <= 0){$sp = 1;}
	//				$mhp = 400;
	//				$msp = 400;
	//				$hp = 200;
	//				$sp = 200;
					$log = ($log . "當你覺得你看懂了點什麼的時候<BR>只見少女用驚訝的眼光盯着你。<BR>這時你才發現你已經七竅流血。<BR>");
					$skillupsum = 0;
					foreach(array('wp','wk','wg','wc','wd','wf') as $val){
						$up = rand(23,34);
						${$val} += $up;
						$skillupsum += $up;
					}
					$rp += $skillupsum*2;
	//				$wp = $wp + rand(75,150);
	//				$wk = $wk + rand(75,150);
	//				$wg = $wg + rand(75,150);
	//				$wc = $wc + rand(75,150);
	//				$wd = $wd + rand(75,150);
	//				$wf = $wf + rand(75,150);
				}elseif ($rp < 1000){
					$log = ($log . "你小心翼翼地在少女旁邊坐下，想看看她身下的『繪卷』<BR>結果被紅色的絲帶正中腿部。<BR>");
	//				$hp = 200;
	//				$sp = 200;
					$hp = round($mhp/8);
					if($hp <= 0){$hp = 1;}
	//				$sp = round($msp/10);
	//				if($sp <= 0){$sp = 1;}
					$inf = str_replace('f','',$inf);
					$inf = ($inf . 'f');
					$log = ($log . "你齜牙咧嘴地逃走了。<BR>");			
				}elseif ($rp < 5000){
					death_kagari(1);
				}elseif ($rp > 5000){
					death_kagari(2);
				}else{
					$log = ($log . "少女抬頭看了你一眼，隨後低下頭去繼續她的研究。<BR>");
				}		
			}else{
				if ($rp < 40){
					$log = ($log . "少女飄了起來，並且跟在了你的後面，<BR>太可怕了，還是趕快離開為妙！<BR>");
					event_rp_up(rand(500,1000));
					//$rp = $rp + rand(500,1000);
				}elseif ($rp < 500){
					$log = ($log . "少女瞪了你一眼，你感覺你的生命力被抽乾了，<BR>太可怕了，還是趕快離開為妙！<BR>");
					$oldhp = $hp;$oldsp = $sp;
					$hp = 1;
					$sp = 1;
					event_rp_up(-round(($oldhp+$oldsp)/10));
					//$rp = $rp - round(($oldhp+$oldsp)/10);
				}elseif ($rp < 1000 && $killnum == 0){
					$log = ($log . "少女瞪了你一眼，你感覺頭暈目眩，<BR>太可怕了，還是趕快離開為妙！<BR>");
					$skilldownsum = 0;
					foreach(array('wp','wk','wg','wc','wd','wf') as $val){
						$down = rand(1,round(${$val}/2));
						${$val} -= $down;
						$skilldownsum += $down;
					}
					event_rp_up(round($skilldownsum/6));
					//$rp -= round($skilldownsum/6);
				}elseif ($rp < 1000){
					$log = ($log . "少女瞪了你一眼，你被一種無形的壓力直接壓在了地上，<BR>太可怕了，還是趕快離開為妙！<BR>");
					$mhp = round($mhp/2);
					if($mhp <= 37){$mhp = 37;}
					if($hp > $mhp){$hp = $mhp;}
					$msp = round($msp/2);
					if($msp <= 37){$msp = 37;}
					if($sp > $msp){$sp = $msp;}
					//$mhp = $msp = 100;-37rand(500,1000));
					//$rp = $rp - 37;
				}elseif ($rp < 5000){
					death_kagari(1);
				}elseif ($rp > 5000){
					death_kagari(2);
				}else{
					$log = ($log . "少女抬頭看了你一眼，隨後低下頭去繼續她的研究。<BR>");
				}		
			}
		}
		elseif($flag == 1)
		{
			$log .= '明白了少女已經是敵人的你，刻意躲避着少女的追蹤。不過至少你不用擔心被『繪卷』搞得七竅流血了。<BR>';
		}
		else
		{
			$log .= '在雛菊盛開的山丘上，那個熟悉的身影已消失不見。<br>目光所及之處，徒留野花隨風搖曳……<br>';
		}
		$event = 1;
		//echo $rp;
	}elseif ($pls==34){//英灵殿
		global $art,$plsinfo,$gamestate,$hack,$arealist,$areanum;
		if (($art!='Untainted Glory')&&($gamestate != 50)){
			$rpls=-1;
			while ($rpls<0 || $arealist[$rpls]==34){
				if($hack){$rpls = rand(0,sizeof($plsinfo)-1);}
				else {$rpls = rand($areanum+1,sizeof($plsinfo)-1);}
			} 
			$pls=$arealist[$rpls];
			$log.="殿堂的深處傳來一個聲音：<span class=\"evergreen\">“你還沒有進入這裏的資格”。</span><br>一股未知的力量包圍了你，當你反應過來的時候，發現自己正身處<span class=\"yellow\">{$plsinfo[$pls]}</span>。<br>";
			//if (CURSCRIPT !== 'botservice') $log.="<span id=\"HsUipfcGhU\"></span>";
		}
		$event = 1;
	}else {
	}

	if($hp<=0 && $state < 10){
//		global $now,$alivenum,$deathnum,$name,$state;
//		$hp = 0;
//		$state = 13;
//		addnews($now,'death13',$name,0);
//		$alivenum--;
//		$deathnum++;
//		//include_once GAME_ROOT.'./include/system.func.php';
//		save_gameinfo();
		include_once GAME_ROOT . './include/state.func.php';
		death('event');
	}
	return $event;
}


function death_kagari($type){
	global $log,$hp,$inf,$gamestate;
	if($type == 1){
		$log = ($log . "從少女的身上延伸出了紅色的絲帶，<BR>如巨蟒般將你緊緊地捆住。<BR>");
		if ($gamestate == 50 ){
			$log = ($log . "不過，在你即將被絞碎時，上空射來的奇異光束燒燬了絲帶，救了你一命。<BR>少女見狀扭頭離去了。<br>");
			$inf = str_replace('b','',$inf);
			$inf .= 'b';
			$hp = round($hp/100);
			if($hp <= 0){$hp = 1;}
		}else{
			include_once GAME_ROOT . './include/state.func.php';
			death('kagari1');
			return;
		}	
	}elseif($type == 2){
		$log = ($log . "從少女的身上延伸出了紅色的絲帶，<BR>鋒利的絲帶朝着你的頭部飛來！<BR>");
		if ($gamestate == 50 ){
			$log = ($log . "不過，在你即將身首異處時，上空射來的奇異光束燒燬了絲帶，救了你一命。<BR>少女見狀扭頭離去了。<br>");
			$hp = round($hp/100);
			$inf = str_replace('h','',$inf);
			$inf .= 'h';
			if($hp <= 0){$hp = 1;}
		}else{
			include_once GAME_ROOT . './include/state.func.php';
			death('kagari2');
			return;
		}		
	}elseif($type == 3){
		$log = ($log . "從少女的身上延伸出了紅色的絲帶，<BR>灼熱的絲帶朝着你高速飛來！<BR>");
		if ($gamestate == 50 ){
			$log = ($log . "不過，在噴射着岩漿的絲帶即將把你融化時，上空射來的奇異光束燒燬了絲帶，救了你一命。<BR>少女見狀扭頭離去了。<br>");
			$hp = round($hp/100);
			$inf = str_replace('u','',$inf);
			$inf .= 'u';
			if($hp <= 0){$hp = 1;}
		}else{
			include_once GAME_ROOT . './include/state.func.php';
			death('kagari3');
			return;
		}	
	}else{
		return;
	}	
}

function event_rp_up($rpup)
{
	if(!isset($data))
	{
		global $pdata;
		$data = &$pdata;
	}
	extract($data,EXTR_REFS);

	include_once GAME_ROOT.'./include/state.func.php';
	rpup_rev($data,$rpup);
	
	/*if($club != 19 || $rpup <= 0){
		$rp += $rpup;
	}else{
		
		$rpdec = 30;
		//$rpdec += get_clubskill_rp_dec($club,$skills);
		$rp += round($rpup*(100-$rpdec)/100);
	}*/
	return;
}
?>
