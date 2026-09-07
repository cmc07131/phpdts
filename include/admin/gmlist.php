<?php
if(!defined('IN_ADMIN')) {
	exit('Access Denied');
}

$result = $db->query("SELECT uid,username,groupid FROM {$gtablepre}users WHERE groupid > 1 ORDER BY groupid DESC");
while($gm = $db->fetch_array($result)) {
	$gmdata[$gm['uid']] = $gm;
}
$cmd_info = '';
if($command == 'add') {
	$addgroup = intval($addgroup);
	if(!$addname) {
		$cmd_info =  '必須填寫GM賬號';
	} elseif ($addgroup < 2 || $addgroup >= $mygroup || $addgroup > 10) {
		$cmd_info =  '權限設置錯誤！';
	} else {
		$result = $db->query("SELECT uid,username,groupid FROM {$gtablepre}users WHERE username='$addname'");
		if(!$db->num_rows($result)) { 
			$cmd_info =  '此賬號不存在。'; 
		} else {
			$newgm = $db->fetch_array($result);
			if($newgm['groupid'] >1){
				$cmd_info =  '此賬號已經是管理員！'; 
			}else{
				$uid = $newgm['uid'];
				$db->query("UPDATE {$gtablepre}users SET groupid='$addgroup' WHERE uid='$uid'");
				adminlog('addgm',$addname,$addgroup);
				$cmd_info =  "管理員 {$addname} 添加成功，權限等級：{$addgroup}";
				$newgm['groupid'] = $addgroup;
				$gmdata[$uid] = $newgm;
			}				
		}
	}
	$command = 'gmlist';
} elseif($command == 'del') {
	$adminuid = intval($adminuid);
	if(isset($gmdata[$adminuid])) {
		$uid = $gmdata[$adminuid]['uid'];
		if($gmdata[$adminuid]['groupid'] >= $mygroup){
			$cmd_info = "權限不夠，不能刪除管理員 {$gmdata[$adminuid]['username']}！";
		} else {
			$db->query("UPDATE {$gtablepre}users SET groupid=1 WHERE uid='$uid'");
			adminlog('delgm',$gmdata[$adminuid]['username']);
			$cmd_info =  "管理員 {$gmdata[$adminuid]['username']} 的管理權限被刪除！";
			unset($gmdata[$adminuid]);
		}
	}else{
		$cmd_info =  "請輸入正確的數據！";
	}
	$command = 'gmlist';
} elseif($command == 'edit') {
	$adminuid = intval($adminuid);
	$editgroup = intval($_POST[$adminuid.'_group']);
	if(isset($gmdata[$adminuid])) {
		if ( $editgroup < 2 || $editgroup >= $mygroup || $editgroup > 10) {
			$cmd_info =  '權限設置錯誤！';
		} elseif($gmdata[$adminuid]['groupid'] >= $mygroup) {
			$cmd_info =  "權限不夠，不能編輯管理員 {$editname} ！<br>";
		} else {
			$db->query("UPDATE {$gtablepre}users SET groupid='$editgroup' WHERE uid='$adminuid'");
			adminlog('editgm',$gmdata[$adminuid]['username'],$editgroup);
			$cmd_info =  "管理員 {$gmdata[$adminuid]['username']} 權限修改成功，權限等級：{$editgroup}";
			$gmdata[$adminuid]['groupid'] = $editgroup;
		}
	}else{
		$cmd_info =  "請輸入正確的數據！";
	}
	$command = 'gmlist';
}
include template('admin_gmlist');

?>