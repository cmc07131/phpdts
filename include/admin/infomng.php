<?php
if(!defined('IN_ADMIN')) {
	exit('Access Denied');
}
if($mygroup < 2){
	exit($_ERROR['no_power']);
}


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
echo "狀態更新：激活人數 {$validnum},生存人數 {$alivenum},死亡人數 {$deathnum}<br>";
echo "已重置移動地點緩存數據";
?>