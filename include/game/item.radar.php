<?php

if (! defined ( 'IN_GAME' )) {
	exit ( 'Access Denied' );
}

// Handle old radar items
function item_radar_old($itmn, &$data) {
	global $log;
	extract($data, EXTR_REFS);
	
	$itm = & ${'itm' . $itmn};
	$itmk = & ${'itmk' . $itmn};
	$itme = & ${'itme' . $itmn};
	$itms = & ${'itms' . $itmn};
	$itmsk = & ${'itmsk' . $itmn};
	
	//$log.= $itm .'已经废弃，请联系管理员。';
	if ($itme > 0) {
		$log .= "使用了<span class=\"red\">$itm</span>。<br>";
		include_once GAME_ROOT . './include/game/item2.func.php';
		newradar($itmsk);
		$itme --;
		if ($itme <= 0) {
			$log .= $itm . '的電力用光了，請使用電池充電。<br>';
		}
	} else {
		$itme = 0;
		$log .= $itm . '沒有電了，請先充電。<br>';
	}
}

// Handle new radar items
function item_radar_new($itmn, &$data) {
	global $log;
	extract($data, EXTR_REFS);
	
	$itm = & ${'itm' . $itmn};
	$itmk = & ${'itmk' . $itmn};
	$itme = & ${'itme' . $itmn};
	$itms = & ${'itms' . $itmn};
	$itmsk = & ${'itmsk' . $itmn};
	
	if ($itme > 0) {
		$log .= "使用了<span class=\"red\">$itm</span>。<br>";
		include_once GAME_ROOT . './include/game/item2.func.php';
		newradar($itmsk);
		//global $club;
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
		if ($itme <= 0) {
			$log .= $itm . '的電力用光了，請使用電池充電。<br>';
		}
	} else {
		$itme = 0;
		$log .= $itm . '沒有電了，請先充電。<br>';
	}
}

// Handle battery items
function item_battery($itmn, &$data) {
	global $log, $elec_cap;
	extract($data, EXTR_REFS);
	
	$itm = & ${'itm' . $itmn};
	$itmk = & ${'itmk' . $itmn};
	$itme = & ${'itme' . $itmn};
	$itms = & ${'itms' . $itmn};
	$itmsk = & ${'itmsk' . $itmn};
	
	$flag = false;
	$bat_kind = substr($itmk,1,1);
	for($i = 1; $i <= 6; $i ++) {
		//global ${'itm' . $i}, ${'itmk' . $i}, ${'itme' . $i}, ${'itms' . $i};
		if (${'itmk' . $i} == 'E'.$bat_kind && ${'itms' . $i}) {
			if(${'itme' . $i} >= $elec_cap){
				$log .= "包裹{$i}裏的<span class=\"yellow\">{${'itm'.$i}}</span>已經充滿電了。<br>";
			}else{
				${'itme' . $i} += $itme;
				if(${'itme' . $i} > $elec_cap){${'itme' . $i} = $elec_cap;}
				$itms --;
				$flag = true;
				$log .= "為包裹{$i}裏的<span class=\"yellow\">{${'itm'.$i}}</span>充了電。";
				break;
			}				
		}
	}
	if (! $flag) {
		$log .= '你沒有需要充電的物品。<br>';
	}
	if ($itms <= 0 && $itm) {
		$log .= "<span class=\"red\">$itm</span>用光了。<br>";
		$itm = $itmk = $itmsk = '';
		$itme = $itms = 0;
	}
}
