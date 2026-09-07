<?php
if(!defined('IN_GAME')) {
	exit('Access Denied');
}



function use_func_item($usemode,$item)
{
	if ($usemode=="poison"){poison($item);}
	elseif ($usemode=="wthchange"){wthchange($item);}
	elseif ($usemode=="hack") {hack($item);}
	elseif ($usemode=="newradar") {newradar($item);}
	elseif ($usemode=="divining") {divining($item);}
	elseif ($usemode=="divining1") {divining1($item);}
	elseif ($usemode=="divining2") {divining2($item);}
	elseif ($usemode=="deathnote") {deathnote($item);}
	elseif ($usemode=="qianghua") {qianghua($item);}
	elseif ($usemode=="nametag") {nametag($item);}
	elseif ($usemode=="supernametag") {supernametag($item);}
}

function poison($itmn = 0) {
	global $mode,$log,$nosta,$art,$club,$pid;
	global $itmp,${'itm'.$itmp},${'itms'.$itmp},${'itmk'.$itmp},${'itme'.$itmp},${'itmsk'.$itmp}, ${'itmpara'. $itmp};
	$poison = & ${'itm'.$itmp};
	$poisonk = & ${'itmk'.$itmp};
	$poisone = & ${'itme'.$itmp};
	$poisons = & ${'itms'.$itmp};
	$poisonsk = & ${'itmsk'.$itmp};
	$poisonpara = & ${'itmpara'. $itmp};
	if ( $itmn < 1 || $itmn > 6 ) {
		$log .= '此道具不存在，請重新選擇。';
		$mode = 'command';
		return;
	}
	global ${'itm'.$itmn},${'itmk'.$itmn},${'itmsk'.$itmn}, ${'itmpara'. $itmn};
	$itm = & ${'itm'.$itmn};
	$itmk = & ${'itmk'.$itmn};
	$itmsk = & ${'itmsk'.$itmn};
	$itmpara = & ${'itmpara'. $itmn};
	if(($poison != '毒藥') || (strpos($itmk, 'H') !==0 && strpos($itmk, 'P') !== 0)) {
		$log .= '道具選擇錯誤，請重新選擇。<br>';
		$mode = 'command';
		return;
	}
	$itmk = substr_replace($itmk,'P',0,1);
	if($club == 8){ $itmk = substr_replace($itmk,'2',2,1); }
	elseif($art == '毒物説明書'){$itmk = substr_replace($itmk,'1',2,1);};
	if($art == '妖精的羽翼') {$itmk = substr_replace($itmk,'H',0,1);$log .= "一種神秘的力量淨化了毒藥，你的毒藥變成了解毒劑！";}
	$itmsk = $pid;
	if($art == '妖精的羽翼') {$log .= "使用了 <span class=\"red\">$poison</span> ，<span class=\"yellow\">{${'itm'.$itmn}}</span> 被淨化了！<br>";}
	else {$log .= "使用了 <span class=\"red\">$poison</span> ，<span class=\"yellow\">{${'itm'.$itmn}}</span> 被下毒了！<br>";}
	$poisons--;
	if($poisons <= 0){
		$log .= "<span class=\"red\">$poison</span> 用光了。<br>";
		$poison = $poisonk = '';$poisone = $poisons = 0;
	}


	$mode = 'command';
	return;
}

function wthchange($itm,$itmsk,$wlog=1){
	global $now,$log,$weather,$wthinfo,$name,$nick,$clbpara;
	$weathertd = $weather;
	if($weather >= 14 && $weather <= 18){
		addnews ( $now, 'wthfail',$name, $weather, $itm , $nick);
		$log .= "你使用了{$itm}。<br /><span class=\"red\">但是天氣並未發生任何變化！</span><br />";
	}else{
		if($itmsk==99){$weather = rand ( 0, 13 );}//随机全天气
		elseif($itmsk==98){$weather = rand ( 10, 13 );}//随机恶劣天气
		elseif($itmsk==97){$weather = rand ( 0, 9 );}//随机一般天气
		elseif($itmsk==96){$weather = rand ( 8, 9 );}//随机起雾天气
		elseif($itmsk==95){$weather = 17;}//极光天气
		elseif(!empty($itmsk) && is_numeric($itmsk)){
			if($itmsk >=0 && $itmsk < count($wthinfo)){
				$weather = $itmsk;
			}else{$weather = 0;}
		}
		else{$weather = 0;}
		
		$flag = false;
		if($itm=='【風神的神德】'){
			//$dice = rand ( 1, 18 );
			$dice = rand ( 1, 30 );
			if ($dice < 18){
				$flag = true;
			} else{
				$weather = 6;
			}
		}
		if($flag){
			global $hp;
			$weather = $weathertd;
			$log .= "你使用了<span class=\"yellow\">{$itm}</span>。<br>“好像沒什麼反應嘛？”";
			//include_once GAME_ROOT . './include/state.func.php';
			//$log .= "你正这样想着，天空中忽然传来一阵巨响！”<br>“祈求神德的话，就以你的生命作为祭品吧！<br>你只来得及看到一个巨大的柱状物飞来，就失去了意识。";
			//death ( 'thunde', '', 0, $itm );
			$log .= "你正這樣想着，天空中忽然傳來一陣巨響！”<br>“祈求神德的話，就以你的生命作為祭品吧！<br>你只來得及看到一個巨大的柱狀物飛來，便覺得眼前一黑！<br>";
			$log .= "<span class = \"damage\">你受到了巨大的傷害！</span>";
			$hp = 9;
		} else {
			include_once GAME_ROOT . './include/system.func.php';
			save_gameinfo ();
			addnews ( $now, 'wthchange', $name, $weather, $itm , $nick);
			if($wlog) $log .= "你使用了<span class=\"yellow\">{$itm}</span>。<br />天氣突然轉變成了<span class=\"red\">$wthinfo[$weather]</span>！<br />";
		}
		$clbpara['achvars']['wthchange'] += 1;
	}
	return;
}

function hack($itmn = 0) {
	global $log,$hack,$hack_obbs,$club,$clbpara,$now,$name,$alivenum,$deathnum,$hp,$state,$nick;
	
	global ${'itm'.$itmn},${'itmk'.$itmn},${'itme'.$itmn},${'itms'.$itmn},${'itmsk'.$itmn}, ${'itmpara'. $itmn};
	$itm = & ${'itm'.$itmn};
	$itmk = & ${'itmk'.$itmn};
	$itme = & ${'itme'.$itmn};
	$itms = & ${'itms'.$itmn};
	$itmsk = & ${'itmsk'.$itmn};
	$itmpara = & ${'itmpara'. $itmn};


	if(!$itms) {
		$log .= '此道具不存在，請重新選擇。<br>';
		$mode = 'command';
		return;
	}

	if(!$itme) {
		$log .= "<span class=\"yellow\">$itm</span>已經沒電，請尋找<span class=\"yellow\">電池</span>充電。<br>";
		$mode = 'command';
		return;
	}

	$hack_dice = rand(0,99);
	if(($hack_dice < $hack_obbs)||(($club == 7)&&($hack_dice<95))) {
		$hack = 1;
		// 确保 clbpara 是数组
		if(!is_array($clbpara)) {
			if(is_string($clbpara)) {
				$clbpara = json_decode($clbpara, true);
			}
			if(!is_array($clbpara)) {
				$clbpara = array();
			}
		}
		// 确保 achvars 数组存在
		if(!isset($clbpara['achvars'])) $clbpara['achvars'] = array();
		// 确保 hack 字段存在且为数字
		if(!isset($clbpara['achvars']['hack']) || !is_numeric($clbpara['achvars']['hack'])) {
			$clbpara['achvars']['hack'] = 0;
		}
		$clbpara['achvars']['hack'] += 1;
		$log .= '入侵禁區控制系統成功了！全部禁區都被解除了！<br>';
		//include_once GAME_ROOT.'./include/system.func.php';
		//movehtm();
		addnews($now,'hack',$name,$nick);
		storyputchat($now,'hack');
		save_gameinfo();
	} else {
		$log .= '可是，入侵禁區控制系統失敗了……<br>';
	}
	if($club == 7){
		$e_dice = rand(0,1);
		if($e_dice == 1){
			$itme--;
			$log .= "消耗了<span class=\"yellow\">$itm</span>的電力。<br>";
		}else{
			$log .= "由於操作迅速，<span class=\"yellow\">$itm</span>的電力沒有消耗。<br>";
		}
	}else{
		$itme--;
		$log .= "消耗了<span class=\"yellow\">$itm</span>的電力。<br>";
	}
	
	$hack_dice2 = rand(0,99);

	if($hack_dice2 < 5 && $club != 7) {
		$log .= '由於你的不當操作，禁區系統防火牆鎖定了你的電腦並遠程引爆了它。幸好你本人的位置並沒有被發現。<br>';
		$itm = $itmk = $itmsk = '';
		$itme = $itms = 0;
	} elseif($hack_dice2 < 8 && $club != 7) {
			$log .= "<span class=\"evergreen\">“小心隔牆有耳哦。”</span>——林無月<br>";
			include_once GAME_ROOT.'./include/state.func.php';
			$log .= '你擅自入侵禁區控制系統，被控制系統遠程消滅！<br>';
			death('hack');
	} elseif($itme <= 0) {
		$log .= "<span class=\"red\">$itm</span>的電池耗盡了。";
	}
	return;
}

function newradar($m = 0){
	global $mode,$log,$cmd,$main,$pls,$db,$tablepre,$plsinfo,$arealist,$areanum,$hack,$gamestate;
	global $pnum,$npc2num,$npc3num,$npc4num,$npc5num,$npc6num,$radarscreen,$typeinfo,$weather;
	global $horizon;
	
	if((CURSCRIPT !== 'botservice') && (!$mode)) {
		$log .= '儀器使用失敗！<br>';
		return;
	}
	//echo $weather;
	if($weather == 14){
		$dice = rand(0,1);
		if($dice == 1){
			$log .= '由於<span class="linen">離子風暴</span>造成了電磁干擾，探測儀器完全顯示不出信息……<br>';
			return;
		}
	}

	if($horizon == 1) 
	{
		$npctplist = Array(92,89);
	}
	else
	{
		$npctplist = Array(90,2,5,6,11,14);
	}
	$tdheight = 20;
	$screenheight = count($plsinfo)*$tdheight;
	if (CURSCRIPT == 'botservice') 
	{
		if ($m==2)
			$result = $db->query("SELECT type,sNo,pls,name FROM {$tablepre}players WHERE hp>0");
		else  $result = $db->query("SELECT type,sNo,pls,name FROM {$tablepre}players WHERE hp>0 AND pls='{$pls}'");
		$rows=$db->num_rows($result);
		echo "radarresultnum=$rows\n";
		$i=0;
		while($data = $db->fetch_array($result)) 
		{
			$i++;
			echo "radarresulttype$i={$data['type']}\n";
			echo "radarresultsNo$i={$data['sNo']}\n";
			echo "radarresultpls$i={$data['pls']}\n";
			echo "radarresultname$i={$data['name']}\n";
		}	
	}
	else
	{
		$result = $db->query("SELECT type,pls FROM {$tablepre}players WHERE hp>0");
		while($cd = $db->fetch_array($result)) {
			$chdata[] = $cd;
		}
		$radar = array();
		foreach ($chdata as $data){
			if(isset($radar[$data['pls']][$data['type']])){$radar[$data['pls']][$data['type']]+=1;}
			else{$radar[$data['pls']][$data['type']]=1;}
		}
		$radarscreen = '<table height='.$screenheight.'px width=720px border="0" cellspacing="0" cellpadding="0" valign="middle"><tbody>';
		$radarscreen .= "<tr>
			<td class=b2 height={$tdheight}px width=120px><div class=nttx></div></td>
			<td class=b2><div class=nttx>{$typeinfo[0]}</div></td>";
		foreach ($npctplist as $value){
			$radarscreen .= "<td class=b2><div class=nttx>{$typeinfo[$value]}</div></td>";
		}
		$radarscreen .= '</tr>';
		for($i=0;$i<count($plsinfo);$i++) {
			$radarscreen .= "<tr><td class=b2 height={$tdheight}px><div class=nttx>{$plsinfo[$i]}</div></td>";
			if((array_search($i,$arealist) > $areanum) || $hack) {
				if($i==$pls) {
					//$result = $db->query("SELECT pid FROM {$tablepre}players WHERE hp>0 AND type='0' AND pls=$i");
					//$num0 = $db->num_rows($result);
					$num0 = $radar[$i][0];
					foreach ($npctplist as $j){
						//$result = $db->query("SELECT pid FROM {$tablepre}players WHERE hp>0 AND type=$j AND pls=$i");
						//${'num'.$j} = $db->num_rows($result);
							if($gamestate == 50){${'num'.$j} = 0;}
						else{
							${'num'.$j} = isset($radar[$i][$j]) ? $radar[$i][$j] : 0;
						}
					}
					if($num0){
						$pnum[$i] ="<span class=\"yellow b\">$num0</span>";
					} else {
						$pnum[$i] ='<span class="yellow b">-</span>';
					}
					foreach ($npctplist as $j){
						//${'npc'.$j.'num'}[$i] = "<span class=\"yellow b\">${'num'.$j}</span>";
						if(${'num'.$j}){
						${'npc'.$j.'num'}[$i] ="<span class=\"yellow b\">{${'num'.$j}}</span>";
						} else {
						${'npc'.$j.'num'}[$i] ='<span class="yellow b">-</span>';
						}
					}
				} elseif($m >= 2) {
					//$result = $db->query("SELECT pid FROM {$tablepre}players WHERE hp>0 AND type='0' AND pls=$i");
					//$num0 = $db->num_rows($result);
					$num0 = isset($radar[$i][0]) ? $radar[$i][0] : 0;
					foreach ($npctplist as $j){
						//$result = $db->query("SELECT pid FROM {$tablepre}players WHERE hp>0 AND type=$j AND pls=$i");
						//${'num'.$j} = $db->num_rows($result);
						if($gamestate == 50){${'num'.$j} = 0;}
						else{
							${'num'.$j} = isset($radar[$i][$j]) ? $radar[$i][$j] : 0;
						}
						
					}
					if ($m==2)
						if($num0){
							$pnum[$i] =$num0;
						} else {
							$pnum[$i] ='-';
						}	
					else  $pnum[$i] = '？';
					//$pnum[$i] ="$num0";
					foreach ($npctplist as $j){
						//${'npc'.$j.'num'}[$i] = "${'num'.$j}";;
						if(${'num'.$j}){
	
							${'npc'.$j.'num'}[$i] =${'num'.$j};

						} else {
							${'npc'.$j.'num'}[$i] ='-';
						}
					}
				} else {
					$pnum[$i] = '？';
					foreach ($npctplist as $j){
						${'npc'.$j.'num'}[$i] = '？';
					}
				}	
			} else {	
				$pnum[$i] = '<span class="red b">×</span>';
				foreach ($npctplist as $j){
				${'npc'.$j.'num'}[$i] = '<span class="red b">×</span>';
				}
			}
			$radarscreen .= "<td class=b3><div class=nttx>{$pnum[$i]}</div></td>";
			foreach ($npctplist as $j){
				$radarscreen .= "<td class=b3><div class=nttx>{${'npc'.$j.'num'}[$i]}</div></td>";
			}	
			$radarscreen .= '</tr>';
		}
		$radarscreen .= '</tbody></table>';
		$log .= '白色數字：該區域內的人數<br><span class="yellow">黃色數字</span>：自己所在區域的人數<br><span class="red b">×</span>：禁區<br><br>';
		include template('radarcmd');
		$cmd = ob_get_contents();
		ob_clean();
		//$cmd = '<input type="radio" name="command" id="menu" value="menu" checked><a onclick=sl("menu"); href="javascript:void(0);" >返回</a><br><br>';
		$main = 'radar';
	}
	return;
}

function divining(){
	global $log;
	
	$dice = rand(0,99);
	if($dice < 20) {
		$up = 5;
		list($uphp,$upatt,$updef) = explode(',',divining1($up));
		$log .= "是大吉！要有什麼好事發生了！<BR><span class=\"yellow b\">【命】+$uphp 【攻】+$upatt 【防】+$updef</span><BR>";
	} elseif($dice < 40) {
		$up = 3;
		list($uphp,$upatt,$updef) = explode(',',divining1($up));
		$log .= "中吉嗎？感覺還不錯！<BR><span class=\"yellow b\">【命】+$uphp 【攻】+$upatt 【防】+$updef</span><BR>";
	} elseif($dice < 60) {
		$up = 1;
		list($uphp,$upatt,$updef) = explode(',',divining1($up));
		$log .= "小吉嗎？有跟無也沒有什麼分別。<BR><span class=\"yellow b\">【命】+$uphp 【攻】+$upatt 【防】+$updef</span><BR>";
	} elseif($dice < 80) {
		$up = 1;
		list($uphp,$upatt,$updef) = explode(',',divining2($up));
		$log .= "兇，真是不吉利。<BR><span class=\"red b\">【命】-$uphp 【攻】-$upatt 【防】-$updef</span><BR>";
	} else {
		$up = 3;
		list($uphp,$upatt,$updef) = explode(',',divining2($up));
		$log .= "大凶？總覺得有什麼可怕的事快要發生了<BR><span class=\"red b\">【命】-$uphp 【攻】-$upatt 【防】-$updef</span><BR>";
	}
	return;
}

function divining1($u) {
	global $hp,$mhp,$att,$def;
	$uphp = rand(0,$u);
	$upatt = rand(0,$u);
	$updef = rand(0,$u);
	
	$hp+=$uphp;
	$mhp+=$uphp;
	$att+=$upatt;
	$def+=$updef;
	
	
	return "$uphp,$upatt,$updef";

}

function divining2($u) {
	global $hp,$mhp,$att,$def;
	$uphp = rand(0,$u);
	$upatt = rand(0,$u);
	$updef = rand(0,$u);
	
	if($hp - $uphp <= 0){
		$uphp = $hp-1;
		if($uphp < 0){$uphp = 0;}
	}
	
	$hp-=$uphp;
	$mhp-=$uphp;
	$att-=$upatt;
	$def-=$updef;
	
	return "$uphp,$upatt,$updef";
}

function deathnote($sfn,$itmd=0,$dnname='',$dndeath='',$dngender='m',$dnicon=1) {
	global $db,$tablepre,$log,$killnum,$mode,$achievement,$pdata;
	global ${'itm'.$itmd},${'itms'.$itmd},${'itmk'.$itmd},${'itme'.$itmd},${'itmsk'.$itmd},${'itmpara'. $itmd};
	$dn = & ${'itm'.$itmd};
	$dnk = & ${'itmk'.$itmd};
	$dne = & ${'itme'.$itmd};
	$dns = & ${'itms'.$itmd};
	$dnsk = & ${'itmsk'.$itmd};
	$dnpara = & ${'itmpara'. $itmd};

	$mode = 'command';

	if($dn != '■DeathNote■' && $dn != '四面親手製作的■DeathNote■' ){
		$log .= '道具使用錯誤！<br>';
		return;
	} elseif($dns <= 0) {
		$dn = $dnk = $dnsk = $dnpara = '';
		$dne = $dns = 0;
		$log .= '道具不存在！<br>';
		return;
	}

	if(!$dnname){return;}
	if($dnname == $sfn && $dn != '四面親手製作的■DeathNote■'){
		$log .= "你不能自殺。<br>";
		return;
	}
	if(!$dndeath){$dndeath = '心臟麻痹';}
	if ($dn == '四面親手製作的■DeathNote■') $dndeath="使用了天然呆四面的假冒偽劣■DeathNote■";
	//echo "name=$dnname,gender = $dngender,icon=$dnicon,";
	if ($dn != '四面親手製作的■DeathNote■') 
		$result = $db->query("SELECT * FROM {$tablepre}players WHERE name='$dnname' AND type = 0");
	else  $result = $db->query("SELECT * FROM {$tablepre}players WHERE name='$sfn' AND type = 0");
	if(!$db->num_rows($result)) { 
		$log .= "你使用了■DeathNote■，但是什麼都沒有發生。<br>哪裏出錯了？<br>"; 
	} else {
		$edata = $db->fetch_array($result);
		
		if((($dngender != $edata['gd'])||($dnicon != $edata['icon'])) && ($dn != '四面親手製作的■DeathNote■')) {
			$log .= "你使用了■DeathNote■，但是什麼都沒有發生。<br>哪裏出錯了？<br>"; 
		} else {
			if ($dn != '四面親手製作的■DeathNote■') 
			{
				$log .= "你將<span class=\"yellow b\">$dnname</span>的名字寫在了■DeathNote■上。<br>";
				$log .= "<span class=\"yellow b\">$dnname</span>被你殺死了。";
				//include_once GAME_ROOT.'./include/state.func.php';
				//kill('dn',$dnname,0,$edata['pid'],$dndeath);
				//$killnum++;
				$pdata['wep_name'] = $dndeath;
				include_once GAME_ROOT.'./include/state.func.php';
				pre_kill_events($pdata,$edata,1,'dn');
				// 如果希望被DN后能够复活，可以在这里调用一次复活判定函数
				final_kill_events($pdata,$edata,1);
				player_save($edata);
			}
			else  
			{
				$log .= "你將<span class=\"yellow b\">$dnname</span>的名字寫在了■DeathNote■上。<br>";
				$log .= "但就在這時，你突然感覺一陣暈眩。<br>你失去了意識。<br>";
				$log .= "<span class='lime'>“這張■DeathNote■似乎製作不合格呢，還真是對不起呢……”<br></span>";
				include_once GAME_ROOT.'./include/state.func.php';
				death ( 'fake_dn', '', 0, $dndeath);
				$killnum++;
			}
		}
	}
	$dns--;
	if($dns<=0){
		$log .= '■DeathNote■突然燃燒起來，轉瞬間化成了灰燼。<br>';
		$dn = $dnk = $dnsk = $dnpara = '';
		$dne = $dns = 0;
	}
	return;
}

function qianghua($itmn = 0) {
	global $mode,$log,$nosta,$name,$nick;
	global $club;
	global $itmp,${'itm'.$itmp},${'itms'.$itmp},${'itmk'.$itmp},${'itme'.$itmp},${'itmsk'.$itmp}, ${'itmpara'. $itmp};
	$baoshi = & ${'itm'.$itmp};
	$baoshie = & ${'itme'.$itmp};
	$baoshis = & ${'itms'.$itmp};
	$baoshik = & ${'itmk'.$itmp};
	$baoshisk = & ${'itmsk'.$itmp};	
	$baoshipara = & ${'itmpara'. $itmp};
	if ( $itmn < 1 || $itmn > 6 ) {
		$log .= '此道具不存在，請重新選擇。';
		$mode = 'command';
		return;
	}
	global ${'itm'.$itmn},${'itme'.$itmn},${'itms'.$itmn},${'itmk'.$itmn},${'itmsk'.$itmn}, ${'itmpara'. $itmn};
	$itm = & ${'itm'.$itmn};
	$itme = & ${'itme'.$itmn};
	$itms = & ${'itms'.$itmn};
	$itmk = & ${'itmk'.$itmn};
	$itmsk = & ${'itmsk'.$itmn};
	$itmpara = & ${'itmpara'. $itmn};
	if($baoshis <= 0 || ($baoshi != '『靈魂寶石』' && $baoshi != '『祝福寶石』')) {
		$log .= '強化道具選擇錯誤，請重新選擇。<br>';
		$mode = 'command';
		return;
	}
	if(!$itms || strpos ( $itmsk, 'Z' ) === false) {
		$log .= '被強化道具選擇錯誤，請重新選擇。<br>';
		$mode = 'command';
		return;
	}
		# Detect if club 21, if so, output easter egg and return.
	if ($club == 21){
		$log .= "<span class=\"yellow\">突然，你的眼前出現了扭曲的字符！</span><br>";
		$log .= "<span class=\"glitchb\">
		“糾結糾結小問號，<br>
		代碼溢出怎麼搞？<br>
		乾脆一刀禁了它。
		反正捱打不用愁！<br>”</span><br>";
		$log .= "<span class=\"yellow\">唔，看起來這個寶石對你似乎沒有什麼意義……</span><br>";
		$mode = 'command';
		return;
		}
	$o_itm = $itm;
	if(!preg_match("/\[\+[0-9]\]/",$itm)){
		$itm = ${'itm'.$itmn}.'[+0]';
//		$itme = round(${'itme'.$itmn} * 1.5);
		$flag = true;
		$zitmlv = 0;
//		var_dump($zitmlv);
	}else{
		//$zitmlv = preg_replace("/\[\+([0-9])\]/","\\1",$zitmlv[0]);
		preg_match("/\[\+([0-9])\]/",$itm,$zitmlv);
		//var_dump($zitmlv);
		$zitmlv = $zitmlv[1];
		//$dengji = substr(${'itm'.$itmn},strpos(${'itm'.$itmn},"[+")+2,strlen(${'itm'.$itmn}) - strpos(${'itm'.$itmn},"]")+1);//北京你自己看着办
    //$dengji = str_replace(']','',$dengji);
		if($zitmlv >= 4 && $baoshi != '『靈魂寶石』'){
			$log .= '你所選的寶石只能強化裝備到[+4]哦!DA☆ZE<br>';
		  $mode = 'command';
			return;
		}else{
			if ($zitmlv==3 && $baoshi=='『祝福寶石』'){ 
				if ($baoshis<2)
				{
					$log .= '你需要至少2顆祝福寶石才能強化裝備到[+4]哦!DA☆ZE<br>';
					$mode = 'command';
					return;
				}
				elseif ($baoshis==2) 	//两颗成功率1/3
				{
					$baoshis--;
					$dice = rand(1,30);
				}
				else 			//3颗必定成功
				{
					$baoshis -= 2;
					$dice = 1;
				}
			}elseif ($zitmlv >= 4){
				$dice = rand(1,10*($zitmlv-2));//+5概率10/20，+6概率10/30，+7概率10/40，+8概率10/50与原来相同
//				$gailv = rand(1,$zitmlv-2);//原代码因为错误的缘故只能执行这里，概率是1/(当前lv-2)，也即冲+5就是1/2,冲+6就是1/3以此类推
//			}elseif ($zitmlv >= 6){
//				$gailv = rand(1,$zitmlv-1);
//			}elseif ($zitmlv >= 10){
//				$gailv = rand(1,$zitmlv);
			}else{
				$dice = 1;
			}
			if ($dice <= 10 ){
				$flag = true;
			}else{$flag = false;}
	  }	
  }	
  addnews ( $now, 'newwep2',$name, $baoshi, $o_itm , $nick);
	if ($flag){
		# Detect item names that's too long - if so, trigger this easter egg and fix the item name to prevent exploit.
		if(mb_strlen($o_itm,'utf-8')>=30){
			$log .= "<span class=\"yellow\">突然，有另一把聲音插了進來！</span><br>";
			$log .= "<span class=\"glitch1\">“我是大魔王昆頓，你們這些中二入腦的英雄們都喜歡將自己的裝備名字取得很長，我很生氣！<br>就讓我毀滅你的中二吧！”</span><br>";

		#搞事！
		$itm = "★破滅的中二之魂★";
		$log .= "<span class=\"yellow\">『你的全身被恐怖感纏繞，只能眼睜睜地看着大魔王將你的中二之魂打成了碎片！<br>但驚異的是，它的性能竟然毫無變化。』</span><br>";
		$log .= "<span class=\"glitch1\">“畢竟老夫也不是什麼惡魔嘛——那麼我的氣消了，凱莉你繼續吧。”</span><br>";
		}

	 $log .= "<span class=\"yellow\">『一道神聖的閃光照耀在你的眼睛上，當你恢復視力時，發現你的裝備閃耀着彩虹般的光芒』</span><br>";
	 $nzitmlv = $zitmlv +1;
	 $itm = str_replace('[+'.$zitmlv.']','[+'.$nzitmlv.']',$itm);
	 $itme = round($itme * (1.5 + 0.1 * $zitmlv));
	}else{
	 //$ran = rand(5,20);
	 //$log .="<span class=\"yellow\">『一道神圣的闪光照耀在你的眼睛上，当你恢复视力时，发现你的装备变成了{$ran}块闪耀着彩虹光芒的碎片』</span><br>";
	 //$itm = "★散发着彩虹光芒的的碎片★";
	 $itm = "悲嘆之種";
	 //$itme = round(${'itme'.$itmn} / $ran);
	 $itme = 1;
	 //$itms = $ran;
	 $itms = 1;
	 $itmk = 'X';
	 $itmsk = '';
	 $log .="<span class=\"yellow\">『一道神聖的閃光照耀在你的眼睛上，當你恢復視力時，發現你的裝備變成了{$itm}』</span><br>";
	}			
	$baoshis--;
	if($baoshis <= 0){
		$log .= "<span class=\"red\">$baoshi</span> 用光了。<br>";
		$baoshi = $baoshik = $baoshisk = $baoshipara = '';$baoshie = $baoshis = 0;
	}	
	$mode = 'command';
	return;
}	

function nametag($item){
	global $rename,$ntitm,$log,$now,$command,$mode,$nosta;
	global ${'itm'.$ntitm},${'itms'.$ntitm},${'itmk'.$ntitm},${'itme'.$ntitm},${'itmsk'.$ntitm}, ${'itmpara'.$ntitm};
	if(${'itm'.$ntitm} != '殘響兵器' || ${'itmk'.$ntitm} != 'Y' || !${'itms'.$ntitm}){
		$log .= "<span class=\"yellow\">道具不存在！</span><br>";
		$mode = 'command';
		return;
	}
	if($item == 'itm'.$ntitm){
		$log .= "<span class=\"yellow\">不能修改道具自身！</span><br>";
		$mode = 'command';
		return;
	}
	if(strpos($item,'itm')===0){
		$i = str_replace('itm','',$item);
		global ${'itm'.$i},${'itms'.$i},${'itmk'.$i},${'itme'.$i},${'itmsk'.$i}, ${'itmpara'.$i};
		$rn = & ${'itm'.$i};
		$rnk = & ${'itmk'.$i};
		$rne = & ${'itme'.$i};
		$rns = & ${'itms'.$i};
		$rnsk = & ${'itmsk'.$i};
		$rnpara = & ${'itmpara'.$i};
	}else{
		global ${$item},${$item.'k'}, ${$item.'e'}, ${$item.'s'},${$item.'sk'}, ${$item.'para'};
		$rn = & ${$item};
		$rnk = & ${$item.'k'};
		$rne = & ${$item.'e'};
		$rns = & ${$item.'s'};
		$rnsk = & ${$item.'sk'};
		$rnpara = & ${$item.'para'};
	}
	
	
	if(!$rns || !$rne){
		$log .= "<span class=\"yellow\">道具選擇錯誤！</span><br>";
		$mode = 'command';
		return;
	}
	if(strpos($rnk,'Y')===0 || strpos($rnk,'Z')===0){
		$log .= "<span class=\"yellow\">不能修改特殊道具的名字！</span><br>";
		$mode = 'command';
		return;
	}
	if(!$rename){
		$log .= "<span class=\"yellow\">請輸入符合要求的名字！</span><br>";
		$mode = 'command';
		return;
	}
	$mark = '■';
	$rn0 = $rn;
	$rn = $mark.$rename.$mark;
	//Let's add another invisible branding
	$rnsk .= '🔰';
	$rnsk = str_replace('Z','x',$rnsk);
	$log .= "{$rn0}已改名為<span class=\"yellow\">$rn</span>！武器的菁英屬性已經抹消。<br>";

	if(${'itms'.$ntitm} != $nosta){
		${'itms'.$ntitm} --;
		if(${'itms'.$ntitm} <= 0){
			$log .= "<span class=\"yellow\">{${'itm'.$ntitm}}用完了。</span><br>";
			${'itm'.$ntitm} = ${'itmk'.$ntitm} = ${'itmsk'.$ntitm} = ${'itmpara'.$ntitm} = '';
			${'itms'.$ntitm} = ${'itme'.$ntitm} = 0;		
		}
	}
	$mode = 'command';
	return;
}
function supernametag($item){
	global $rename,$ntitm,$log,$now,$command,$mode,$nosta;
	global ${'itm'.$ntitm},${'itms'.$ntitm},${'itmk'.$ntitm},${'itme'.$ntitm},${'itmsk'.$ntitm};
	if(${'itm'.$ntitm} != '超臆想時空' || ${'itmk'.$ntitm} != 'Y' || !${'itms'.$ntitm}){
		$log .= "<span class=\"yellow\">道具不存在！</span><br>";
		$mode = 'command';
		return;
	}
	if($item == 'itm'.$ntitm){
		$log .= "<span class=\"yellow\">不能修改道具自身！</span><br>";
		$mode = 'command';
		return;
	}
	if(strpos($item,'itm')===0){
		$i = str_replace('itm','',$item);
		global ${'itm'.$i},${'itms'.$i},${'itmk'.$i},${'itme'.$i},${'itmsk'.$i};
		$rn = & ${'itm'.$i};
		$rnk = & ${'itmk'.$i};
		$rne = & ${'itme'.$i};
		$rns = & ${'itms'.$i};
		$rnsk = & ${'itmsk'.$i};
	}else{
		global ${$item},${$item.'k'}, ${$item.'e'}, ${$item.'s'},${$item.'sk'};
		$rn = & ${$item};
		$rnk = & ${$item.'k'};
		$rne = & ${$item.'e'};
		$rns = & ${$item.'s'};
		$rnsk = & ${$item.'sk'};
	}
	
	
	if(!$rns || !$rne){
		$log .= "<span class=\"yellow\">道具選擇錯誤！</span><br>";
		$mode = 'command';
		return;
	}
	if(strpos($rnk,'Y')===0 || strpos($rnk,'Z')===0){
		$log .= "<span class=\"yellow\">不能修改特殊道具的名字！</span><br>";
		$mode = 'command';
		return;
	}
	if(!$rename){
		$log .= "<span class=\"yellow\">請輸入符合要求的名字！</span><br>";
		$mode = 'command';
		return;
	}
	if($rename =='『A.Q.U.A』'){
		$log .= "<span class=\"yellow\">呵呵，你知道的太多了。</span><br>";
		$log .= '你頭暈腦脹地躺到了地上，<br>感覺整個人都被救濟了。<br>';
		include_once GAME_ROOT . './include/state.func.php';
		$log .= '然後你失去了意識。<br>';
			for ($i=1;$i<=6;$i++){
				global ${'itm'.$i},${'itmk'.$i},${'itme'.$i},${'itms'.$i},${'itmsk'.$i};
				$itm = & ${'itm'.$i};
				$itmk = & ${'itmk'.$i};
				$itme = & ${'itme'.$i};
				$itms = & ${'itms'.$i};
				$itmsk = & ${'itmsk'.$i};
				if ($itm=='黑色髮卡') {$flag=true;}
				$itm = '';
				$itmk = '';
				$itme = 0;
				$itms = 0;
				$itmsk = '';
			}
		death ( 'salv', '', 0, $itm );
		//return;	
	}
	if($rename =='『T.E.R.R.A』'){
		$log .= "<span class=\"yellow\">呵呵，你知道的太多了。</span><br>";
		$log .= '你頭暈腦脹地躺到了地上，<br>感覺整個人都被救濟了。<br>';
		include_once GAME_ROOT . './include/state.func.php';
		$log .= '然後你失去了意識。<br>';
			for ($i=1;$i<=6;$i++){
				global ${'itm'.$i},${'itmk'.$i},${'itme'.$i},${'itms'.$i},${'itmsk'.$i};
				$itm = & ${'itm'.$i};
				$itmk = & ${'itmk'.$i};
				$itme = & ${'itme'.$i};
				$itms = & ${'itms'.$i};
				$itmsk = & ${'itmsk'.$i};
				if ($itm=='黑色髮卡') {$flag=true;}
				$itm = '';
				$itmk = '';
				$itme = 0;
				$itms = 0;
				$itmsk = '';
			}
		death ( 'salv', '', 0, $itm );
		//return;	
	}
	if($rename =='『V.E.N.T.U.S』'){
		$log .= "<span class=\"yellow\">呵呵，你知道的太多了。</span><br>";
		$log .= '你頭暈腦脹地躺到了地上，<br>感覺整個人都被救濟了。<br>';
		include_once GAME_ROOT . './include/state.func.php';
		$log .= '然後你失去了意識。<br>';
			for ($i=1;$i<=6;$i++){
				global ${'itm'.$i},${'itmk'.$i},${'itme'.$i},${'itms'.$i},${'itmsk'.$i};
				$itm = & ${'itm'.$i};
				$itmk = & ${'itmk'.$i};
				$itme = & ${'itme'.$i};
				$itms = & ${'itms'.$i};
				$itmsk = & ${'itmsk'.$i};
				if ($itm=='黑色髮卡') {$flag=true;}
				$itm = '';
				$itmk = '';
				$itme = 0;
				$itms = 0;
				$itmsk = '';
			}
		death ( 'salv', '', 0, $itm );
		//return;	
	}
	if($rename =='『C.H.A.O.S』'){
		$log .= "<span class=\"yellow\">呵呵，你知道的太多了。</span><br>";
		$log .= '你頭暈腦脹地躺到了地上，<br>感覺整個人都被救濟了。<br>';
		include_once GAME_ROOT . './include/state.func.php';
		$log .= '然後你失去了意識。<br>';
			for ($i=1;$i<=6;$i++){
				global ${'itm'.$i},${'itmk'.$i},${'itme'.$i},${'itms'.$i},${'itmsk'.$i};
				$itm = & ${'itm'.$i};
				$itmk = & ${'itmk'.$i};
				$itme = & ${'itme'.$i};
				$itms = & ${'itms'.$i};
				$itmsk = & ${'itmsk'.$i};
				if ($itm=='黑色髮卡') {$flag=true;}
				$itm = '';
				$itmk = '';
				$itme = 0;
				$itms = 0;
				$itmsk = '';
			}
		death ( 'salv', '', 0, $itm );
		//return;	
	}
		if($rename =='琉璃血'){
		$log .= "<span class=\"yellow\">呵呵，你知道的太多了。</span><br>";
		$log .= '你頭暈腦脹地躺到了地上，<br>感覺整個人都被救濟了。<br>';
		include_once GAME_ROOT . './include/state.func.php';
		$log .= '然後你失去了意識。<br>';
			for ($i=1;$i<=6;$i++){
				global ${'itm'.$i},${'itmk'.$i},${'itme'.$i},${'itms'.$i},${'itmsk'.$i};
				$itm = & ${'itm'.$i};
				$itmk = & ${'itmk'.$i};
				$itme = & ${'itme'.$i};
				$itms = & ${'itms'.$i};
				$itmsk = & ${'itmsk'.$i};
				if ($itm=='黑色髮卡') {$flag=true;}
				$itm = '';
				$itmk = '';
				$itme = 0;
				$itms = 0;
				$itmsk = '';
			}
		death ( 'salv', '', 0, $itm );
		//return;	
	}
		if($rename =='社員專用的ID卡'){
		$log .= "<span class=\"yellow\">呵呵，你知道的太少了。</span><br>";
		$log .= '你頭暈腦脹地躺到了地上，<br>感覺整個人都被救濟了。<br>';
		include_once GAME_ROOT . './include/state.func.php';
		$log .= '然後你失去了意識。<br>';
			for ($i=1;$i<=6;$i++){
				global ${'itm'.$i},${'itmk'.$i},${'itme'.$i},${'itms'.$i},${'itmsk'.$i};
				$itm = & ${'itm'.$i};
				$itmk = & ${'itmk'.$i};
				$itme = & ${'itme'.$i};
				$itms = & ${'itms'.$i};
				$itmsk = & ${'itmsk'.$i};
				if ($itm=='黑色髮卡') {$flag=true;}
				$itm = '';
				$itmk = '';
				$itme = 0;
				$itms = 0;
				$itmsk = '';
			}
		death ( 'salv', '', 0, $itm );
		//return;	
	}
	$mark = '';
	$rn0 = $rn;
	$rn = $mark.$rename.$mark;
//	$rnsk = str_replace('Z','x',$rnsk);
	$log .= "{$rn0}已改名為<span class=\"yellow\">$rn</span>！<br>";
	if(${'itms'.$ntitm} != $nosta){
		${'itms'.$ntitm} --;
		if(${'itms'.$ntitm} <= 0){
			$log .= "<span class=\"yellow\">{${'itm'.$ntitm}}用完了。</span><br>";
			${'itm'.$ntitm} = ${'itmk'.$ntitm} = ${'itmsk'.$ntitm} = '';
			${'itms'.$ntitm} = ${'itme'.$ntitm} = 0;		
		}
	}
	$mode = 'command';
	return;
}

# 提示纸条相关功能
function item_slip($snm,&$data)
{
	$item_slip_hint = Array
	(
		'A' => '“執行官其實都是幻影，那個紅暮的身上應該有召喚幻影的玩意。”<br>“用那個東西然後打倒幻影的話能用遊戲解除鑰匙出去吧。”<br>',
		'B' => '“我設下的靈裝被殘忍地清除了啊……”<br>“不過資料沒全部清除掉。<br>用那個碎片加上傳奇的畫筆和天然屬性……”<br>“應該能重新組合出那個靈裝。”<br>',
		'C' => '“小心！那個叫紅暮的傢伙很強！”<br>“不過她太依賴自己的槍了，有什麼東西能阻擋那傷害的話……”<br>',
		'D' => '“我不知道另外那個孩子的底細。如果我是你的話，不會隨便亂惹她。”<br>“但是她貌似手上拿着符文冊之類的東西。”<br>“也許可以利用射程優勢？！”<br>“你知道的，法師的射程都不咋樣……”',
		'E' => '“生存並不能靠他人來餵給你知識，”<br>“有一套和元素有關的符卡的公式是沒有出現在幫助裏面的，用邏輯推理好好推理出正確的公式吧。”<br>“金木水火土在這裏都能找到哦～”<br>',
		'F' => '“餵你真的是全部買下來了麼……”<br>“這樣的提示紙條不止這六種，其他的紙條估計被那兩位撒出去了吧。”<br>“總之祝你好運。”<br>',
		'G' => '“上天保佑，”<br>“請不要在讓我在模擬戰中被擊墜了！”<br>“空羽 上。”<br>',
		'H' => '“在研究施設裏面出了大事的SCP竟然又輸出了新的樣本！”<br>“按照董事長的意見就把這些傢伙當作人體試驗吧！”<br>署名看不清楚……<br>',
		'I' => '“嗯……”<br>“製作神卡所用的各種認證都可以在商店裏面買到。”<br>“其實卡片真的有那麼強大的力量麼？”<br>',
		'J' => '“知道麼？”<br>“果醬麪包果然還是甜的好，哪怕是甜的生薑也能配製出如地雷般爆炸似的美味。”<br>“祝你好運。”<br>',
		'K' => '“水符？”<br>“你當然需要水，然後水看起來是什麼顏色的？”<br>“找一個顏色類似的東西合成就有了吧。”<br>',
		'L' => '“木符？”<br>“你當然需要樹葉，然後説到樹葉那是什麼顏色？”<br>“找一個顏色類似的東西合成就有了吧。”<br>',
		'M' => '“火符？”<br>“你當然需要找把火，然後説到火那是什麼顏色？”<br>“找一個顏色類似的東西合成就有了吧。”<br>',
		'N' => '“土符？”<br>“説到土那就是石頭吧，然後説到石頭那是什麼顏色？”<br>“找一個顏色類似的東西合成就有了吧。”<br>',
		'P' => '“金符？這個的確很繞人……”<br>“説到金那就是鍊金，然後這是21世紀了，煉製一個金色方塊需要什麼？”<br>“總之祝你好運。”<br>',
		'Q' => '“據説在另外的空間裏面；”<br>“一個吸血鬼因為無聊就在她所居住的地方灑滿了大霧，”<br>“真任性。”<br>',
		'R' => '“知道麼，”<br>“東方幻想鄉這作遊戲裏面EXTRA的最終攻擊”<br>“被老外們稱作『幻月的Rape Time』，當然對象是你。”<br>',
		'S' => '“土水符？”<br>“哈哈哈那肯定是需要土和水啦，可能還要額外的素材吧。”<br>“總之祝你好運。”<br>',
		'T' => '“我一直對虛擬現實中的某些跡象很在意……”<br>“這種未名的威壓感是怎麼回事？”<br>“總之祝你好運。”<br>',
		'U' => '“紙條啥的……”<br>“希望這張紙條不會成為你的遺書。”<br>“總之祝你好運。”<br>',
	);
}

//使用箭矢的功能拆在这里
function itemuse_ugb(&$pdata, $itmn){
	global $log, $mode, $nosta;
	
	$wep=&$pdata['wep']; $wepk=&$pdata['wepk']; 
	$wepe=&$pdata['wepe']; $weps=&$pdata['weps']; $wepsk=&$pdata['wepsk']; 
	
	$itm=&$pdata['itm'.$itmn]; $itmk=&$pdata['itmk'.$itmn];
	$itme=&$pdata['itme'.$itmn]; $itms=&$pdata['itms'.$itmn]; $itmsk=&$pdata['itmsk'.$itmn];
	
	//清除箭矢名
	$swapn = wep_b_clean_arrow_name($wepk);
	//清除武器上的箭属性
	$swapsk = wep_b_clean_arrow_sk($wepsk);
	//判定卸下来的箭矢数目，然后把武器改成无穷耐
	$swapnum = 0;
	if ($weps !== $nosta) {
		$swapnum = $weps;
		$weps = $nosta;
	}
	
	$wepsk_arr = get_itmsk_array($wepsk);
	$itmsk_arr = get_itmsk_array($itmsk);
	//如果是箭矢或者弓有连射属性，那么箭矢上限就是连射次数上限
	//判定连射次数按理也应该拆一个函数出来
	$arrowmax = (in_array('r',$itmsk_arr) || in_array('r',$wepsk_arr)) ? 2 + min ( floor(${$skillinfo['B']} / 200), 4 ) : 1;
	$arrownum = min($arrowmax, $itms);
	//再修改一次武器的耐久值。其实如果弄一个卸箭的功能，卸箭和上箭应该要拆成两个函数
	$weps = $arrownum;
	$itms -= $arrownum;
	
	//记录箭矢名
	$wepk .= '|'.$itm;
	//为武器增加箭属性
	if(!empty($itmsk_arr)){
		$wepsk .= '|'.implode('', $itmsk_arr).'|';
	}
	
	if(!$swapnum)	$log .= "為<span class=\"red b\">$wep</span>選用了<span class=\"red b\">$itm</span>，<span class=\"red b\">$wep</span>發射次數增加了<span class=\"yellow b\">$arrownum</span>。<br>";
	else $log .= "為<span class=\"red b\">$wep</span>換上了<span class=\"red b\">$itm</span>，<span class=\"red b\">$wep</span>發射次數增加了<span class=\"yellow b\">$arrownum</span>。<br>";
	if ($itms <= 0) {
		$log .= "<span class=\"red b\">$itm</span>用光了。<br>";
		$itm = $itmk = $itmsk = '';
		$itme = $itms = 0;
	}
	if($swapnum){
		$pdata['itm0'] = $swapn ? $swapn : '卸下的箭';$pdata['itmk0'] = 'GA';$pdata['itme0'] = 1;$pdata['itms0'] = $swapnum; $pdata['itmsk0'] = $swapsk;
		itemget();
	}
}
?>