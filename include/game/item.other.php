<?php

if (! defined ( 'IN_GAME' )) {
	exit ( 'Access Denied' );
}

// Handle fireworks items
function item_fireworks($itmn, &$data) {
	global $log, $nosta;
	extract($data, EXTR_REFS);
	
	$itm = & ${'itm' . $itmn};
	$itmk = & ${'itmk' . $itmn};
	$itme = & ${'itme' . $itmn};
	$itms = & ${'itms' . $itmn};
	$itmsk = & ${'itmsk' . $itmn};
	
	// 这里需要从原item.func.php文件中移植烟花相关的逻辑
	// 从第1530行之后的代码
		//В ΜΑЛΨ, В ЩΑЁΨ, В ЦΨΨ ОΑЙЙ, В ТИХ ЩДТЖИΜД.
		//ХЖ ДЖХЖТ, ЖХΨ ЦЩТΑВΜДЩ ТЖΑΡ, ΜΨЩ. ЩДВХΜЦ. ΡЖХΨ.
	//Thanks Chantal for crunching those numbers - I'll make sure I find you something else to crunch on some other time...
	# This method concerns 4 of them, and one additional check:
	//$hp up, $w[X] up, $mhp up, $def up

		# Then, decide on the Rank of the Fireseed Item, this will decide its maximum value:
		$rank = 0;
		# Those items will always start with either ◆,✦,★,☾, and ☼
		if (strpos ( $itm, '◆' ) === 0){
			$rank = 1;
		}elseif (strpos ( $itm, '✦' ) === 0){
			$rank = 2;
		}elseif (strpos ( $itm, '★' ) === 0){
			$rank = 3;
		}elseif (strpos ( $itm, '☾' ) === 0){
			$rank = 4;
		}elseif (strpos ( $itm, '☼') === 0){
			$rank = 5;
		}else{
			$rank = 0;
		}

		# Special check for a invalid item (Rank = 0), Just turn it into healing.
		if($rank == 0){
			$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚，你感覺煥然一新！<br>";
			$hp = $mhp;
			$sp = $msp;

			if ($itms != $nosta) {
				$itms --;
				if ($itms <= 0) {
					$log .= "<span class=\"red\">$itm</span>的餘燼崩解消失了……<br>";
					$itm = $itmk = $itmsk = '';
					$itme = $itms = 0;
				}
			}
		}

		# Logic for each of the 4 usages.
		elseif($itmk == '🎆H'){
			# This is healing item, it can heal beyond your $mhp based on its rank.
			if ($rank == 1){
				$gainmax = round($mhp * 0.51);
			}elseif ($rank == 2){
				$gainmax = round($mhp * 1.08);
			}elseif ($rank == 3){
				$gainmax = round($mhp * 2.33);
			}elseif ($rank == 4){
				$gainmax = round($mhp * 5.73);
			}else{
				$gainmax = '∞';
			}
			// Tracking how much HP one can overheal based on its rank.
			$clbpara['fireseedMaxHPRecover'] = $gainmax;
			if ($gainmax !== '∞'){
			// Gain HP and SP - note we don't overheal SP here.
			
			$addsp = $msp - $sp < $itme ? $msp - $sp : $itme;
			if($addsp > 0) $sp += $addsp;
			else $addsp = 0;
			// Calculating overheal HP value.
			$addhp = ($mhp + $gainmax) - $hp < $itme ? ($mhp + $gainmax) - $hp : $itme;
			if($addhp > 0) $hp += $addhp;
			else $addhp = 0;

			if ($addhp <= 0){
				$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚。<br>
				但是似乎並沒有回覆生命！<br>
				<br>
				<span class=\"blueseed\">同時，你還隱約聽見了一個聲音：<br>
				「你可能需要找個純度更高的代碼片段喲~」<br></span>";
			}else{

			$gainless = ($mhp + $gainmax) - $hp;

			$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚。<br>
			治癒的代碼片段為你恢復了<span class=\"yellow\">$addhp</span>點生命和<span class=\"yellow\">$addsp</span>點體力。<br>
			<br>
			<br>
			<span class=\"blueseed\">同時，你還隱約聽見了一個聲音：<br>
			「你還能獲得{$gainless}點臨時生命喲~<br>
			但臨時生命就是臨時的，隨時都有可能消失喲~」<br></span>";

			if($gainless < $itme){
				$log.="<br><span class=\"redseed\">這時，有另一把聲音插了進來：<br>
				「看起來這個純度的代碼片段已經喂不飽你了。<br>
				趕快找下一個純度的代碼片段吧！」<br></span>";
			}

			if ($itms != $nosta) {
				$itms --;
				if ($itms <= 0) {
					$log .= "<span class=\"red\">$itm</span>的餘燼崩解消失了……<br>";
					$itm = $itmk = $itmsk = '';
					$itme = $itms = 0;
				}
			}
		}
			}else{
				$addsp = $msp - $sp < $itme ? $msp - $sp : $itme;
				if($addsp > 0) $sp += $addsp;
				else $addsp = 0;
				
				$addhp = $itme;
				$hp += $addhp;

				$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚。<br>
			治癒的代碼片段為你恢復了<span class=\"yellow\">$addhp</span>點生命和<span class=\"yellow\">$addsp</span>點體力。<br>";

			if ($itms != $nosta) {
				$itms --;
				if ($itms <= 0) {
					$log .= "<span class=\"red\">$itm</span>的餘燼崩解消失了……<br>";
					$itm = $itmk = $itmsk = '';
					$itme = $itms = 0;
				}
			}
			}
		}elseif ($itmk == '🎆V'){
			# This is $w[X] up, it simply add to all $w[X] values.
			if ($rank == 1){
				$gainmax = 201;
			}elseif ($rank == 2){
				$gainmax = 502;
			}elseif ($rank == 3){
				$gainmax = 2003;
			}elseif ($rank == 4){
				$gainmax = 8011;
			}else{
				$gainmax = '∞';
			}
			// Tracking how much w value one can gain based on its rank.
			$clbpara['fireseedmaxProfGain'] = $gainmax;
			if ($gainmax !== '∞'){
			// Gain w value
			
			$addw = $itme;
			$clbpara['fireseedmaxProfAdd'] += $addw;
			if($clbpara['fireseedmaxProfGain'] - $clbpara['fireseedmaxProfAdd'] > 0) {
				$wp += $addw;
				$wk += $addw;
				$wg += $addw;
				$wc += $addw;
				$wd += $addw; 
				$wf += $addw;}
			else $addw = 0;

			if ($addw <= 0){
			$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚。<br>
			但是似乎什麼都沒有發生！<br>
			<br>
			<br>
			<span class=\"blueseed\">同時，你還隱約聽見了一個聲音：<br>
			「你可能需要找個純度更高的代碼片段喲~」<br></span>";
			}else{

			$gainless = $clbpara['fireseedmaxProfGain'] - $clbpara['fireseedmaxProfAdd'];

			$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚。<br>
			載有熟練度的代碼片段讓你獲得了<span class=\"yellow\">$addw</span>點全系熟練度！<br>
			<br>
			<br>
			<span class=\"blueseed\">同時，你還隱約聽見了一個聲音：<br>
			「你還能通過這個純度的代碼獲得{$gainless}點熟練度喲~」<br></span>";

			if($gainless < $itme){
				$log.="<br><span class=\"redseed\">這時，有另一把聲音插了進來：<br>
				「看起來這個純度的代碼片段已經喂不飽你了。<br>
				趕快找下一個純度的代碼片段吧！」<br></span>";
			}

			if ($itms != $nosta) {
				$itms --;
				if ($itms <= 0) {
					$log .= "<span class=\"red\">$itm</span>的餘燼崩解消失了……<br>";
					$itm = $itmk = $itmsk = '';
					$itme = $itms = 0;
				}
			}

			}
			}else{
				$addw = $itme;
				$wp += $addw;
				$wk += $addw;
				$wg += $addw;
				$wc += $addw;
				$wd += $addw; 
				$wf += $addw;

				$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚。<br>
				載有熟練度的代碼片段讓你獲得了<span class=\"yellow\">$addw</span>點全系熟練度！<br>";

				if ($itms != $nosta) {
					$itms --;
					if ($itms <= 0) {
						$log .= "<span class=\"red\">$itm</span>的餘燼崩解消失了……<br>";
						$itm = $itmk = $itmsk = '';
						$itme = $itms = 0;
					}
				}
			}
		}elseif ($itmk == '🎆O'){
			# This is $mhp up item, it simply add to that value.
			if ($rank == 1){
				$gainmax = 1001;
			}elseif ($rank == 2){
				$gainmax = 3002;
			}elseif ($rank == 3){
				$gainmax = 5003;
			}elseif ($rank == 4){
				$gainmax = 8008;
			}else{
				$gainmax = '∞';
			}
			// Tracking how much $mhp value one can gain based on its rank.
			$clbpara['fireseedmaxHPGain'] = $gainmax;
			if ($gainmax !== '∞'){
			// Gain $mhp value
			
			$addmhp = $itme;
			$clbpara['fireseedmaxHPAdd'] += $addmhp;
			if($clbpara['fireseedmaxHPGain'] - $clbpara['fireseedmaxHPAdd'] > 0) $mhp += $addmhp;
			else $addmhp = 0;

			if ($addmhp <= 0){
			$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚。<br>
			但是似乎什麼都沒有發生！<br>
			<br>
			<br>
			<span class=\"blueseed\">同時，你還隱約聽見了一個聲音：<br>
			「你可能需要找個純度更高的代碼片段喲~」<br></span>";
			}else{

			$gainless = $clbpara['fireseedmaxHPGain'] - $clbpara['fireseedmaxHPAdd'];

			$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚。<br>
			載有生命的代碼片段讓你獲得了<span class=\"yellow\">$addmhp</span>點生命最大值！<br>
			<br>
			<br>
			<span class=\"blueseed\">同時，你還隱約聽見了一個聲音：<br>
			「你還能通過這個純度的代碼獲得{$gainless}點生命最大值喲~」<br></span>";

			if($gainless < $itme){
				$log.="<br><span class=\"redseed\">這時，有另一把聲音插了進來：<br>
				「看起來這個純度的代碼片段已經喂不飽你了。<br>
				趕快找下一個純度的代碼片段吧！」<br></span>";

			}

			if ($itms != $nosta) {
				$itms --;
				if ($itms <= 0) {
					$log .= "<span class=\"red\">$itm</span>的餘燼崩解消失了……<br>";
					$itm = $itmk = $itmsk = '';
					$itme = $itms = 0;
				}
			}

			}
			}else{
				$addmhp = $itme;
				$mhp += $addmhp;

				$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚。<br>
				載有生命的代碼片段讓你獲得了<span class=\"yellow\">$addmhp</span>點生命最大值！<br>";

				if ($itms != $nosta) {
					$itms --;
					if ($itms <= 0) {
						$log .= "<span class=\"red\">$itm</span>的餘燼崩解消失了……<br>";
						$itm = $itmk = $itmsk = '';
						$itme = $itms = 0;
					}
				}
			}
		}elseif ($itmk == '🎆D'){
			# This is $def up item, it simply add to that value.
			if ($rank == 1){
				$gainmax = 1001;
			}elseif ($rank == 2){
				$gainmax = 3002;
			}elseif ($rank == 3){
				$gainmax = 5003;
			}elseif ($rank == 4){
				$gainmax = 8008;
			}else{
				$gainmax = '∞';
			}
			// Tracking how much $def value one can gain based on its rank.
			$clbpara['fireseedmaxDefGain'] = $gainmax;
			if ($gainmax !== '∞'){
			// Gain $def value
			
			$adddef = $itme;
			$clbpara['fireseedmaxDefAdd'] += $adddef;
			if($clbpara['fireseedmaxDefGain'] - $clbpara['fireseedmaxDefAdd'] > 0) $def += $adddef;
			else $adddef = 0;

			if ($adddef <= 0){
			$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚。<br>
			但是似乎什麼都沒有發生！<br>
			<br>
			<br>
			<span class=\"blueseed\">同時，你還隱約聽見了一個聲音：<br>
			「你可能需要找個純度更高的代碼片段喲~」<br></span>";
			}else{

			$gainless = $clbpara['fireseedmaxDefGain'] - $clbpara['fireseedmaxDefAdd'];

			$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚。<br>
			載有防禦數據的代碼片段讓你獲得了<span class=\"yellow\">$adddef</span>點基礎防禦力！<br>
			<br>
			<br>
			<span class=\"blueseed\">同時，你還隱約聽見了一個聲音：<br>
			「你還能通過這個純度的代碼獲得{$gainless}點基礎防禦力喲~」<br></span>";

			if($gainless < $itme){
				$log.="<br><span class=\"redseed\">這時，有另一把聲音插了進來：<br>
				「看起來這個純度的代碼片段已經喂不飽你了。<br>
				趕快找下一個純度的代碼片段吧！」<br></span>";
			}
			if ($itms != $nosta) {
				$itms --;
				if ($itms <= 0) {
					$log .= "<span class=\"red\">$itm</span>的餘燼崩解消失了……<br>";
					$itm = $itmk = $itmsk = '';
					$itme = $itms = 0;
				}
			}

			}
			}else{
				$adddef = $itme;
				$def += $adddef;

				$log.="你將<span class=\"yellow\">{$itm}</span>吞下了肚。<br>
				載有防禦數據的代碼片段讓你獲得了<span class=\"yellow\">$adddef</span>點基礎防禦力！<br>";

				if ($itms != $nosta) {
					$itms --;
					if ($itms <= 0) {
						$log .= "<span class=\"red\">$itm</span>的餘燼崩解消失了……<br>";
						$itm = $itmk = $itmsk = '';
						$itme = $itms = 0;
					}
				}
			}
		
		}elseif($itmk == '🎆B'){
			# Fireseed Box, containing various helpful items.
			# Officially dubbed Silent Box.
			$log.="你打開了<span class=\"yellow\">$itm</span>。<br>";

			$oitm = $itm; $oitmk = $itmk;
			if ($itms != $nosta) {
				$itms--;
			}

			include_once config('randomFS',$gamecfg);

			$dice = diceroll(1000);
			if($dice <= 420){
				$itemflag = $lesserdata;
			}elseif($dice <= 740){
				$itemflag = $item;
			}elseif($dice <= 927){
				$itemflag = $constructs;
			}elseif($dice <= 998){
				$itemflag = $material;
			}else{
				$itemflag = $sundata;
				$clbpara['achvars']['gacha_ssr'] += 1;
			}
			if($itemflag){
				$itemflag = explode("\r\n",$itemflag);
				$rand = rand(0,count($itemflag)-1);
				list($in,$ik,$ie,$is,$isk) = explode(',',$itemflag[$rand]);
			}

			if($itms <= 0 && $itms != $nosta) destory_single_item($data,$itmn,1);
			$itm0 = $in;$itmk0=$ik;$itme0=$ie;$itms0=$is;$itmsk0=$isk;
			if($itemflag = $sundata) addnews($now,'present',$name,$oitm,$in,$nick);
	
			include_once GAME_ROOT.'./include/game/itemmain.func.php';
			itemget($data);

		}elseif($itmk == '🎆C'){
			# Weird Fireseed Box, containing interesting items.
			# Officially dubbed Weird Box.
			$log.="你打開了<span class=\"yellow\">$itm</span>。<br>";

			$oitm = $itm; $oitmk = $itmk;
			if ($itms != $nosta) {
				$itms--;
			}

			include_once config('randomFSW',$gamecfg);

			$dice = diceroll(1000);
			if($dice <= 660){
				$itemflag = $selfjoke;
			}elseif($dice <= 996){
				$itemflag = $jokeonothers;
			}else{
				$itemflag = $superjoke;
				$clbpara['achvars']['gacha_ssr'] += 1;
			}
			if($itemflag){
				$itemflag = explode("\r\n",$itemflag);
				$rand = rand(0,count($itemflag)-1);
				list($in,$ik,$ie,$is,$isk) = explode(',',$itemflag[$rand]);
			}

			if($itms <= 0 && $itms != $nosta) destory_single_item($data,$itmn,1);
			$itm0 = $in;$itmk0=$ik;$itme0=$ie;$itms0=$is;$itmsk0=$isk;
			if($itemflag = $sundata) addnews($now,'present',$name,$oitm,$in,$nick);
	
			include_once GAME_ROOT.'./include/game/itemmain.func.php';
			itemget($data);

		}else{
			$log.="這段代碼……要如何使用呢？<br>";
		}

		//Process a special check for total Ash item used, for future usage.
		$clbpara['fireseedAshUsage'] += $rank;

		//Process item decrease. - Changed to do it only after succeeding item usage.
/* 		if ($itms != $nosta) {
			$itms --;
			if ($itms <= 0) {
				$log .= "<span class=\"red\">$itm</span>用光了。<br>";
				$itm = $itmk = $itmsk = '';
				$itme = $itms = 0;
			}
		} */
	# Special check for a poisoned fireseed item, WIP for now.	

//	}else($itmk == 'P🎆'){
//		$log.="这个<span class=\"yellow\">{$itm}</span>有毒！到底是谁干的！<br>";
		# For Maximum Funniness, we destroy this item.
//		$log .= "<span class=\"red\">$itm</span>的余烬向天上盘旋飞舞，消失了。<br>";
//		$itm = $itmk = $itmsk = '';
//		$itme = $itms = 0;}
	}

// Handle other items not covered by specific handlers
function item_other($itmn, &$data) {
	global $log;
	extract($data, EXTR_REFS);
	
	$itm = & ${'itm' . $itmn};
	$itmk = & ${'itmk' . $itmn};
	$itme = & ${'itme' . $itmn};
	$itms = & ${'itms' . $itmn};
	$itmsk = & ${'itmsk' . $itmn};
	
	// 处理其他未分类的物品
	$log .= "你使用了<span class=\"yellow\">$itm</span>，但是什麼也沒有發生。<br>";
}
