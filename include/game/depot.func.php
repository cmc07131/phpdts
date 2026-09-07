<?php

	if(!defined('IN_GAME')) {
		exit('Access Denied');
	}
	global $can_lootdepot_type;
	//个人仓库最多可以储存的道具数量 0=不限制
	$max_saveitem_num = 6;
	//储存每件道具的手续费
	$saveitem_cost = 20;
	//取出道具的手续费
	$loaditem_cost = 220;
	//游戏开场时NPC存在仓库里的道具
	$npc_depot = Array();
	//可以从哪些人的尸体上获取其存放在仓库里的道具权限？ 默认：仅玩家
	$can_lootdepot_type = Array(0);

	function depot_getlist($n,$t)
	{
		global $db,$tablepre;
		$iarr = Array();		
		$depot = $db->query("SELECT * FROM {$tablepre}itemdepot WHERE itmowner='$n' AND itmpw='$t'");
		while($i = $db->fetch_array($depot)) 
		{
			$iarr[] = $i;
		}
		return $iarr;
	}	

	function depot_changeowner($n,$t,$tn,$tt)
	{
		global $db,$tablepre;
		$db->query("UPDATE {$tablepre}itemdepot SET itmowner='$tn',itmpw='$tt' WHERE itmowner='$n' AND itmpw=$t");
	}

	function loot_depot($n,$t,$tn,$tt)
	{
		global $log,$can_lootdepot_type,$rp;
		if(!in_array($tt,$can_lootdepot_type))
		{
			$log.="無法轉移安全箱權限！可能是對方的權限等級比你高。<br>";
			return;
		}
		if(count(depot_getlist($tn,$tt))<=0) 
		{
			$log.="對方沒有在安全箱內存過東西！<br>";
			return;
		}
		depot_changeowner($tn,$tt,$n,$t);	
		$rp+=233;
		$log .= "你將{$tn}生前存放在安全箱裏的東西轉移到了自己的名下！哇，這可真是……<br>";
		addnews ( 0, 'loot_depot', $n, $tn );
		return;
	}

	function depot_save($i)
	{
		global $db,$tablepre,$arealist,$areanum,$hack;
		global $log,$pls,$name,$type,$money;
		global $max_saveitem_num,$saveitem_cost,$loaditem_cost,$depots;	
		global ${'itm'.$i},${'itmk'.$i},${'itme'.$i},${'itms'.$i},${'itmsk'.$i},${'itmpara'.$i};

		$i = (int)$i;
		if(!in_array($pls,$depots))
		{
			$log.="<span class='red'>你所在的位置沒有安全箱！建議你不要胡思亂想！</span><br>";
			return;
		}
		if(array_search($pls,$arealist) <= $areanum && !$hack)
		{
			$log.="<span class='red'>你所在的位置是禁區！還想着存東西，命不要啦！</span><br>";
			return;
		}
		if(!$i || $i>6 || $i<1 || (${'itms'.$i}<=0 && ${'itms'.$i}!=='∞'))
		{
			$log.="<span class='red'>要儲存的道具信息錯誤，請返回重新輸入。</span><br>";
			return;
		}
		if($money < $saveitem_cost)
		{
			$log.="<span class='red'>你身上的錢不足以支付儲存道具的手續費！</span><br>";
			return;
		}
		if(strpos(${'itmsk'.$i},'V')!==false)
		{
			$log.="<span class='red'>你嘗試着把詛咒道具扔進安全箱，但安全箱又立刻將它吐了出來！</span><br>";
			return;
		}
		if(strpos(${'itmsk'.$i},'v')!==false)
		{
			$log.="<span class='red'>你嘗試着把靈魂綁定的道具扔進安全箱，但安全箱又立刻將它吐了出來！</span><br>";
			return;
		}
			
		$idpt = depot_getlist($name,$type);
		$idpt_num = sizeof($idpt);

		if($idpt_num+1>$max_saveitem_num && $max_saveitem_num>0)
		{
			$log.="<span class='red'>安全箱已滿，無法再儲存更多道具！</span><br>";
			return;
		}

		$money -= $saveitem_cost;
		$log.="你成功將道具<span class='yellow'>{${'itm'.$i}}</span>存進了安全箱內！<br>同時被迫支付了手續費<span class='yellow'>{$saveitem_cost}</span>元。<br>";
		$itm=&${'itm'.$i};$itmk=&${'itmk'.$i};$itmsk=&${'itmsk'.$i};$itmpara=${'itmpara'.$i};
		$itme=&${'itme'.$i};$itms=&${'itms'.$i};
		addnews($now,'depot_save',$name,${'itm'.$i});
		$db->query("INSERT INTO {$tablepre}itemdepot (itm, itmk, itme, itms, itmsk , itmpara ,itmowner, itmpw) VALUES ('$itm', '$itmk', '$itme', '$itms', '$itmsk', '$itmpara', '$name', '$type')");
		$itm='';$itmk='';$itmsk='';$itmpara='';
		$itme=0;$itms=0;
	}

	function depot_load($i)
	{
		global $db,$tablepre,$arealist,$areanum,$hack;
		global $log,$pls,$name,$type,$money;
		global $max_saveitem_num,$saveitem_cost,$loaditem_cost,$depots;	
		global $itm0,$itmk0,$itme0,$itms0,$itmsk0,$itmpara0;

		$i = (int)$i;
		if(!in_array($pls,$depots))
		{
			$log.="<span class='red'>你所在的位置沒有安全箱！建議你不要胡思亂想！</span><br>";
			return;
		}
		if(array_search($pls,$arealist) <= $areanum && !$hack)
		{
			$log.="<span class='red'>你所在的位置是禁區！還想着取東西，命不要啦！</span><br>";
			return;
		}
		if($money < $loaditem_cost)
		{
			$log.="<span class='red'>你身上的錢不足以支付取出道具的保管費……卧槽竟然二次收費，太黑了吧！</span><br>";
			return;
		}

		$idpt = depot_getlist($name,$type);
		$idpt_num = sizeof($idpt);	

		if(($max_saveitem_num>0 && $i>$max_saveitem_num) || $i<0 || ($idpt[$i]['itms']<=0 && $idpt[$i]['itms']!=='∞'))
		{
			$log.="<span class='red'>要取出的道具信息錯誤，請返回重新輸入。</span><br>";
			return;
		}
		$itm0= $idpt[$i]['itm'];
		$itmk0= $idpt[$i]['itmk'];
		$itme0= $idpt[$i]['itme'];
		$itms0= $idpt[$i]['itms'];
		$itmsk0= $idpt[$i]['itmsk'];
		$itmpara0= $idpt[$i]['itmpara'];
		$iid = $idpt[$i]['iid'];
		addnews($now,'depot_load',$name,$itm0);
		$log.="你成功將道具<span class='yellow'>{$itm0}</span>從安全箱中取了出來！<br>同時被迫支付了保管費<span class='yellow'>{$loaditem_cost}</span>元……你感覺自己的心在滴血。<br>";
		$money -= $loaditem_cost;
		$db->query("DELETE FROM {$tablepre}itemdepot WHERE iid='$iid'");
		include_once GAME_ROOT.'./include/game/itemmain.func.php';
		itemget();
	}

?>
