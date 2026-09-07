<?php
if(!defined('IN_ADMIN')) {
	exit('Access Denied');
}

if($command == 'killroom')
{
	roommng_close_room($roomkey,1);
	$command = '';
}
elseif($command == 'killallroom')
{
	for($r=1;$r<=$max_rooms;$r++)
	{
		roommng_close_room($r,1,1);
	}
	$command = '';
}

echo <<<EOT
<form method="post" name="roommng" onsubmit="admin.php">
<input type="hidden" name="mode" value="roommng">
<input type="hidden" id="command" name="command" value="killroom">
強制關閉指定房間：
<select name="roomkey">
EOT;

foreach($roomlist as $rkey => $rinfo)
{
echo <<<EOT
	<option value="{$rkey}">房間 {$rkey} 號 | 正在遊玩人數：{$rinfo['alivenum']}
EOT;
}

echo <<<EOT
</select>
<input type="submit" value="強制關閉">
<br>
<span class='red'>（警告：正處於遊戲狀態中的房間也會被關閉！）</span>
<br><br>
EOT;

echo <<<EOT
<span tooltip="只會關閉尚未開始、或已無倖存玩家的房間">
<input type="submit" value="關閉所有閒置房間" onclick="$('command').value='killallroom';"><br>
</span>
EOT;

echo <<<EOT
</form>
EOT;

?>