<?php


if(!defined('IN_GAME')) {
	exit('Access Denied');
}



function getword(){
	global $db,$gtablepre,$tablepre,$name,$motto,$lastword,$killmsg;
	global $udata;
	//$result = $db->query("SELECT * FROM {$gtablepre}users WHERE username='$name'");
	//$userinfo = $db->fetch_array($result);
	$userinfo = $udata;
	$motto = $userinfo['motto'];
	$lastword = $userinfo['lastword'];
	$killmsg = $userinfo['killmsg'];
	
}

function chgword($nmotto,$nlastword,$nkillmsg) {
	global $db,$gtablepre,$tablepre,$name,$log;
	global $udata;
	//$result = $db->query("SELECT * FROM {$gtablepre}users WHERE username='$name'");
	//$userinfo = $db->fetch_array($result);
	$userinfo = $udata;
//	foreach ( Array('<','>',';',',','\\\'','\\"') as $value ) {
//		if(strpos($nmotto,$value)!==false){
//			$nmotto = str_replace ( $value, '', $nmotto );
//		}
//		if(strpos($nlastword,$value)!==false){
//			$nlastword = str_replace ( $value, '', $nlastword );
//		}
//		if(strpos($nkillmsg,$value)!==false){
//			$nkillmsg = str_replace ( $value, '', $nkillmsg );
//		}
//	}

	
	if($nmotto != $userinfo['motto']) {
		$log .= $nmotto == '' ? '口頭禪已清空。' : '口頭禪變更為<span class="yellow">'.$nmotto.'</span>。<br>';
	}
	if($nlastword != $userinfo['lastword']) {
		$log .= $nlastword == '' ? '遺言已清空。' : '遺言變更為<span class="yellow">'.$nlastword.'</span>。<br>';
	}
	if($nkillmsg != $userinfo['killmsg']) {
		$log .= $nkillmsg == '' ? '殺人留言已清空。' : '殺人留言變更為<span class="yellow">'.$nkillmsg.'</span>。<br>';
	}

	$db->query("UPDATE {$gtablepre}users SET motto='$nmotto', lastword='$nlastword', killmsg='$nkillmsg' WHERE username='$name'");
	
	$mode = 'command';
	return;
}

function chgpassword($oldpswd,$newpswd,$newpswd2){
	global $db,$gtablepre,$tablepre,$name,$log;
	
	if (!$oldpswd || !$newpswd || !$newpswd2){
		$log .= '放棄了修改密碼。<br />';
		$mode = 'command';
		return;
	} elseif ($newpswd !== $newpswd2) {
		$log .= '<span class="red">兩次輸入的新密碼不一致。</span><br />';
		$mode = 'command';
		return;
	}
	
	$oldpswd = md5($oldpswd);$newpswd = md5($newpswd);
	
	$result = $db->query("SELECT * FROM {$gtablepre}users WHERE username='$name'");
	$userinfo = $db->fetch_array($result);
	
	if($oldpswd == $userinfo['password']){
		$db->query("UPDATE {$gtablepre}users SET `password` ='$newpswd' WHERE username='$name'");
		$log .= '<span class="yellow">密碼已修改！</span><br />';
		
		//include_once GAME_ROOT.'./include/global.func.php';
		
		gsetcookie('pass',$newpswd);
		$mode = 'command';
		return;
	}else{
		$log .= '<span class="red">原密碼輸入錯誤！</span><br />';
		$mode = 'command';
		return;
	}
}
function oneonone($sb,$sf){
	global $db,$gold,$mode,$now,$gtablepre,$tablepre,$log,$name,$art,$arte,$artk,$arts,$artsk;
	$mode = 'command';
	if($sb == $sf){
		$log .= "不能自我約戰。<br>";
		return;
	}
	if(($artk=='XX')||($artk=='XY')){
		$log .= "不能重複約戰。<br>";
		return;
	}
	$result = $db->query("SELECT * FROM {$tablepre}players WHERE name='$sb' AND type = 0");
	$edata = $db->fetch_array($result);
	$a1=$edata['art'];
	$a2=$edata['artk'];
	$a3=$edata['pid'];
	$a4=$edata['hp'];
	if (!$a3){
		$log .= "該ID不存在！<br>";
		return;
	}
	if (!$a4){
		$log .= "不能和死人約戰。<br>";
		return;
	}
	$result = $db->query("SELECT * FROM {$tablepre}players WHERE name='$sf' AND type = 0");
	$edata = $db->fetch_array($result);
	$a1=$edata['money'];
	if ($a1<1500){
		$log .= "需要攜帶1500G才能約戰。<br>";
		return;
	}
	$result = $db->query("SELECT * FROM {$gtablepre}users WHERE username='$sb'");
	$edata = $db->fetch_array($result);
	$a1=$edata['ip'];
	$result = $db->query("SELECT * FROM {$gtablepre}users WHERE username='$sf'");
	$edata = $db->fetch_array($result);
	$a2=$edata['ip'];
	if($a1 == $a2){
		//$log .= "不能自我约战。<br>";
		//return;
	}
	if(preg_match('/[,|<|>|&|;|#|"|\s|\p{C}]+/u',$sb)) { $log.='請不要嘗試注入……';return; }
	$art=$sb;$artk='XY';$arte=1;$arts=1;$artsk='';
	$taunt=$sf.'喊道：“'.$sb.'，來，戰♂個♂痛♂快！”';
	$db->query("INSERT INTO {$tablepre}chat (type,`time`,send,msg) VALUES ('4','$now','$name','$taunt')");
	$result = $db->query("SELECT * FROM {$tablepre}players WHERE name='$sb' AND type = 0");
	$edata = $db->fetch_array($result);
	$a1=$edata['art'];
	$a2=$edata['artk'];
	if (($a1==$sf)&&($a2=='XY')){
		$artk='XX';
		$db->query ( "UPDATE {$tablepre}players SET artk='XX' WHERE `name` ='$sb' AND type=0 ");
		$taunt='約戰成立！';
		$db->query("INSERT INTO {$tablepre}chat (type,`time`,send,msg) VALUES ('4','$now','$name','$taunt')");
	}
	return;
}

function adtsk(){
	global $log,$mode,$club,$wep,$wepk,$wepe,$weps,$wepsk;
	if($wepk == 'WN' || !$wepe || !$weps){
		$log .= '<span class="red">你沒有裝備武器，無法改造！</span><br />';
		$mode = 'command';
		return;
	}
	if (strpos($wepsk,'j')!==false){
				$log.='多重武器不能改造。<br>';
				$mode='command';
				return;
			}
	if($club == 7){//电脑社，电气改造
		$position = 0;
		foreach(Array(1,2,3,4,5,6) as $imn){
			global ${'itm'.$imn},${'itmk'.$imn},${'itme'.$imn},${'itms'.$imn},${'itmsk'.$imn}, ${'itmpara'.$imn};
			if(strpos(${'itmk'.$imn},'B')===0 && ${'itme'.$imn} > 0 ){
				$position = $imn;
				break;
			}
		}
		if($position){
			if(strpos($wepsk,'e')!==false){
				$log .= '<span class="red">武器已經帶有電擊屬性，不用改造！</span><br />';
				$mode = 'command';
				return;
			}elseif(strlen($wepsk)>=40){
				$log .= '<span class="red">武器屬性數目達到上限，無法改造！</span><br />';
				$mode = 'command';
				return;
			}
			
			
			${'itms'.$position}-=1;
			$itm = ${'itm'.$position};
			$log .= "<span class=\"yellow\">用{$itm}改造了{$wep}，{$wep}增加了電擊屬性！</span><br />";
			$wep = '電氣'.$wep;
			$wepsk .= 'e';
			if(${'itms'.$position} == 0){
				$log .= "<span class=\"red\">$itm</span>用光了。<br />";
				${'itm'.$position} = ${'itmk'.$position} = ${'itmsk'.$position} = ${'itmpara'.$position} = '';
				${'itme'.$position} =${'itms'.$position} =0;				
			}
			$mode = 'command';
			return;
		}else{
			$log .= '<span class="red">你沒有電池，無法改造武器！</span><br />';
			$mode = 'command';
			return;
		}
	}elseif($club == 8){//带毒改造
		$position = 0;
		foreach(Array(1,2,3,4,5,6) as $imn){
			global ${'itm'.$imn},${'itmk'.$imn},${'itme'.$imn},${'itms'.$imn},${'itmsk'.$imn},${'itmpara'.$imn};
			if(${'itm'.$imn} == '毒藥' && ${'itmk'.$imn} == 'Y' && ${'itme'.$imn} > 0 ){
				$position = $imn;
				break;
			}
		}
		if($position){
			if(strpos($wepsk,'p')!==false){
				$log .= '<span class="red">武器已經帶毒，不用改造！</span><br />';
				$mode = 'command';
				return;
			}elseif(strlen($wepsk)>=40){
				$log .= '<span class="red">武器屬性數目達到上限，無法改造！</span><br />';
				$mode = 'command';
				return;
			}
			$wepsk .= 'p';
			$log .= "<span class=\"yellow\">用毒藥為{$wep}淬毒了，{$wep}增加了帶毒屬性！</span><br />";
			$wep = '毒性'.$wep;
			${'itms'.$position}-=1;
			$itm = ${'itm'.$position};
			if(${'itms'.$position} == 0){
				$log .= "<span class=\"red\">$itm</span>用光了。<br />";
				${'itm'.$position} = ${'itmk'.$position} = ${'itmsk'.$position} = ${'itmpara'.$position}= '';
				${'itme'.$position} =${'itms'.$position} =0;				
			}
			$mode = 'command';
			return;
		}else{
			$log .= '<span class="red">你沒有毒藥，無法給武器淬毒！</span><br />';
			$mode = 'command';
			return;
		}
	}else{
		$log .= '<span class="red">你不懂得如何改造武器！</span><br />';
		$mode = 'command';
		return;
	}
}

function trap_adtsk($which){
	global $log,$mode,$club,${'itm'.$which},${'itmk'.$which},${'itme'.$which},${'itms'.$which},${'itmpara'.$which};
	if(strpos(${'itmk'.$which},'T')!==0){
		$log .= '<span class="red">這個物品不是陷阱，無法改造！</span><br />';
		$mode = 'command';
		return;
	}
	if(${'itmk'.$which}=='TOc' || ${'itmk'.$which}=='TNc'){
		$log .= '<span class="red">奇蹟陷阱不允許改造！</span><br />';
		$mode = 'command';
		return;
	}
	if($club == 7){//电脑社，电气改造
		if (strpos(${'itm'.$which},'電氣')!==false){
			$log .= '<span class="red">陷阱已經帶有電擊屬性，不用改造！</span><br />';
			$mode='command';
			return;
		}
		$position = 0;
		foreach(Array(1,2,3,4,5,6) as $imn){
			global ${'itm'.$imn},${'itmk'.$imn},${'itme'.$imn},${'itms'.$imn},${'itmsk'.$imn};
			if(strpos(${'itmk'.$imn},'B')===0 && ${'itme'.$imn} > 0 ){
				$position = $imn;
				break;
			}
		}
		if($position){
			${'itms'.$position}-=1;
			$itm = ${'itm'.$position}; $citm=${'itm'.$which};
			$log .= "<span class=\"yellow\">用{$itm}改造了{$citm}，{$citm}增加了電擊屬性！</span><br />";
			${'itm'.$which} = '電氣'.${'itm'.$which};
			if(${'itms'.$position} == 0){
				$log .= "<span class=\"red\">$itm</span>用光了。<br />";
				${'itm'.$position} = ${'itmk'.$position} = ${'itmsk'.$position} = ${'itmpara'.$position} = '';
				${'itme'.$position} =${'itms'.$position} =0;				
			}
			$mode = 'command';
			return;
		}else{
			$log .= '<span class="red">你沒有電池，無法改造陷阱！</span><br />';
			$mode = 'command';
			return;
		}
	}elseif($club == 8){//带毒改造
		if (strpos(${'itm'.$which},'毒性')!==false){
			$log .= '<span class="red">陷阱已經帶毒，不用改造！</span><br />';
			$mode='command';
			return;
		}
		$position = 0;
		foreach(Array(1,2,3,4,5,6) as $imn){
			global ${'itm'.$imn},${'itmk'.$imn},${'itme'.$imn},${'itms'.$imn},${'itmsk'.$imn};
			if(${'itm'.$imn} == '毒藥' && ${'itmk'.$imn} == 'Y' && ${'itme'.$imn} > 0 ){
				$position = $imn;
				break;
			}
		}
		if($position){
			${'itms'.$position}-=1;
			$itm = ${'itm'.$position}; $citm=${'itm'.$which};
			$log .= "<span class=\"yellow\">用{$itm}改造了{$citm}，{$citm}增加了帶毒屬性！</span><br />";
			${'itm'.$which} = '毒性'.${'itm'.$which};
			if(${'itms'.$position} == 0){
				$log .= "<span class=\"red\">$itm</span>用光了。<br />";
				${'itm'.$position} = ${'itmk'.$position} = ${'itmsk'.$position} = ${'itmpara'.$position} = '';
				${'itme'.$position} =${'itms'.$position} =0;				
			}
			$mode = 'command';
			return;
		}else{
			$log .= '<span class="red">你沒有毒藥，無法給武器淬毒！</span><br />';
			$mode = 'command';
			return;
		}
	}else{
		$log .= '<span class="red">你不懂得如何改造陷阱！</span><br />';
		$mode = 'command';
		return;
	}
}

function syncro($sb){
	global $itm0,$itmk0,$itme0,$itms0,$itmsk0,$name,$nick;
	list($n,$k,$e,$s,$sk,$r)=explode('_',$sb);
	$itm0=$n;$itmk0=$k;$itme0=$e;$itms0=$s;$itmsk0=$sk;
	if ($r>0) {addnews($now,'syncmix',$name,$itm0,$nick);}
	else {addnews($now,'overmix',$name,$itm0,$nick);}
			//检查成就
			include_once GAME_ROOT.'./include/game/achievement.func.php';
			check_mixitem_achievement_rev($name,$itm0);
	include_once GAME_ROOT.'./include/game/itemmain.func.php';
	itemget();
	return;
}
function weaponswap(){
	global $log,$mode,$club,$wep,$wepk,$wepe,$weps,$wepsk,$weppara,$gamecfg;
	if (strpos($wepsk,'j')===false){
		$log.='你的武器不能變換。<br>';
		$mode = 'command';
		return;
		}
	$oldw=$wep;
	$file = config('wepchange',$gamecfg);
	$wlist = openfile($file);
	$wnum = count($wlist)-1;
	for ($i=0;$i<=$wnum;$i++){
		list($on,$nn,$nk,$ne,$ns,$nsk,$npara) = explode(',',$wlist[$i]);
		if ($wep==$on){
			$wep=$nn;$wepk=$nk;$wepe=$ne;$weps=$ns;$wepsk=$nsk;$weppara=$npara;
			$log.="<span class=\"yellow\">{$oldw}</span>變換成了<span class=\"yellow\">{$wep}</span>。<br>";
			return;
		}
	}
	$log.="<span class=\"yellow\">{$oldw}</span>由於改造或其他原因不能變換。<br>";
}
function chginf($infpos){
	global $log,$mode,$inf,$inf_sp,$inf_sp_2,$sp,$infinfo,$exdmginf,$club;
	$normalinf = Array('h','b','a','f');
	if(!$infpos){$mode = 'command';return;}
	if($infpos == 'A'){  
		if($club == 16){
			$spdown = 0;
			foreach($normalinf as $value){
				if(strpos($inf,$value)!== false){
					$spdown += $inf_sp;
				}
			}
			if(!$spdown){
				$log .= '你並沒有受傷！';
				$mode = 'command';
				return;
			}elseif($sp <= $spdown){
				$log .= "包紮全部傷口需要{$spdown}點體力，先回復體力吧！";
				$mode = 'command';
				return;
			}
			$inf = str_replace('h','',$inf);
			$inf = str_replace('b','',$inf);
			$inf = str_replace('a','',$inf);
			$inf = str_replace('f','',$inf);
			$sp -= $spdown;
			$log .= "消耗<span class=\"yellow\">$spdown</span>點體力，全身傷口都包紮好了！";
			$mode = 'command';
			return;
		}else{
			$log .= '你不懂得怎樣快速包紮傷口！';
			$mode = 'command';
			return;
		}
	}elseif(in_array($infpos,$normalinf) && strpos($inf,$infpos) !== false){	//普通伤口
		if($sp <= $inf_sp) {
			$log .= "包紮傷口需要{$inf_sp}點體力，先回復體力吧！";
			$mode = 'command';
			return;
		} else {
			$inf = str_replace($infpos,'',$inf);
			$sp -= $inf_sp;
			$log .= "消耗<span class=\"yellow\">$inf_sp</span>點體力，{$infinfo[$infpos]}<span class=\"red\">部</span>的傷口已經包紮好了！";
			$mode = 'command';
			return;
		}
	}elseif(strpos($inf,$infpos) !== false){  //特殊状态
		if($club == 16){
			if($sp <= $inf_sp_2) {
				$log .= "處理異常狀態需要{$inf_sp_2}點體力，先回復體力吧！";
				$mode = 'command';
				return;
			} else {
				$inf = str_replace($infpos,'',$inf);
				$sp -= $inf_sp_2;
				$log .= "消耗<span class=\"yellow\">$inf_sp_2</span>點體力，{$exdmginf[$infpos]}狀態已經完全治癒了！";
				$mode = 'command';
				return;
			}
		}else{
			$log .= '你不懂得怎樣治療異常狀態！';
			$mode = 'command';
			return;
		}
	}else{
		$log .= '你不需要包紮這個傷口！';
		$mode = 'command';
		return;
	}
}

function chkpoison($itmn){
	global $log,$mode,$club;
	if($club != 8){
		$log .= '你不會查毒。';
		$mode = 'command';
		return;
	}

	if ( $itmn < 1 || $itmn > 6 ) {
		$log .= '此道具不存在，請重新選擇。';
		$mode = 'command';
		return;
	}

	global ${'itm'.$itmn},${'itmk'.$itmn},${'itme'.$itmn},${'itms'.$itmn},${'itmsk'.$itmn};
	$itm = & ${'itm'.$itmn};
	$itmk = & ${'itmk'.$itmn};
	$itme = & ${'itme'.$itmn};
	$itms = & ${'itms'.$itmn};
	$itmsk = & ${'itmsk'.$itmn};

	if(!$itms) {
		$log .= '此道具不存在，請重新選擇。<br>';
		$mode = 'command';
		return;
	}
	
	if(strpos($itmk,'P') === 0) {
		$log .= '<span class="red">'.$itm.'有毒！</span>';
	} else {
		$log .= '<span class="yellow">'.$itm.'是安全的。</span>';
	}
	$mode = 'command';
	return;
}

function press_bomb(){
	global $log,$mode,$club,$wp,$wk,$wg,$wc,$wd,$wf,$mhp,$hp,$msp,$sp,$att,$def,$rage,$lvl;
	if($club != 99){
		$log .= '你的稱號不能使用該技能。';
		$mode = 'command';
		return;
	}

	$club=17;
	$wp=ceil($wp*1.2); $wk=ceil($wk*1.2); $wg=ceil($wg*1.2); $wc=ceil($wc*1.2); $wd=ceil($wd*1.2); $wf=ceil($wf*1.2);
	$mhp=ceil($mhp*1.15); $hp=ceil($hp*1.15); $msp=ceil($msp*1.15); $sp=ceil($sp*1.15); 
	$att=ceil($att*1.2); $def=ceil($def*1.2); $rage+=$lvl*10; 
	$log.="你按下了X按鈕，你突然感覺到一股力量貫通全身！"; 
	$mode = 'command';
	return;
}

function shoplist($sn,$getlist=NULL) {
	global $gamecfg,$mode,$itemdata,$areanum,$areaadd,$iteminfo,$itemspkinfo,$club,$horizon;
	global $db,$tablepre;
	$arean = floor($areanum / $areaadd); 
	$result=$db->query("SELECT * FROM {$tablepre}shopitem WHERE kind = '$sn' AND area <= '$arean' AND num > '0' AND price > '0' ORDER BY sid");
	$shopnum = $db->num_rows($result);
	$itemdata = Array();
	for($i=0;$i< $shopnum;$i++){
		$itemlist = $db->fetch_array($result);
		$itemdata[$i]['sid']=$itemlist['sid'];
		$itemdata[$i]['kind']=$itemlist['kind'];
		$itemdata[$i]['num']=$itemlist['num'];
		$itemdata[$i]['price']= $club == 11 ? round($itemlist['price']*0.75) : $itemlist['price'];
		$itemdata[$i]['area']=$itemlist['area'];
		$itemdata[$i]['item']=$itemlist['item'];
		$itemdata[$i]['item_words']= parse_nameinfo_desc($itemdata[$i]['item'],$horizon);
		$itemdata[$i]['itme']=$itemlist['itme'];
		$itemdata[$i]['itms']=$itemlist['itms'];

		foreach($iteminfo as $info_key => $info_value){
			if(strpos($itemlist['itmk'],$info_key)===0){
				if(isset($getlist)) $itemdata[$i]['itmk'] = $info_value;
				break;
			}
		}
		$itemdata[$i]['itmk_words'] = parse_kinfo_desc($itemlist['itmk'],$itemlist['itmsk']);
		$itemdata[$i]['itmsk_words'] = '';
		if($itemlist['itmsk'] && ! is_numeric($itemlist['itmsk'])){
			if(!isset($getlist))
			{
				$itemdata[$i]['itmsk_words'] = parse_skinfo_desc($itemlist['itmsk'],$itemlist['itmk']);
			}
			else 
			{
				for ($j = 0; $j < strlen($itemlist['itmsk']); $j++) {
					$sub = substr($itemlist['itmsk'],$j,1);
					if(!empty($sub) && isset($itemspkinfo[$sub])){
						$itemdata[$i]['itmsk_words'] .= $itemspkinfo[$sub];
					}
				}
			}
		}
		//$itemdata[$i] = array('sid' => $sid, 'kind' => $kind,'num' => $num, 'price' => $price, 'area' => $area, 'item' => $item,'itmk_words' => $itmk_words,'itme' => $itme, 'itms' => $itms,'itmsk_words' => $itmsk_words);
	}

	if(isset($getlist)) return $itemdata;
	
	$mode = 'shop';

	return;

}
