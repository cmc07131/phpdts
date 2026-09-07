<?php


if(!defined('IN_GAME')) {
	exit('Access Denied');
}



function teamcheck() {
	global $log,$mode,$teamcmd,$sp,$team_sp,$teamj_sp,$teamID;
	if($teamID) {
		$log .= '你已經加入了隊伍<span class="yellow">'.$teamID.'</span>，請先退出隊伍。<br>';
		$mode = 'command';
	} elseif($teamcmd == 'teammake' && $sp <= $team_sp) {
		$log .= '體力不足，不能創建隊伍。至少需要<span class="yellow">'.$team_sp.'</span>點體力。<br>';
		$mode = 'command';
	} elseif($teamcmd == 'teamjoin' && $sp <= $teamj_sp) {
		$log .= '體力不足，不能加入隊伍。至少需要<span class="yellow">'.$teamj_sp.'</span>點體力。<br>';
		$mode = 'command';
	} else {
		$mode = 'team';
	}
	return;	
}

function teammake($tID,$tPass,$tIcon) {
	global $log,$mode,$teamID,$teamPass,$teamIcon,$db,$tablepre,$noitm,$sp,$team_sp,$now,$name,$gamestate,$nick,$clbpara;

	//队伍头像范围
	$max_tIcon = 12;

	if($gamestate >= 40) {
		$log .= '連鬥時不能組建隊伍。<br>';
		$mode = 'command';
		return;
	}

	if(!$tID || !$tPass) {
		$log .= '隊伍名和密碼不能為空，請重新輸入。<br>';
		$mode = 'command';
		return;
	}
	if(strlen($tID) > 20){
		$log .= '隊伍名稱過長，請重新輸入。<br>';
		$mode = 'command';
		return;
	}
	if(strlen($tPass) > 20){
		$log .= '隊伍密碼過長，請重新輸入。<br>';
		$mode = 'command';
		return;
	}
	if($tID == $noitm) {
		$log .= '隊伍名不能為<span class="red">'.$tID.'</span>，請重新輸入。<br>';
		$mode = 'command';
		return;
	}
		
	if($teamID) {
		$log .= '你已經加入了隊伍<span class="yellow">'.$teamID.'</span>，請先退出隊伍。<br>';
	} elseif($sp <= $team_sp) {
		$log .= '體力不足，不能創建隊伍。至少需要<span class="yellow">'.$team_sp.'</span>點體力。<br>';
	} else {
		//创建队伍时，队伍计数+1
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
		if(empty($clbpara['achvars']['team'])) $clbpara['achvars']['team'] = 1;

		$result = $db->query("SELECT pid FROM {$tablepre}players WHERE teamID='$tID'");
		if($db->num_rows($result)){
			$log .= '隊伍<span class="yellow">'.$tID.'</span>已經存在，請更換隊伍名。<br>';
		} else {
			// 创建队伍时输入了不合法头像参数，随机挑一个头像
			if(!in_array($tIcon,range(0,$max_tIcon))) $tIcon = rand(0,$max_tIcon);
			$teamID = $tID;
			$teamPass = $tPass;
			$teamIcon = $tIcon;
			$sp -= $team_sp;
			$log .= '你創建了隊伍<span class="yellow">'.$teamID.'</span>。<br>';
			addnews($now,'teammake',$teamID,$name,$nick);
//			global $gamedata,$chatinfo;
//			$gamedata['innerHTML']['chattype'] = "<select name=\"chattype\" value=\"2\"><option value=\"0\" selected>$chatinfo[0]<option value=\"1\" >$chatinfo[1]</select>";
//			$gamedata['value']['team'] = $teamID;
		}
	$mode = 'command';
	return;

	}
}

function teamjoin($tID,$tPass) {
	global $log,$mode,$teamID,$teamPass,$teamIcon,$db,$tablepre,$noitm,$sp,$team_sp,$teamj_sp,$now,$name,$teamlimit,$gamestate,$clbpara;
	if($gamestate >= 40) {
		$log .= '連鬥時不能加入隊伍。<br>';
		$mode = 'command';
		return;
	}
	if(!$tID || !$tPass){
		$log .= '隊伍名和密碼不能為空，請重新輸入。<br>';
		$mode = 'command';
		return;
	}
	if(strlen($tID) > 20){
		$log .= '隊伍名稱過長，請重新輸入。<br>';
		$mode = 'command';
		return;
	}
	if(strlen($tPass) > 20){
		$log .= '隊伍密碼過長，請重新輸入。<br>';
		$mode = 'command';
		return;
	}
	if($tID == $noitm) {
		$log .= '隊伍名不能為<span class="red">'.$tID.'</span>，請重新輸入。<br>';
		$mode = 'command';
		return;
	}

	if($teamID) {
		$log .= '你已經加入了隊伍<span class="yellow">'.$teamID.'</span>，請先退出隊伍。<br>';
	} elseif($sp <= $teamj_sp) {
		$log .= '體力不足，不能加入隊伍。至少需要<span class="yellow">'.$teamj_sp.'</span>點體力。<br>';
	} else {

		//加入队伍时，队伍计数+1
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
		if(empty($clbpara['achvars']['team'])) $clbpara['achvars']['team'] = 1;

		$result = $db->query("SELECT teamPass,teamIcon FROM {$tablepre}players WHERE teamID='$tID'");
		if(!$db->num_rows($result)){
			$log .= '隊伍<span class="yellow">'.$tID.'</span>不存在，請先創建隊伍。<br>';
		} elseif($db->num_rows($result) >= $teamlimit) {
			$log .= '隊伍<span class="yellow">'.$tID.'</span>人數已滿，請更換隊伍。<br>';
		} else {
			$teaminfo = $db->fetch_array($result);
			if($tPass == $teaminfo['teamPass']) {
				$teamID = $tID;
				$teamPass = $tPass;
				$teamIcon = $teaminfo['teamIcon'];
				$sp -= $teamj_sp;
				$log .= '你加入了隊伍<span class="yellow">'.$teamID.'</span>。<br>';
				addnews($now,'teamjoin',$teamID,$name,$nick);
//				global $gamedata,$chatinfo;
//				$gamedata['innerHTML']['chattype'] = "<select name=\"chattype\" value=\"2\"><option value=\"0\" selected>$chatinfo[0]<option value=\"1\" >$chatinfo[1]</select>";
//				$gamedata['value']['team'] = $teamID;
			} else {
				$log .= '密碼錯誤，不能加入隊伍<span class="yellow">'.$tID.'</span>。<br>';
			}
		}
	}

	$mode = 'command';
	return;
}

function teamquit() {
	global $log,$mode,$teamID,$teamPass,$now,$name,$gamestate,$nick;

	if($teamID && $gamestate<40){
		$log .= '你退出了隊伍<span class="yellow">'.$teamID.'</span>。<br>';
		addnews($now,'teamquit',$teamID,$name,$nick);
		$teamID =$teamPass = '';
//		global $gamedata,$chatinfo;
//		$gamedata['innerHTML']['chattype'] = "<select name=\"chattype\" value=\"2\"><option value=\"0\" selected>$chatinfo[0]</select>";
	} else {
		$log .= '你不在隊伍中。<br>';
	}
	$mode = 'command';
	return;
}

?>