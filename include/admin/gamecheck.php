<?php
if(!defined('IN_ADMIN')) {
	exit('Access Denied');
}

if($gamestate >= 20){
	require_once GAME_ROOT.'./include/system.func.php';
	
	$result = $db->query("SELECT pid FROM {$tablepre}players WHERE type=0");
	$validnum = $db->num_rows($result);
	
	$result = $db->query("SELECT pid FROM {$tablepre}players WHERE hp>0 AND type=0");
	$alivenum = $db->num_rows($result);
	
	$result = $db->query("SELECT pid FROM {$tablepre}players WHERE hp<=0 OR state>=10");
	$deathnum = $db->num_rows($result);
	
	movehtm();
	
	save_gameinfo();
	
	adminlog('infomng');
	
	$cmd_info = "狀態更新：激活人數 {$validnum},生存人數 {$alivenum},死亡人數 {$deathnum}<br>";
	$cmd_info .= "已重置移動地點緩存數據<br>";
}else{
	$cmd_info = "當前遊戲未開始！<br>";
}

# 暂时把房间人数自检放在这里
if(!empty($roomlist))
{
	foreach($roomlist as $rkey => $rinfo)
	{
		$result = $db->query("SELECT uid FROM {$gtablepre}users WHERE roomid = {$rkey}");
		if($db->num_rows($result)) 
		{
			$join_nums = $db->num_rows($result);
			$db->query("UPDATE {$gtablepre}game SET groomnums = {$join_nums} WHERE groomid = {$rkey}");
			$cmd_info .= "房間 {$rkey} 狀態更新：房間內人數 {$join_nums}<br>";
		}
		else 
		{
			$db->query("DELETE FROM {$gtablepre}game WHERE groomid = {$rkey}");
			$cmd_info .= "房間 {$rkey} 無人蔘與：已關閉<br>";
		}
	}
}

include template('admin_menu');

?>