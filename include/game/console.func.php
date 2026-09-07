<?php

	if(!defined('IN_GAME')) {
		exit('Access Denied');
	}
	include_once GAME_ROOT . './include/game/titles.func.php';
	include_once GAME_ROOT . './include/system.func.php';

	# 子面板 —— 控制模块
	$console_tips = Array
	(
		0 => "<span class='red'>※ 警告：",
		1 => "<span class='lime'>※ 反饋：",
		2 => "<span class='grey'>※ 維持該效果將佔用一條信道</span>",
	);

	# 天气控制 
	function console_wthchange($w)
	{
		global $clbpara,$gamevars,$now,$log,$weather,$wthinfo,$name,$nick,$mode;
		global $console_tips;

		if(!isset($clbpara['console']))
		{
			$log.= "輸入了無效的指令。<br>";
			return;
		}
		elseif(empty($gamevars['api']))
		{
			$log.= "{$console_tips[0]}可用信道不足，無法執行指令。</span><br>";
			return;
		}
		elseif(!array_key_exists($w,$wthinfo))
		{
			$log.= "{$console_tips[0]}輸入了非法的天氣參數，請檢查你提交的指令。</span><br>";
			return;
		}
		else 
		{
			if($weather == 18 || $w == 18)
			{
				$log .= "你像往常一樣提交指令後，終端那頭卻陷入了詭異的沉默中。<br>……這是怎麼回事……死機了？<br>";
				return;
			}
			$weather = $w;
			$log .= "提交了檢索指令後，你眼前的數據流開始閃爍。<br>與此同時，整處虛擬空間也開始發生變化……<br>
			{$console_tips[1]}已將天氣轉變為【{$wthinfo[$weather]}】</span><br>
			{$console_tips[2]}<br><br>";
			$gamevars['api'] --;
			save_gameinfo();
			addnews($now, 'csl_wthchange',$name, $weather,$nick);
		}
		return;
	}

	# 检索道具、陷阱、NPC
	function console_searching($kind,$nm,$ntype)
	{
		global $db,$tablepre,$clbpara,$gamevars,$typeinfo,$plsinfo,$hpinfo,$log,$mode;
		global $console_tips;

		$skind = Array(0=>'itm',1=>'trap',2=>'pc');

		//过滤输入名称中的非法字符
		//$nm = preg_replace('/[,\#;\p{Cc}]+|锋利的|电气|毒性|[\r\n]|-改|<|>|\"/u','',$nm);
		//过滤输入名称首尾的空格
		$nm = preg_replace('/^\s+|\s+$/m','', $nm);
		//过滤类别
		$kind = (int)$kind; $ntype = (int)$ntype;

		if(!isset($clbpara['console']))
		{
			$log.= "輸入了無效的指令。<br>";
			return;
		}
		elseif(empty($gamevars['api']))
		{
			$log.= "{$console_tips[0]}可用信道不足，無法執行指令。</span><br>";
			return;
		}
		elseif(empty($nm) || ($kind == 2 && !array_key_exists($ntype,$typeinfo)))
		{
			$log.= "{$console_tips[0]}輸入了非法的命名或類別參數，請檢查你提交的指令。</span><br>";
			return;
		}
		elseif(!isset($skind[$kind]))
		{
			$log.= "{$console_tips[0]}輸入了非法的檢索類別，請檢查你提交的指令。</span><br>";
			return;
		}

		if($skind[$kind] == 'pc')
		{
			$result = $db->query("SELECT * FROM {$tablepre}players WHERE name = '$nm' AND type = '$ntype' AND hp>0 ");
			$log.="提交了檢索指令後，你眼前的數據流開始閃爍……<br>片刻後，穩定下來的數據流";
			if(!$db->num_rows($result)) 
			{ 
				$log.="給出了一個令人失望的結果：<br><br>
				{$console_tips[1]}檢索對象【{$typeinfo[$ntype]} {$nm}】並不存在於系統中，或是ta已經死了。</span><br><br>";
				return;
			}
			else 
			{
				$spnums = $db->num_rows($result);
				$log.="打印出了一組數據：<br><br>
				{$console_tips[1]}檢索到<span class='clan'>{$spnums}</span>位符合條件的對象，如下所示：</span><br><br>";
			}
			if($db->num_rows($result) > 1)
			{
				$sparr = $spdata = Array();
				while($spdata = $db->fetch_array($result)) 
				{
					$sparr[$spdata['pls']] = isset($sparr[$spdata['pls']]) ? $sparr[$spdata['pls']]+1 : 1;
				}
				foreach($sparr as $spls => $snums)
				{
					$log .="·於<span class='yellow'>【{$plsinfo[$spls]}】</span>檢索到<span class='yellow'>【{$snums}】</span>名目標對象；<br>";
				}
			}
			else 
			{
				$spdata = $db->fetch_array($result);
				$snm = $typeinfo[$spdata['type']].' '.$spdata['name']; $spls = $spdata['pls'];
				if($spdata['hp'] < $spdata['mhp']*0.5){$shp = ($spdata['hp'] < $spdata['mhp']*0.2) ? 2 : 1;} else{$shp = 0;}
				$log .="·於<span class='yellow'>【{$plsinfo[$spls]}】</span>檢索到目標【{$snm}】<br>目標當前狀態：【{$hpinfo[$shp]}】<br>";
			}
		}
		elseif($skind[$kind] == 'itm' || $skind[$kind] == 'trap')
		{
			$tablename = $skind[$kind] == 'itm' ? 'mapitem' : 'maptrap';
			$tipdesc = $skind[$kind] == 'itm' ? '被放置在' : '被埋設於';
			$result = $db->query("SELECT * FROM {$tablepre}{$tablename} WHERE itm = '$nm'");
			$log.="提交了檢索指令後，你眼前的數據流開始閃爍……<br>片刻後，穩定下來的數據流";
			if(!$db->num_rows($result)) 
			{ 
				$log.="給出了一個令人失望的結果：<br><br>
				{$console_tips[1]}檢索對象【{$nm}】並不存在於系統中。</span><br><br>";
				return;
			}
			else 
			{
				$inums = $db->num_rows($result);
				$log.="打印出了一組數據：<br><br>
				{$console_tips[1]}檢索到<span class='clan'>【{$inums}】</span>份符合條件的對象，如下所示：</span><br><br>";
			}
			$sumidata = $idata = Array();
			while($idata = $db->fetch_array($result)) 
			{
				$sumidata[$idata['pls']] = isset($sumidata[$idata['pls']]) ? $sumidata[$idata['pls']]+1 : 1;
			}
			foreach($sumidata as $ipls => $inums)
			{
				$log .="
				<span class='yellow'>【{$inums}】</span>份{$nm}{$tipdesc}<span class='yellow'>【{$plsinfo[$ipls]}】</span>；<br>";
			}
		}
		$log .= "<br>{$console_tips[2]}<br><br>";
		$gamevars['api'] --;
		save_gameinfo();
		return;
	}

	# 禁区控制模块
	function console_areacontrol($kind)
	{
		global $log,$clbpara,$gamevars,$hack,$now,$name,$nick,$areatime,$areawarn;
		global $console_tips;

		$kind = (int)$kind;
		$skind = Array(0=>'hack',1=>'addarea');

		if(!isset($clbpara['console']))
		{
			$log.= "輸入了無效的指令。<br>";
			return;
		}
		elseif(!isset($skind[$kind]))
		{
			$log.= "{$console_tips[0]}提交了無效的禁區控制指令，請檢查你提交的指令。</span><br>";
			return;
		}
		elseif(empty($gamevars['api']) && $skind[$kind] !== 'hack')
		{
			$log.="{$console_tips[0]}可用信道不足，無法執行指令。</span><br>";
			return;
		}

		if($skind[$kind] == 'hack')
		{
			if(!$hack)
			{
				$log .= "提交指令後，你眼前的數據流開始閃爍。<br>與此同時，整處虛擬空間也開始發生變化……<br>{$console_tips[1]}已解除全部禁區</span><br>";
				$hack = 1;
				movehtm();
				storyputchat($now,'hack');
				addnews($now,'csl_hack',$name,$nick);
				save_gameinfo();
			}
			else 
			{
				$log .= "{$console_tips[0]}當前禁區已被解除，無法重複執行指令。</span><br>";
			}
		}
		elseif($skind[$kind] == 'addarea')
		{
			if(!$areawarn)
			{
				$log .= "提交指令後，你眼前的數據流開始閃爍。<br>與此同時，整處虛擬空間也開始發生變化……<br>{$console_tips[1]}已將下回禁區到來時間調整至5秒後</span><br>{$console_tips[2]}<br><br>";
				$areatime = $now+5;
				addnews($now,'csl_addarea',$name,$nick);
				areawarn();
				save_gameinfo();
			}
			else 
			{
				$log .= "{$console_tips[0]}新一回禁區即將到來，目前無法執行添加禁區指令。</span><br>";
			}
		}
		return;
	}

	# 别按那个按钮！
	function console_dbutton()
	{	
		global $log,$clbpara;

		if(!isset($clbpara['console']) || isset($clbpara['nobutton']))
		{
			$log.= "輸入了無效的指令。<br>";
			return;
		}
		include_once GAME_ROOT . './include/game/dice.func.php';
		$button_dice = diceroll(99);
		$log .= "這麼大個按鈕擺在這！哪會有人能忍住不按呢？<br>你果斷出手按下了按鈕！<br>……<br>";
		if ($button_dice < 75) 
		{
			$log .= "但是好像什麼也沒有發生……？<br><br>";
		} 
		elseif($button_dice < 95) 
		{
			global $itm0,$itmk0,$itme0,$itms0,$itmsk0;
			$log .= "<span class='yellow'>但是因為你按的太過用力，按鈕直接從界面上掉了出來！</span><br>等等……這不對吧！？<br><br>";
			$itm0 = '奇怪的按鈕';$itmk0 = 'Z';
			$itme0 = $itms0 = 1;$itmsk0 = '';
			$clbpara['nobutton'] = 1;
			include_once GAME_ROOT . './include/game/itemmain.func.php';
			itemget();
		} 
		else 
		{
			include_once GAME_ROOT . './include/state.func.php';
			$log .= '<span class="red">嗚哇，按鈕爆炸了！</span><br><br>';
			death ( 'button', '', 0, 'dangerbutton');
		}
		return;
	}
?>
