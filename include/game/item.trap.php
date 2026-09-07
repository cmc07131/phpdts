<?php

if (! defined ( 'IN_GAME' )) {
	exit ( 'Access Denied' );
}

// Handle trap items
function item_trap($itmn, &$data) {
	global $log, $mode, $nosta, $db, $tablepre, $upexp;
	extract($data, EXTR_REFS);
	
	$itm = & ${'itm' . $itmn};
	$itmk = & ${'itmk' . $itmn};
	$itme = & ${'itme' . $itmn};
	$itms = & ${'itms' . $itmn};
	$itmsk = & ${'itmsk' . $itmn};

	if(!check_skill_unlock('c13_master', $data))
	{
		$log .= "你老臉一紅，只覺得自己是被鬼迷了心竅，怎麼會起了這種卑劣的念頭！<br>羞憤之下，你一口把<span class='yellow'>{$itm}</span>吞進了肚子。<br>";
		$itms = 0;
		destory_single_item($data, $itmn, 1);
		$mode = 'command';
		return;
	}

	$trapk = str_replace('TN', 'TO', $itmk);

	if($clbpara['BGMBrand'] == 'rixolamal'){
		$trapk = str_replace('TO', 'TOr', $itmk);
		$log .= "你對隨機數大神的反叛讓隨機數大神將<span class=\"red\">$itm</span>變成了一個隨機造成傷害的地雷！<br>";
	}

	$db->query("INSERT INTO {$tablepre}maptrap (itm, itmk, itme, itms, itmsk, pls) VALUES ('$itm', '$trapk', '$itme', '1', '$pid', '$pls')");
	$log .= "設置了陷阱<span class=\"red\">$itm</span>。<br>小心，自己也很難發現。<br>";
	
	if($club == 5){$exp += 2;$wd+=2;}
	else{$exp++;$wd++;}
	
	if ($exp >= $upexp) {
		include_once GAME_ROOT . './include/state.func.php';
		lvlup_rev($data, $data, 1);
	}
	if ($itms != $nosta) {
		$itms --;
		if ($itms <= 0) {
			$log .= "<span class=\"red\">$itm</span>用光了。<br>";
			$itm = $itmk = $itmsk = '';
			$itme = $itms = 0;
		}
	}
}

// Handle trap detector items
function item_trap_detector($itmn, &$data) {
	global $log, $nosta, $db, $tablepre;
	extract($data, EXTR_REFS);
	
	$itm = & ${'itm' . $itmn};
	$itmk = & ${'itmk' . $itmn};
	$itme = & ${'itme' . $itmn};
	$itms = & ${'itms' . $itmn};
	$itmsk = & ${'itmsk' . $itmn};
	
	$trapresult = $db->query("SELECT * FROM {$tablepre}maptrap WHERE pls = '$pls' AND itme>='$itme'");
	$trpnum = $db->num_rows($trapresult);
	if ($itms != $nosta) {
		$itms--;
		if ($itms <= 0) {
			$log .= "<span class=\"red\">$itm</span>用光了。<br>";
			$itm = $itmk = $itmsk = '';
			$itme = $itms = 0;
		}
	}
	if ($trpnum>0){
		$itemno = rand(0,$trpnum-1);
		$db->data_seek($trapresult,$itemno);
		$mi=$db->fetch_array($trapresult);
		$deld = $mi['itm'];
		$delp = $mi['tid'];
		$db->query("DELETE FROM {$tablepre}maptrap WHERE tid='$delp'");
		$log.="遠方傳來一陣爆炸聲，偉大的<span class=\"yellow\">{$itm}</span>用生命和鮮血掃除了<span class=\"yellow\">{$deld}</span>。<br><span class=\"red\">實在是大快人心啊！</span><br>";
	}else{
		$log.="你使用了<span class=\"yellow\">{$itm}</span>，但是沒有發現陷阱。<br>";
	}
}
