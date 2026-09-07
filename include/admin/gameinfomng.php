<?php
if(!defined('IN_ADMIN')) {
	exit('Access Denied');
}
//if($mygroup < 5){
//	exit($_ERROR['no_power']);
//}

if($command == 'wthedit'){
	$iweather = (int)$_POST['iweather'];
	if($iweather == $weather){
		$cmd_info = '當前天氣已經為'.$wthinfo[$iweather].'，無需修改天氣！';
	}elseif(!isset($wthinfo[$iweather])){
		$cmd_info = '天氣數據錯誤，請重新輸入！';
	}else{
		$cmd_info = '當前天氣修改為：'.$wthinfo[$iweather];
		$weather = $iweather;
		save_gameinfo();
		adminlog('wthedit',$iweather);
		addnews($now,'syswthchg',$iweather);		
	}
}elseif($command == 'hackedit'){
	$ihack = $_POST['ihack'] != 0 ? 1 : 0;
	if($ihack == $hack){
		$cmd_info = '當前禁區已經為該狀態，無需修改！';
	}else{
		$cmd_info = '當前禁區狀態修改為：'.($ihack ? '解除' : '未解除');
		$hack = $ihack;
		save_gameinfo();
		adminlog('hackedit',$ihack);
		addnews($now,'syshackchg',$ihack);		
		//include_once GAME_ROOT.'./include/system.func.php';
		//movehtm();
	}
}elseif(strpos($command, 'gsedit')===0){
	$igamestate = explode('_',$command);
	$igamestate = $igamestate[1];
	
	if(!isset($gstate[$igamestate])){
		$cmd_info = '遊戲狀態數據錯誤，請重新輸入！';
	}elseif($gamestate == $igamestate){
		$cmd_info = '遊戲當前已經處於此狀態，請重新輸入！';
//	}elseif($gamestate == 0 && $igamestate != 10){
//		$cmd_info = '遊戲未準備，不可進入後期狀態！';
	}elseif($gamestate == 10 && $igamestate > 20){
		$cmd_info = '遊戲未開始，不可進入後期狀態！';
	}elseif($igamestate && $igamestate < $gamestate){
		$cmd_info = '遊戲已開始，狀態不可回溯！';
	}elseif($igamestate > 20){
		$cmd_info = '當前遊戲狀態修改為：'.$gstate[$igamestate];
		$gamestate = $igamestate;
		save_gameinfo();
		adminlog('gsedit',$igamestate);
		addnews($now,'sysgschg',$igamestate);	
	}elseif($igamestate == 20){
		$cmd_info = '遊戲立即開始！請訪問任意遊戲頁面以刷新遊戲狀態。';
		$starttime = $now;
		save_gameinfo();
		adminlog('gsedit',$igamestate);
		addnews($now,'sysgschg',$igamestate);	
	}elseif($igamestate == 10){
		$cmd_info = '遊戲立即進入準備狀態！請訪問任意遊戲頁面以刷新遊戲狀態。';
		$starttime = $now + $startmin * 60;
		save_gameinfo();
		adminlog('gsedit',$igamestate);
	}else{
		$cmd_info = "第 $gamenum 局大逃殺緊急中止";
		//include_once GAME_ROOT.'./include/system.func.php';
		gameover($now,'end6');
		save_gameinfo();
		adminlog('gameover');
	}
}elseif($command == 'sttimeedit'){
	if($gamestate){
		$cmd_info = "本局遊戲尚未結束，不能設置時間。";
	}else{
		$settime = mktime((int)$_POST['sethour'],(int)$_POST['setmin'],0,(int)$_POST['setmonth'],(int)$_POST['setday'],(int)$_POST['setyear']);
		if($settime <= $now){
			$cmd_info = '開始時間不能早於當前時間。';
		}else{
			$starttime = $settime;
			save_gameinfo();
			$cmd_info = '遊戲開始時間設置成功。';
		}
	}
}elseif($command == 'areaadd'){
	if($gamestate <= 10){
		$cmd_info = "本局遊戲尚未開始，不能增加禁區。";
	}elseif((!$areanum && $starttime + 30 > $now) || ($areanum && $areatime - $areahour*60 + 30 > $now)){
		$cmd_info = "禁區到來後30秒內不能增加禁區。";
	}else{
		$areatime = $now;
		save_gameinfo();
		$areatime += $areahour * 60;
		$cmd_info = '下一次禁區時間提前到來。請訪問任意遊戲頁面以刷新遊戲狀態。';
		addnews($now,'sysaddarea');	
	}
}

if($starttime){
	list($stsec,$stmin,$sthour,$stday,$stmonth,$styear,$stwday,$styday,$stisdst) = localtime($starttime);
	$stmonth++;
	$styear += 1900;
}else{
	list($stsec,$stmin,$sthour,$stday,$stmonth,$styear,$stwday,$styday,$stisdst) = localtime($now+3600);
	$stmin = $startmin;
	$stmonth++;
	$styear += 1900;
}

$arealiststr = $nextarealiststr = '';
$col = 0;
$areaarr = array_slice($arealist,0,$areanum+1);
foreach($areaarr as $val){
	if($col == 4){
		$arealiststr .= $plsinfo[$val].'<br>';
		$col = 0;
	}else{
		$arealiststr .= $plsinfo[$val].' ';
		$col ++;
	}	
}
$col = 0;
$nareaarr = array_slice($arealist,0,$areanum+$areaadd);
foreach($nareaarr as $val){
	if($col == 4){
		$nextarealiststr .= $plsinfo[$val].'<br>';
		$col = 0;
	}else{
		$nextarealiststr .= $plsinfo[$val].' ';
		$col ++;
	}	
}
list($arsec,$armin,$arhour,$arday,$armonth,$aryear,$arwday,$aryday,$arisdst) = localtime($areatime);
$armonth++;
$aryear += 1900;
include template('admin_gameinfomng');
?>

