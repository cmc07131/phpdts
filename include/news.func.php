<?php

if(!defined('IN_GAME')) {
	exit('Access Denied');
}



function  nparse_news($start = 0, $range = 0  ){//$type = '') {
	global $week,$nowep,$db,$tablepre,$lwinfo,$plsinfo,$hplsinfo,$wthinfo,$typeinfo,$exdmginf,$newslimit,$cskills;
	//$file = $file ? $file : $newsfile;	
	//$ninfo = openfile($file);
	$range = $range == 0 ? $newslimit : $range ;
	$result = $db->query("SELECT * FROM {$tablepre}newsinfo ORDER BY nid DESC LIMIT $start,$range");
	//$r = sizeof($ninfo) - 1;
//	$rnum=$db->num_rows($result);
//	if($range && ($range <= $rnum)) {
//		$nnum = $range;
//	} else{
//		$nnum = $rnum;
//	}
	$newsinfo = '<ul>';
	$nday = 0;

	//该来的躲不掉 会显示头衔的news内对应保存$nick的位置
	$old_nicknews = Array
	(
		//使用道具发送的news统一不带头衔，以后要不要带以后再说
		'teammake' => Array('b','c'),
		'teamjoin' => Array('b','c'),
		'teamquit' => Array('b','c'),
		'newgm' => 'd',
		'newpc' => 'd',
		'hack' => 'b',
		'hack2' => 'b',
		//合成消息显示头衔太丑了
		//'itemmix' => 'd',
		//'syncmix' => 'c',
		//'overmix' => 'c',
		//'senditem' => 'd',
		'csl_wthchange' => 'c',
		'csl_hack' => 'b',
		'csl_addarea' => 'b',
		'song' => 'd',
		//'revival' => 'b',
		//'wth18_revival' => 'b',
		//'aurora_revival' => 'b',
	);

	//for($i = $start;$i <= $r;$i++) {
	//for($i = 0;$i < $nnum;$i++) {
	while($news0=$db->fetch_array($result)) {
		//$news0=$db->fetch_array($result);
		$time=$news0['time'];$news=$news0['news'];$a=$news0['a'];$b=$news0['b'];$c=$news0['c'];$d=$news0['d'];$e=$news0['e'];
		list($sec,$min,$hour,$day,$month,$year,$wday) = explode(',',date("s,i,H,j,n,Y,w",$time));
		if($day != $nday) {
			$newsinfo .= "<span class=\"evergreen\"><B>{$month}月{$day}日(星期$week[$wday])</B></span><br>";
			$nday = $day;
		}

		//登记非功能性地点信息时合并隐藏地点 为什么会有两个news.func.php？？？
		foreach($hplsinfo as $hgroup=>$hpls) $plsinfo += $hpls;
		//死法（除DN外）：道具名登记在$d上；
		if(strpos($news,'death')!==false && $news!=='death28' && isset($d)) $d = parse_nameinfo_desc($d);
		//赠送道具、吃到毒补给、陷阱、改变天气、强化武器、唱歌、打开礼物盒：道具名登记在$c上；
		if((strpos($news,'senditem')!==false||strpos($news,'poison')!==false||strpos($news,'trap')!==false||strpos($news,'wth')!==false||strpos($news,'newwep')!==false||strpos($news,'song')!==false||strpos($news,'present')!==false) && isset($c)) $c = parse_nameinfo_desc($c);
		//合成、使用死斗卡、使用仓库：道具名登记在$b上;
		if((strpos($news,'mix')!==false||strpos($news,'duelkey')!==false||strpos($news,'depot')===0) && isset($b)) $b = parse_nameinfo_desc($b);
	

		if(!empty($old_nicknews[$news]))
		{
			$name = is_array($old_nicknews[$news]) ? $old_nicknews[$news][0] : 'a';
			$nick = is_array($old_nicknews[$news]) ? $old_nicknews[$news][1] : $old_nicknews[$news];
			if(!empty($$nick) || $$nick == 0) $$nick = titles_get_desc($$nick,1);
			$$name = $$nick.' '.$$name;
			unset($name);unset($nick);
		}

		# RuleSet钩子：在固定新闻分支前允许规则集提供完整HTML片段。
		# RuleSet hook: allow a ruleset to provide a complete HTML fragment before built-in news formatting.
		$ruleset_news_html = NULL;
		if(function_exists('ruleset_format_news_hook'))
		{
			$ruleset_news_html = ruleset_format_news_hook($news,$time,$a,$b,$c,$d,$e);
		}

		//$sec='??';
		if($ruleset_news_html !== NULL) {
			$newsinfo .= $ruleset_news_html;
		} elseif($news == 'newgame') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">第{$a}回BR大逃殺開始了</span><br>\n";
		} elseif($news == 'newroomgame') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$b}號房間內，第{$a}回BR大逃殺開始了</span><br>\n";
		} elseif($news == 'gameover') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">第{$a}回BR大逃殺結束了</span><br>\n";
		} elseif($news == 'roomgameover') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$b}號房間內，第{$a}回BR大逃殺結束了</span><br>\n";
		} elseif($news == 'newpc') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}({$b})進入了大逃殺戰場</span><br>\n";
		} elseif($news == 'newgm') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">管理員-{$a}({$b})華麗地亂入了戰場</span><br>\n";
		} elseif($news == 'teammake') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$b}創建了隊伍{$a}</span><br>\n";
		} elseif($news == 'teamjoin') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$b}加入了隊伍{$a}</span><br>\n";
		} elseif($news == 'teamquit') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$b}退出了隊伍{$a}</span><br>\n";
		} elseif($news == 'senditem') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}將<span class=\"yellow\">$c</span>贈送給了{$b}</span><br>\n";
		} elseif($news == 'addarea') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，增加禁區：";
			$alist = explode('_',$a);
			foreach($alist as $ar) {
				$newsinfo .= "{$plsinfo[$ar]} ";
			}
			$newsinfo .= "<span class=\"yellow\">【天氣：{$wthinfo[$b]}】</span><br>\n";
		} elseif($news == 'hack') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}啓動了hack程序，全部禁區解除！</span><br>\n";
		} elseif($news == 'hack2') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}啓動了救濟程序，全部禁區解除！</span><br>\n";
		} elseif($news == 'combo') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">遊戲進入連鬥階段！</span><br>\n";
		} elseif($news == 'comboupdate') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">連鬥判斷死亡數修正為{$a}人，當前死亡數為{$b}人！</span><br>\n";
		} elseif($news == 'duel') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">遊戲進入死鬥階段！</span><br>\n";
		} elseif($news == 'end0') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">遊戲出現故障，意外結束</span><br>\n";
		} elseif($news == 'end1') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">參與者全部死亡！</span><br>\n";
		} elseif($news == 'end2') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">優勝者——{$a}！</span><br>\n";
		} elseif($news == 'end3') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}解除了精神鎖定，遊戲緊急中止</span><br>\n";
		} elseif($news == 'end4') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">無人蔘加，遊戲自動結束</span><br>\n";
		} elseif($news == 'end5') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$a}引爆了核彈，毀壞了虛擬戰場</span><br>\n";
		} elseif($news == 'end6') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">本局遊戲被GM中止</span><br>\n";
		} elseif($news == 'end7') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"minirainbow\">{$a}達成了自己的存在意義，開啓了虛擬幻境的下一個篇章。</span><br>\n";
		} elseif($news == 'revival') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}涅槃重生了！</span><br>\n";
		} elseif($news == 'aurora_revival')  {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}在奧羅拉的作用下原地復活了！</span><br>\n";
		} elseif($news == 'wth18_revival')  {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}在光玉們的幫助下原地復活了！</span><br>\n";
		} elseif(strpos($news,'death') === 0) {
			if(!empty($a) && strpos($a,'|')!==false)
			{
				$arr = explode('|',$a);
				$old_a = $arr[1];
				$a = titles_get_desc($arr[0],1).' '.$arr[1];
				unset($arr);
			}
			if(!empty($c) && strpos($c,'|')!==false)
			{
				$arr = explode('|',$c);
				$c = titles_get_desc($arr[0],1).' '.$arr[1];
				unset($arr);
			}
			if($news == 'death11') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因滯留在<span class=\"red\">禁區【{$plsinfo[$c]}】</span>死亡";
			} elseif($news == 'death12') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因<span class=\"red\">毒發</span>死亡";
			} elseif($news == 'death13') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因<span class=\"red\">意外事故</span>死亡";
			} elseif($news == 'death14') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因<span class=\"red\">入侵禁區系統失敗</span>死亡";
			} elseif($news == 'death15') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被<span class=\"red\">時空特使強行消除</span>";
			} elseif($news == 'death16') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被<span class=\"red\">由理直接拉入SSS團</span>";
			} elseif($news == 'death17') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被<span class=\"red\">冰雹砸死</span>";
			} elseif($news == 'death18') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因<span class=\"red\">燒傷發作</span>死亡";
			} elseif($news == 'death20') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被<span class=\"yellow\">$c</span>用<span class=\"red\">$nowep</span>擊飛";
			} elseif($news == 'death21') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被<span class=\"yellow\">$c</span>使用<span class=\"red\">{$d}</span>毆打致死";
			} elseif($news == 'death22') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被<span class=\"yellow\">$c</span>使用<span class=\"red\">{$d}</span>斬殺";
			} elseif($news == 'death23' || $news == 'death60') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被<span class=\"yellow\">$c</span>使用<span class=\"red\">{$d}</span>射殺";
			} elseif($news == 'death24') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被<span class=\"yellow\">$c</span>投擲<span class=\"red\">{$d}</span>致死";
			} elseif($news == 'death25') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被<span class=\"yellow\">$c</span>埋設<span class=\"red\">{$d}</span>伏擊炸死";
			} elseif($news == 'death29') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被<span class=\"yellow\">$c</span>發動<span class=\"red\">{$d}</span>以靈力殺死";
			} elseif($news == 'death39') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>在與<span class=\"yellow\">$c</span>的戰鬥中因<span class=\"red\">武器反噬</span>意外身亡";
			} elseif($news == 'death26') {
				if($c) {
					$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因食用了<span class=\"yellow\">$c</span>下毒的<span class=\"red\">{$d}</span>被毒死";
				} else {
					$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因食用了有毒的<span class=\"red\">{$d}</span>被毒死";
				}
			} elseif($news == 'death27') {
				if(($c)&&($c!=' ')){
					$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因觸發了<span class=\"yellow\">$c</span>設置的陷阱<span class=\"red\">{$d}</span>被殺死";
				} else {
					$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因觸發了陷阱<span class=\"red\">{$d}</span>被殺死";
				}
			} elseif($news == 'death28') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因<span class=\"yellow\">$d</span>意外身亡";
			} elseif($news == 'death30') {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因誤觸偽裝成核彈按鈕的蛋疼機關被炸死";
			} elseif($news == 'death31'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因L5發作自己撓破喉嚨身亡！";
			} elseif($news == 'death32'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，躲藏於<span class=\"red\">$plsinfo[$c]</span>的<span class=\"yellow\">$a</span><span class=\"red\">掛機時間過長</span>，被在外等待的憤怒的玩家們私刑處死！";
			} elseif($news == 'death33'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因捲入特殊部隊『天使』的實彈演習，被墜落的少女和機體“親吻”而死";
			} elseif($news == 'death34'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因攝入過量突變藥劑，身體組織崩解而死！";
			} elseif($news == 'death35'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因為敵意過剩，被虛擬意識救♀濟！";
			} elseif($news == 'death36'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因為敵意過剩，被虛擬意識腰★斬！";
			} elseif($news == 'death37'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因為敵意過剩，被虛擬意識斷★頭！";
			} elseif($news == 'death38'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因為敵意過剩，被虛擬意識救♀濟！";
			} elseif($news == 'death40'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被御柱創死了！";
			} elseif($news == 'death42'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>活用了單人脱出程序機構，提前離開了虛擬幻境！";
			} elseif($news == 'death44'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因為提取過於強大的力量而透支了生命";
			} elseif($news == 'death45'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>在戰鬥中引爆代碼片段而炸死了自己";
			} elseif($news == 'death50'){
				$newsinfo .= "<li><span class=\"rainbow\">{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>犧牲了自己，在虛擬幻境的天空中炸出了一片紅霞</span>！";
			} else {
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>因<span class=\"red\">不明原因</span>死亡";
			}
			if(!isset($old_a)) $old_a = $a;
			if($b) $dname = $typeinfo[$b].' '.$old_a;
			else $dname = $typeinfo[0].' '.$old_a;
			unset($old_a);
//			if($b == 0) {
//				//$dname = $a;
//				$lwresult = $db->query("SELECT lastword FROM {$gtablepre}users WHERE username = '$a'");
//				$lastword = $db->result($lwresult, 0);
//			} else {
//				//$dname = $typeinfo[$b].' '.$a;
//				$lastword = is_array($lwinfo[$b]) ? $lwinfo[$b][$a] : $lwinfo[$b];
//			}
			if(!$e){
				$newsinfo .= "<span class=\"yellow\">【{$dname} 什麼都沒説就死去了】</span><br>\n";
			}else{
				$newsinfo .= "<span class=\"yellow\">【{$dname}：“{$e}”】</span><br>\n";
			}
		} elseif($news == 'poison') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"purple\">{$a}食用了{$b}下毒的{$c}</span><br>\n";
		} elseif($news == 'trap') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$a}中了{$b}設置的陷阱{$c}</span><br>\n";
		} elseif($news == 'trapmiss') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}迴避了{$b}設置的陷阱{$c}</span><br>\n";
		} elseif($news == 'trapdef') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}依靠迎擊裝備抵禦了{$b}設置的陷阱{$c}的傷害</span><br>\n";
		} elseif($news == 'duelkey') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}使用了{$b}，啓動了死鬥程序！</span><br>\n";
		} elseif($news == 'corpseclear') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}使用了凸眼魚，{$b}具屍體被吸走了！</span><br>\n";
		} elseif($news == 'corpsegather') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}使用了魚眼凸，將{$b}具屍體吸到了自己的位置！</span><br>\n";
		} elseif($news == 'wthchange') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}使用了{$c}，天氣變成了{$wthinfo[$b]}！</span><br>\n";
		} elseif($news == 'wthfail') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}使用了{$c}，但是天氣並未發生改變！</span><br>\n";
		} elseif($news == 'wth18end') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"grey\">光玉雨停下了……</span><br>\n";
		} elseif($news == 'syswthchg') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">奇蹟和魔法都是存在的！當前天氣變成了{$wthinfo[$a]}！</span><br>\n";
		} elseif($news == 'sysaddarea') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">奇蹟和魔法都是存在的！禁區提前增加了！</span><br>\n";
		} elseif($news == 'syshackchg') {
			if($a){$hackword = '全部禁區都被解除了';$class = 'lime';}
			else{$hackword = '禁區恢復了未解除狀態';$class = 'yellow';}
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"{$class}\">奇蹟和魔法都是存在的！{$hackword}！</span><br>\n";
		} elseif($news == 'sysgschg') {
			if($a == 20){
				$chgword = '當前遊戲立即開始了！';
				$class = 'lime';
			}	elseif($a == 30){
				$chgword = '當前遊戲停止激活！';
				$class = 'yellow';
			}	elseif($a == 40){
				$chgword = '當前遊戲進入連鬥階段！';
				$class = 'red';
			}	elseif($a == 50){
				$chgword = '當前遊戲進入死鬥階段！';
				$class = 'red';
			}	else{
				$chgword = '異常語句，請聯繫管理員！';
				$class = 'red';
			}
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"{$class}\">奇蹟和魔法都是存在的！{$chgword}</span><br>\n";
		} elseif($news == 'newwep') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}使用了{$b}，改造了<span class=\"yellow\">$c</span>！</span><br>\n";
		} elseif($news == 'newwep2') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}使用了{$b}，強化了<span class=\"yellow\">$c</span>！</span><br>\n";
		} elseif($news == 'itemmix') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}合成了{$b}</span><br>\n";
		}elseif($news == 'syncmix') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}同調合成了{$b}</span><br>\n";
		}elseif($news == 'overmix') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}超量合成了{$b}</span><br>\n";
		}elseif($news == 'mixfail') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$a}合成遊戲王卡牌失敗，素材全部消失！真是大快人心啊！</span><br>\n";
		}elseif($news == 'npcmove') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，{$a}使<span class=\"yellow\">{$b}</span>的位置移動了！<br>\n";
		}elseif($news == 'song') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}</span>在<span class=\"yellow\">{$b}</span>歌唱了<span class=\"red\">{$c}</span>。<br>\n";
		}  elseif($news == 'itembuy') {
			//$newsinfo .= "<li>{$hour}时{$min}分{$sec}秒，<span class=\"lime\">{$a}购买了{$b}</span><br>\n";
			$newsinfo .= '';
		} elseif($news == 'damage') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"clan\">$a</span><br>\n";
		} elseif($news == 'alive') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被<span class=\"yellow\">神北 小毬許願復活</span><br>\n";
		} elseif($news == 'delcp') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$a}的屍體被時空特使別動隊銷燬了</span><br>\n";
		} elseif($news == 'cstick') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$a}把{$b}作為武器掄了起來！哇……這可真是……</span><br>\n";
		} elseif($news == 'fireseed_recruit') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}將{$b}收納到了自己名下！</span><br>\n";
		} elseif($news == 'editpc') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$a}遭到了黑幕的生化改造！</span><br>\n";
		} elseif($news == 'suisidefail') {
			$newsinfo .= "<li><font style=\"background:url(img/backround4.gif) repeat-x\">{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$a}注射了H173，卻由於RP太高進入了發狂狀態！！</font></span><br>\n";
		} elseif($news == 'inf') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$a}的攻擊致使{$b}</span>{$exdmginf[$c]}<span class=\"red\">了</span><br>\n";
		} elseif($news == 'addnpc') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}亂入戰場！</span><br>\n";
		} elseif($news == 'addnpcs') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$b}名{$a}亂入戰場！</span><br>\n";
		} elseif($news == 'secphase') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}使用了挑戰者之證，讓3名幻影執行官加入了戰場！打倒他們去獲得ID卡來解除遊戲吧！</span><br>\n";
		} elseif($news == 'thiphase') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}觸發了對虛擬現實的救濟！虛擬意識已經在■■■■活性化！</span><br>\n";
		} elseif($news == 'dfphase') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}使用了黑色碎片，讓1名未知存在加入了戰場！打倒她去獲得ID卡來解除遊戲吧！</span><br>\n";
		} elseif($news == 'dfsecphase') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}闖了大禍，打破了Dark Force的封印！</span><br>\n";
		} elseif($news == 'key0'){
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}釋放了少量被封印的NPC存在！</span><br>\n";
		} elseif($news == 'key1'){
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}釋放了第一批被封印的NPC存在！</span><br>\n";
		} elseif($news == 'key2'){
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}釋放了第二批被封印的NPC存在！</span><br>\n";
		} elseif($news == 'key3'){
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}出於未知原因，在戰場上部署了更多的種火！Ψпψтμψхλδ！</span><br>\n";
		} elseif($news == 'fsmove'){
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}在【$plsinfo[$c]】移動了全部種火NPC的位置！真是不解風情啊！</span><br>\n";
		} elseif($news == 'keyuu'){
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}在【$plsinfo[$c]】向紅暮和藍凝發起了挑戰！</span><br>\n";
		} elseif($news == 'evonpc') {
			if($a == 'Dark Force幼體'){
				$nword = "<span class=\"lime\">{$c}擊殺了{$a}，卻沒料到這只是幻影……{$b}的封印已經被破壞了！</span>";
			}elseif($a == '小萊卡'){
				$nword = "<span class=\"lime\">{$c}擊殺了{$a}，卻發現這只是幻象……真正的{$b}受到驚動，方才加入戰場！</span>";
			}else{
				$nword = "<span class=\"lime\">{$c}擊殺了{$a}，卻發現對方展現出了第二形態：{$b}！</span>";
			}
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，$nword<br>\n";
		} elseif($news == 'notworthit') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}做出了一個他自己可能會後悔很長一段時間的決定。</span><br>\n";
		} elseif($news == 'npcplatformusage') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}決定化身成為全新的自我。</span><br>\n";
		} elseif($news == 'present') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}打開了{$b}，獲得了{$c}！</span><br>\n";
		} elseif($news == 'emix_success') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}用零散的元素組合出了{$b}！</span><br>\n";
		} elseif($news == 'emix_failed') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$a}試圖把零散的元素重新組合起來，但是失敗了！哎呀呀、這可真是……</span><br>\n";
		} elseif($news == 'gpost') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"sienna\">{$a}為{$c}贊助了{$e}份{$b}！快遞員正帶着包裹前往【{$plsinfo[$d]}】</span><br>\n";
		} elseif($news == 'gpost_success') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"sienna\">{$a}向{$c}贊助的{$b}已成功送達！</span><br>\n";
		} elseif($news == 'gpost_failed') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"sienna\">{$a}向場內玩家贊助的{$b}竟然被人半路截走了！真是天有不測風雲……</span><br>\n";
		} elseif($news == 'depot_save') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"grey\">{$a}向安全箱中存入了道具{$b}。</span><br>\n";
		} elseif($news == 'depot_load') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"grey\">{$a}從安全箱中取出了道具{$b}。</span><br>\n";
		} elseif($news == 'loot_depot') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"grey\">{$a}將{$b}生前存放在安全箱裏的東西轉移到了自己的名下。哇……真是世風日下，道德淪喪啊！</span><br>\n";
		} elseif($news == 'cdestroy') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$a}把{$b}的屍體銷燬了</span><br>\n";
		} elseif($news == 'cesplit') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"red\">{$a}把{$b}的屍體提煉成了元素</span><br>\n";
		} elseif($news == 'ctozombie') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"mtgblack\">{$a}把{$b}的屍體轉化成了靈俑...</span><br>\n";
		} elseif($news == 'csl_wthchange') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"orange\">{$a}發送了控制指令，戰場的天氣變成了{$wthinfo[$b]}！</span><br>\n";
		} elseif($news == 'csl_hack') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"orange\">{$a}發送了控制指令，全部禁區解除！</span><br>\n";
		} elseif($news == 'csl_addarea') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"orange\">{$a}發送了控制指令，下一回禁區提前到來了！</span><br>\n";
		} elseif(strpos($news,'ask_')===0) {
			$ask = substr($news,4);
			$aname = $cskills[$ask]['name'];
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"lime\">{$a}發動了技能<span class=\"yellow\">「{$aname}」</span>！</span><br>\n";
		} elseif(strpos($news,'bsk_')===0) {
			$bsk = substr($news,4);
			$bname = $cskills[$bsk]['name'];
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"clan\">{$a}對{$b}發動了技能<span class=\"yellow\">「{$bname}」</span>！</span><br>\n";
		} elseif(strpos($news,'getsk_')===0) {
			$bsk = substr($news,6);
			$bname = $cskills[$bsk]['name'];
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}通過翻閲{$b}學會了技能<span class=\"lime\">「{$bname}」</span>！</span><br>\n";
		} elseif(strpos($news,'inssk_')===0) {
			$bsk = substr($news,6);
			$skname = $cskills[$b]['name'];
			if($bsk == 'failed'){
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}發動了「{$skname}」！但是什麼也沒學會……</span><br>\n";
			}else {
				$bname = $cskills[$bsk]['name'];
				$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}通過「{$skname}」學會了技能<span class=\"lime\">「{$bname}」</span>！</span><br>\n";
			}
		} elseif(strpos($news,'mercmove')===0) {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}指揮傭兵 {$b}移動到了{$plsinfo[$c]}！</span><br>\n";
		} elseif(strpos($news,'mercleave')===0) {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"yellow\">{$a}的傭兵 {$b}離開了戰場！</span><br>\n";
		} elseif($news == 'sparklemove') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"mtgred\">{$a}點燃火花將{$b}傳送到了{$c}！</span><br>\n";
		} elseif($news == 'sparklerevival') {
			$newsinfo .= "<li>{$hour}時{$min}分{$sec}秒，<span class=\"mtggreen\">{$a}在危急時刻點燃火花傳送到了{$c}！</span><br>\n";
		} else {
			$newsinfo .= "<li>$time,$news,$a,$b,$c,$d<br>\n";
		}
	}

	$newsinfo .= '</ul>';
	return $newsinfo;
		
}

?>
