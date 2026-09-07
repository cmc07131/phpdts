<?php

	if (! defined ( 'IN_GAME' )) {
		exit ( 'Access Denied' );
	}

	# 新社团技能 - 特殊社团技能处理：

	# 升级指定技能会触发的事件，返回0时代表无法升级技能
	function upgclbskills_events($event,$sk,&$data=NULL)
	{
		global $log,$cskills,$now,$club_skillslist,$weather,$gamevars,$wthinfo,$db,$tablepre;
		global $elements_info;

		if(!isset($data))
		{
			global $pdata;
			$data = &$pdata;
		}
		extract($data,EXTR_REFS);

		# 事件：激活技能
		if($event == 'active_news')
		{
			addnews($now,'ask_'.$sk,$name);
			return 1;
		}
		# 事件：治疗
		if($event == 'heal')
		{
			# 事件效果：回复满生命、体力，并清空所有异常状态
			$heal_flag = 0;
			if(!empty($inf))
			{
				$inf = ''; 
				$heal_flag = 1;
				$log .= "你的所有異常狀態全部解除了！<br>";
			}
			if($hp < $mhp || $sp < $msp)
			{
				//$hp = $mhp; $sp = $msp;
				if($hp < $mhp){$hp = $mhp;}
				if($sp < $msp){$sp = $msp;}
				$heal_flag = 1;
				$log .= "你的生命與體力完全恢復了！<br>";
			}
			if(!$heal_flag)
			{
				$log .= "你不需要使用這個技能！<br>";
				return 0;
			}
			return 1;
		}
		# 事件：怒气充能
		if($event == 'charge')
		{
			if($rage >= 255)
			{
				$log .= "你不需要使用這個技能！<br>";
				return 0;
			}
			$rage = min(255,$rage + get_skillvars($sk,'rageadd'));
			// 检查当前技能使用次数
			$active_t = get_skillpara($sk,'active_t',$clbpara);
			// 第3次使用时开始冷却
			if($active_t+1 > get_skillvars($sk,'freet'))
			{
				$event = 'setstarttimes_'.$sk;
			}
			else 
			{
				return 1;
			}
		}
		# 事件：广域探测
		if($event == 'radar')
		{
			include_once GAME_ROOT.'./include/game/item2.func.php';
			newradar(2);
			return 1;
		}
		# 事件：灵感
		if($event == 'inspire')
		{
			# 事件效果：随机获取一个选定社团的技能……嗯……
			$sk_c = get_skillpara($sk,'choice',$data['clbpara']);
			$sk_list = $club_skillslist[$sk_c];
			if(!empty($sk_list))
			{
				do{
					$get_skill = $sk_list[array_rand($sk_list)];
				}while(get_skilltags($get_skill,'player'));
				// 检查是否为未学习技能
				$gsk_name = $cskills[$get_skill]['name'];
				$log .= "你靈光一現，忽然想到了技能<span class='lime'>「{$gsk_name}」</span>的用法！<br>";
				if(!in_array($get_skill,$data['clbpara']['skill']))
				{
					getclubskill($get_skill,$data['clbpara']);
					addnews($now,'inssk_'.$get_skill,$name,$sk);
				}
				else
				{
					$log .= "但是你已經學過<span class='lime'>「{$gsk_name}」</span>了……<br>";
					addnews($now,'inssk_failed',$name,$sk);
				}
				return 1;
			}
			else 
			{
				$log .= "所選稱號無可學習技能，這可能是一個BUG，請聯繫管理員。<br>";
			}
			return 0;
		}
		# 事件：晶璧
		if($event == 'crystal')
		{
			# 初始化护盾属性
			$slde = round(abs($rp) * get_skillvars($sk,'sldr') / 100);
			$sldt = 0;
			# 先看看能不能给自己套盾
			if(check_skill_unlock('buff_shield',$data))
			{
				getclubskill('buff_shield',$clbpara);
				set_skillpara('buff_shield','svar',$slde,$clbpara);
				$sldt++;
			}
			# 再遍历场上所有参战者（玩家、18、19）
			$result = $db->query("SELECT * FROM {$tablepre}players WHERE (type = 0 OR type =18 or type = 19) AND hp > 0 AND pid != {$pid}");
			while($sdata = $db->fetch_array($result))
			{
				$sdata['clbpara'] = get_clbpara($sdata['clbpara']);
				# 没有盾的话可以套个盾，有就不给了
				if(check_skill_unlock('buff_shield',$sdata))
				{
					getclubskill('buff_shield',$sdata['clbpara']);
					set_skillpara('buff_shield','svar',$slde,$sdata['clbpara']);
					$sldt++;
					player_save($sdata);
					$w_log = "<span class=\"yellow\">{$name}發動了技能「晶璧」，你被一層晶體護盾保護了起來！</span><br>";
					logsave ($sdata['pid'],$now,$w_log,'c');
				}
			}
			if($sldt)
			{
				# 降低rp
				$rploss = $sldt * get_skillvars($sk,'rploss');
				$rp -= $rploss;
				# 扣除怒气
				$ragecost = get_skillvars($sk,'ragecost');
				$rage -= $ragecost;
				$log .= "<span class='lime'>你用心感應，喚出晶體之盾為戰場上{$sldt}名參戰者提供了庇佑！</span><br>善行點數增加了！<br>";
			}
			else 
			{
				$log .= "你用心感應，但是戰場上似乎已經沒有需要你提供庇護的人了。<br>";
				return 0;
			}
			return 1;
		}
		# 事件：苦雨
		if($event == 'woesea')
		{
			if($weather == 18)
			{
				$log .= "戰場已經處於{$wthinfo[18]}下，不能重複發動！<br>";
				return 0;
			}
			else 
			{
				$ss -= 100;
				$weather = 18;
				$gamevars['wth18stime'] = $now;
				$gamevars['wth18etime'] = $now + get_skillvars('c19_woesea','wtht');
				$gamevars['wth18pid'] = $pid;
				save_gameinfo();
				addnews($now, 'wthchange', $name, $weather, '自己積攢的善德');
				$sn = 'song';
				addnoise($sn,'__',$now,$pls,0,0,$sn);
				$clbpara['event_bgmbook'] = Array('wth18');

				$log .= "你閉上雙眼，伴着記憶中那輕快的旋律輕輕哼唱起來……<br>
				歌聲悠然飄揚，朦朧間，你似乎感到有雨滴淅瀝落下，輕輕拍在你的臉上。<br>
				當你再度睜開眼時，<br>
				不知從何而來、如妖精般飛舞着的光球們撫過你的面頰，然後飄往虛擬戰場的每個角落——<br>
				……<br>
				下雨了。";
				return 1;
			}
		}
		# 事件：雇佣佣兵
		if($event == 'hiremerc')
		{
			$mcost = get_skillvars($sk,'mcost');
			$money -= $mcost;
			$anpcinfo = get_addnpcinfo();
			$mercinfo = $anpcinfo[25]['sub'];
			# 获取佣兵出货概率
			$tot = count($mercinfo);
			$tp = 0;
			for ($i=0; $i<$tot; $i++) $tp+=$mercinfo[$i]['probability'];
			$dice = rand(1,$tp);
			for ($i=0; $i<$tot; $i++)
			{
				if ($dice<=$mercinfo[$i]['probability'])
				{
					$merc = $i;
					break;
				}
				else  $dice-=$mercinfo[$i]['probability'];
			}
			# 登记佣兵序号
			$mid = get_skillpara($sk,'active_t',$clbpara);
			# 召唤佣兵，并获取佣兵pid
			include_once GAME_ROOT . './include/system.func.php';
			$merc_pid = addnpc(25,$merc,1,$now,Array('clbpara' => Array('mkey' => $mid, 'oid' => $pid, 'onm' => $name ,'mate' => Array($pid))),NULL,$pls)[0];
			# 初始化佣兵参数
			$clbpara['skillpara'][$sk]['id'][$mid] = $merc_pid;
			# 登记佣兵薪水
			$clbpara['skillpara'][$sk]['paid'][$mid] = $mercinfo[$merc]['mercsalary'];
			# 登记佣兵解雇后状态
			$clbpara['skillpara'][$sk]['leave'][$mid] = $mercinfo[$merc]['mercfireaction'];
			# 登记佣兵协战概率
			$clbpara['skillpara'][$sk]['coverp'][$mid] = $mercinfo[$merc]['coverp'];
			# 登记佣兵行动次数
			$clbpara['skillpara'][$sk]['mms'][$mid] = 0;
			# 检查佣兵能否协战（出生时在同一地图，默认可以协战）
			$clbpara['skillpara'][$sk]['cancover'][$mid] = 1;
			$log .= "你掏出千元大鈔振臂一呼，「{$mercinfo[$merc]['name']}」突然出現在了你的面前！<br>";
			return 1;
		}
		# 事件：横财
		if($event == 'windfall')
		{
			$tot = $element0 + $element1 + $element2 + $element3 + $element4 + $element5;
			if($tot < 5)
			{
				$log .= "你口袋中的元素太少了！再去撿點吧！<br>";
				return 0;
			}
			$numbers = array_fill(0, 6, 14);
			# 生成6个随机数，使它们的和等于16
			$t = 16;
			for ($i = 0; $i < 5; $i++) 
			{
				$at = rand(1,5);
				$t -= $at;
				$numbers[$i] += $at;
			}
			$numbers[5] += $t;
			$log .= "你把口袋中的元素攪混在一起……然後滿懷期待得等着它們自己把自己整理好……<br>";
			foreach($elements_info as $key => $info)
			{
				${'element'.$key} = 0;
				$add_ev = ceil($tot * ($numbers[$key]/100));
				include_once GAME_ROOT.'./include/game/elementmix.calc.php';
				$add_ev = get_clbskill_emgain_r($add_ev,$data);
				${'element'.$key} += $add_ev;
				$log .= "獲得了{$add_ev}份{$info}！<br>";
			}
			return 1;
		}
		# 事件：黑莲花
		if($event == 'lotus')
		{
			foreach($elements_info as $key => $info)
			{
				# 不足1000的，补足到3000
				if(${'element'.$key} < 1000)
				{
					${'element'.$key} = 3000;
					continue;
				}
				${'element'.$key} *= 3;
			}
			return 1;
		}
		# 事件：驱血
		if($event == 'creation')
		{
			include GAME_ROOT.'./gamedata/club21cfg.php';
			$new_itmsk = get_skillpara($sk,'choice',$clbpara);
			$sp_rate = get_skillvars($sk,'sp_rate');
			$skillpoint_value = get_skillvars($sk,'skillpoint_value');
			if (!empty($itmsk_extract_rate[$new_itmsk]))
			{
				$sp_cost = $itmsk_extract_rate[$new_itmsk] * $sp_rate;
				if ($sp < $sp_cost)
				{
					if ($sp + $skillpoint_value * $skillpoint >= $sp_cost)
					{
						$skillpoint_cost = ceil(($sp_cost - $sp) / $skillpoint_value);
						$log .= "消耗" . $skillpoint_cost . "技能點，代替了體力消耗。<br>";
						$skillpoint -= $skillpoint_cost;
						$sp_cost = $sp;
					}
					else
					{
						$log .= "體力與技能點不足，無法制造代碼片段。<br>";
						return 1;
					}
				}
				$log .= "消耗體力" . $sp_cost . "點，製造了該代碼片段。<br>";
				$sp = $sp - $sp_cost;
				$itm0 = "數據結成的屬性代碼片段";
				$itmk0 = '🥚'; 
				$itme0 = 0; 
				$itms0 = 1; 
				$itmsk0 = $new_itmsk;
				return 1;
			}
			else 
			{
				$log .= "該屬性代碼片段無法制造！這可能是一個BUG，請聯繫管理員。<br>";
			}
			return 0;
		}
		# 事件：涌血
		if($event == 'discovery')
		{
			global $gamevars;
			include GAME_ROOT.'./include/game/club21.func.php';
			if(empty($gamevars['name_fragment_list'])) $gamevars['name_fragment_list'] = generate_name_fragment_list($item_name_fragment_list, $name_fragment_available_num);
			$rank = get_skillpara($sk,'rank',$clbpara);
			$spcost = get_skillvars($sk,'spcost');
			$hpcost = get_skillvars($sk,'hpcost');
			
			if (($sp > $spcost) && ($hp > $hpcost))
			{
				$log .= "消耗體力上限" . $spcost . "點。<br>";
				$log .= "消耗生命上限" . $hpcost . "點。<br>";
				$msp -= $spcost;
				$mhp -= $hpcost;
				if ($sp > $msp) $sp = $msp;
				if ($hp > $mhp) $hp = $mhp;
				// 随机抽取一个当前技能等级的字段
				$rand_key = array_rand($gamevars['name_fragment_list'][$rank]);
				$new_frag = $gamevars['name_fragment_list'][$rank][$rand_key];
				$log .= "發現了字段<span class='yellow'>「" . $new_frag . "」</span>。<br>";
				set_skillpara($sk,'frag',$new_frag,$clbpara);
				return 1;
			}
			else{
				$log .= "你的體力與生命上限無法支撐你的這次嘗試。<br>";
			}
			return 0;			
		}
		# 事件：获取指定技能
		if(strpos($event,'getskill_') === 0)
		{
			# 事件效果：获取一个登记过的技能
			$gskid = substr($event,9);
			if(isset($cskills[$gskid]))
			{
				getclubskill($gskid,$clbpara);
			}
			else 
			{
				$log .= "技能{$gskid}不存在！這可能是一個BUG，請聯繫管理員。<br>";
				return 0;
			}
			return 1;
		}
		# 事件：为指定技能1设置技能2中的静态参数3
		if(strpos($event,'setskillvars_') === 0)
		{
			$sk_arr = str_replace('setskillvars_','',$event);
			$sk_arr = explode('|',$sk_arr);
			if(count($sk_arr) == 3)
			{
				$sk0 = $sk_arr[0]; $sk1 = $sk_arr[1]; $sk_vars = $sk_arr[2];
				$sk_vars = strpos($sk_vars,'+')!==false ? explode('+',$sk_vars) : Array($sk_vars);
				if(isset($cskills[$sk1]['maxlvl'])) $sklvl = get_skilllvl($sk1,$data);
				foreach($sk_vars as $var)
				{
					$sk_var = isset($sklvl) ? get_skillvars($sk1,$var,$sklvl) : get_skillvars($sk1,$var);
					set_skillpara($sk0,$var,$sk_var,$data['clbpara']);
				}
				return 1;
			}
			else 
			{
				$log .= "參數設置錯誤<br>";
				return 0;
			}
		}
		# 事件：为指定技能设置开始时间
		if(strpos($event,'setstarttimes_') === 0)
		{
			$gskid = substr($event,14);
			if(isset($cskills[$gskid])) 
			{
				set_starttimes($gskid,$clbpara);
			}
			else 
			{
				$log .= "技能{$gskid}不存在！這可能是一個BUG，請聯繫管理員。<br>";
				return 0;
			}
			return 1;
		}
		# 事件：为指定技能设置持续时间
		if(strpos($event,'setlasttimes_') === 0)
		{
			$gskarr = substr($event,13);
			$gskarr = explode('+',$gskarr);
			$gskid = $gskarr[0]; $gsklst = $gskarr[1];
			if(isset($cskills[$gskid]) && $gsklst) 
			{
				set_lasttimes($gskid,$gsklst,$clbpara);
			}
			else 
			{
				$log .= "技能{$gskid}不存在或持續時間{$gsklst}無效！這可能是一個BUG，請聯繫管理員。<br>";
				return 0;
			}
		}
		# 事件：切换技能的激活状态
		if(strpos($event,'active|') === 0)
		{
			$event = explode('|',$event); $sk = $event[1];
			$now_active = get_skillpara($sk,'active',$clbpara);
			$active = $now_active ? 0 : 1;
			$log .= $active ? "<span class='yellow'>技能已激活！</span><br>" : "<span class='yellow'>停用了技能效果。</span><br>" ; 
			set_skillpara($sk,'active',$active,$clbpara);
		}
		# 事件：天运
		if($event == 'c6_godluck' || $event == 'c6_godsend')
		{
			$dice0 = rand(1,2);
			$dice1 = rand(get_skillvars($event,'flucmin'),get_skillvars($event,'flucmax'));
			if($event == 'c6_godluck')
			{
				if($dice0 == 1)
				{
					set_skillpara($event,'accloss',get_skillpara($event,'accloss',$clbpara)+$dice1,$clbpara);
					set_skillpara($event,'rbloss',get_skillpara($event,'rbloss',$clbpara)+$dice1,$clbpara);
				}
				else 
				{
					set_skillpara($event,'accgain',get_skillpara($event,'accgain',$clbpara)+$dice1,$clbpara);
					set_skillpara($event,'rbgain',get_skillpara($event,'rbgain',$clbpara)+$dice1,$clbpara);
				}
			}
			else 
			{
				if($dice0 == 1)
				{
					set_skillpara($event,'actgain',get_skillpara($event,'actgain',$clbpara)+$dice1,$clbpara);
					set_skillpara($event,'hidegain',get_skillpara($event,'hidegain',$clbpara)+$dice1,$clbpara);
				}
				else 
				{
					set_skillpara($event,'countergain',get_skillpara($event,'countergain',$clbpara)+$dice1,$clbpara);
				}
			}
		}
		return 1;
	}

	# 「穿杨」与「咆哮」解锁
	function skill_c4_unlock($csk)
	{
		global $log,$pdata,$cskills;
		if(($csk != 'c4_roar' && $csk != 'c4_sniper') || !in_array($csk,$pdata['clbpara']['skill']))
		{
			$log .= "要解鎖的技能{$csk}不存在。<br>";
			return;
		}
		if(!check_skill_unlock('c4_roar',$pdata) || !check_skill_unlock('c4_sniper',$pdata))
		{
			$log .= "無法重複解鎖。<br>";
			return;
		}
		//include_once GAME_ROOT.'./include/game/revclubskills.func.php';
		set_skillpara($csk,'active',1,$pdata['clbpara']);
		set_skillpara(get_skillvars($csk,'disableskill'),'disable',1,$pdata['clbpara']);
		$log .= "<span class='yellow'>已解鎖技能「{$cskills[$csk]['name']}」！</span><br>";
		return;
	}
	# 佣兵工资判定
	function skill_merc_paid($sk,$mkey,&$mdata)
	{
		global $log,$now;
		if(!isset($data))
		{
			global $pdata;
			$data = &$pdata;
		}
		extract($data,EXTR_REFS);
		# 需支付工资的行动次数
		$mst = get_skillvars($sk,'mst'); 
		# 佣兵当前行动次数+1
		$mms = get_skillpara($sk,'mms',$clbpara)[$mkey]+1;
		if($mms >= $mst)
		{
			# 应付工资
			$paid = get_skillpara($sk,'paid',$clbpara)[$mkey];
			# 有钱付工资
			if($money >= $paid)
			{
				$mdata['money'] += $paid; $money -= $paid; 
				$log .= "<span class='yellow'>花費了{$paid}元，向{$mdata['name']}(傭兵{$mkey}號)支付了工資。</span><br>";
				$clbpara['skillpara'][$sk]['mms'][$mkey] = 0;
				//成功支付佣金，信任度+3，最多不超过90
				if($clbpara['skillpara'][$sk]['coverp'][$mkey] < 90) $clbpara['skillpara'][$sk]['coverp'][$mkey] += 3;
			}
			# 没钱要挨打
			else 
			{
				$mdata['money'] += $money; $money = 0; $hp = 1;
				player_save($mdata);
				$log .= "<span class='yellow'>眼看又到了結賬的時候，但你身上的錢不足以支付{$mdata['name']}(傭兵{$mkey}號)的工資……<br>被拖欠工資而惱羞成怒的傭兵狠揍了你一頓！並拿走了你所有剩下的錢！</span><br>";
				include_once GAME_ROOT.'./include/game/revclubskills_extra.func.php';
				$log .= "<span clas='red'>由於欠薪，";
				skill_merc_fire($sk,$mkey,$mdata,1);
				return;
			}
		}
		player_save($mdata);
		return;
	}
	# 佣兵移动判定
	function skill_merc_move($sk,$mkey,$moveto)
	{
		global $log,$plsinfo,$now;
		if(!isset($data))
		{
			global $pdata;
			$data = &$pdata;
		}
		extract($data,EXTR_REFS);
		if(isset($clbpara['skillpara'][$sk]['id'][$mkey]))
		{
			# 获取佣兵编号
			$mpid = get_skillpara($sk,'id',$clbpara)[$mkey];
			# 获取佣兵数据
			$mdata = fetch_playerdata_by_pid($mpid);
			if($mdata['hp'] <= 0)
			{
				$log .= "{$mdata['name']}已經西去了！放過他吧！<br>";
				return;
			}
			# 移动……？这个太扯了！
			include_once GAME_ROOT.'./include/game/search.func.php';
			//move($moveto,$mdata);
			if(!check_can_move($mdata['pls'],$mdata['pgroup'],$moveto)) return;
			# 计算移动花费 = 佣兵工资×2
			$mpaid = get_skillvars($sk,'movep') * get_skillpara($sk,'paid',$clbpara)[$mkey];
			if($money < $mpaid)
			{
				$log .= "你身上的錢不足以讓傭兵離開崗位！<br>";
				return;
			}
			$money -= $mpaid; 
			$mdata['pls'] = $moveto;
			addnews($now,'mercmove',$name,$mdata['name'],$moveto);
			$log .= "花費了{$mpaid}元，你將{$mdata['name']}叫到了{$plsinfo[$moveto]}！<br>";
			// 移动后佣兵失去追击焦点
			if(!empty($mdata['clbpara']['mercchase'])) $mdata['clbpara']['mercchase'] = 0;
			# 检查下工资情况
			skill_merc_paid($sk,$mkey,$mdata);
			player_save($mdata);
			// 移动后佣兵行动次数+2
			$clbpara['skillpara'][$sk]['mms'][$mkey] += get_skillvars($sk,'movep');
			// 移动后重新检查佣兵是否可协战
			$clbpara['skillpara'][$sk]['cancover'][$mkey] = $mdata['pls'] == $pls ? 1 : 0;
		}
		return;
	}
	# 解雇佣兵判定
	function skill_merc_fire($sk,$mkey,&$mdata=NULL,$mlog=0)
	{
		global $log,$now;
		if(!isset($data))
		{
			global $pdata;
			$data = &$pdata;
		}
		extract($data,EXTR_REFS);
		if(isset($clbpara['skillpara'][$sk]['id'][$mkey]))
		{
			# 判断离场事件
			$mpid = get_skillpara($sk,'id',$clbpara)[$mkey];
			$leave_flag = get_skillpara($sk,'leave',$clbpara)[$mkey];
			$leave_desc = $leave_flag ? '直接離開了戰場！' : '決定留在原地。';
			# 清除对应的佣兵数据
			unset($clbpara['skillpara'][$sk]['id'][$mkey]);
			unset($clbpara['skillpara'][$sk]['paid'][$mkey]);
			unset($clbpara['skillpara'][$sk]['leave'][$mkey]);
			unset($clbpara['skillpara'][$sk]['mms'][$mkey]);
			unset($clbpara['skillpara'][$sk]['coverp'][$mkey]);
			unset($clbpara['skillpara'][$sk]['cancover'][$mkey]);
			if(!isset($mdata)) $mdata = fetch_playerdata_by_pid($mpid);
			if($mlog)
			{
				$log .= "{$mdata['name']}與你的合作關係中止了！</span><br>";
			}
			else 
			{
				$log .= "你決定解僱{$mdata['name']}！";
				$log .= $mdata['hp']>0 ? "對方似乎{$leave_desc}<br>" : "雖然對方已經倒在工作崗位上了……<br>";
			}
			# 彻底离场类佣兵：
			if($leave_flag)
			{
				addnews($now,'mercleave',$name,$mdata['name']);
				destory_corpse($mdata);
			}
		}
		return;
	}
	# 佣兵追击判定
	function skill_merc_chase($sk,$mkey)
	{
		global $log,$now;
		if(!isset($data))
		{
			global $pdata;
			$data = &$pdata;
		}
		extract($data,EXTR_REFS);
		if(isset($clbpara['skillpara'][$sk]['id'][$mkey]))
		{
			$mid = get_skillpara($sk,'id',$clbpara)[$mkey];
			$mdata = fetch_playerdata_by_pid($mid);
			# 确实存在追击对象
			if(isset($mdata['clbpara']['mercchase']))
			{
				# 检查是否有钱强制命令佣兵追击
				$mccost = get_skillvars($sk,'atkp') * get_skillpara($sk,'paid',$data['clbpara'])[$mkey];
				if($mccost <= $money)
				{
					# 传递追击对象
					$action = 'enemy'; $bid = $mdata['clbpara']['mercchase'];
					# 佣兵追击不一定能先制，要判定一下
					include_once GAME_ROOT.'./include/game/revbattle.func.php';
					\revbattle\revbattle_prepare('bskill_c11_merc'.$mkey,'noactive');
				}
				else
				{
					$log .= "你身上的錢不夠！<br>";
					return;
				}
			}
		}
		return;
	}
	# 检查佣兵是否可协战
	function skill_check_merc_can_cover($sk,$mkey)
	{
		global $log,$plsinfo,$now;
		if(!isset($data))
		{
			global $pdata;
			$data = &$pdata;
		}
		extract($data,EXTR_REFS);
		if(isset($clbpara['skillpara'][$sk]['cancover'][$mkey])) return $clbpara['skillpara'][$sk]['cancover'][$mkey];
		return 0;
	}

	# 尸体发火！
	function skill_tl_cstick_act(&$edata)
	{
		global $log,$pdata,$cskills;
		//include_once GAME_ROOT.'./include/game/revclubskills.func.php';
		$lock = check_skill_unlock('tl_cstick',$pdata);
		if(!$lock)
		{
			# 扣除怒气
			$pdata['rage'] -= get_skillvars('tl_cstick','ragecost');
			addnews($now,'bsk_tl_cstick',$pdata['name'],$edata['name'].'的屍體');
			addnews($now,'cstick',$pdata['name'],$edata['name'].'的屍體');
			# 炼到了不该炼的尸体
			if(in_array($edata['type'],get_skillvars('tl_cstick','notype')))
			{
				$log .= "彷彿覺察到了你那邪惡的念頭，你剛一伸出手，{$edata['name']}的屍體便化作塵埃隨風散去了……<br>不知為何，你感到有些慚愧。<br>";
				destory_corpse($edata);
				$pdata['rp'] += 333;
				return;
			}
			# 开抡！
			$log .= "你乾脆利落地把<span class='red'>{$edata['name']}</span>從地上拽了起來！然後卯足力氣，在空中揮舞了兩下。<br>……<br>";
			$pdata['itm0'] = "{$edata['name']}屍體模樣的棍棒";
			$pdata['itmk0'] = 'WP'; 
			// Bugfix 240110
			$pdata['itme0'] = round($edata['msp']); 
			if ($pdata['itme0'] > 117007){ $pdata['itme0'] = 117007;}
			$pdata['itms0'] = round($edata['mhp']); 
			if ($pdata['itms0'] > 117007){ $pdata['itms0'] = 117007;}
			$pdata['itmsk0'] = '';
			$dice = diceroll(99);
			$N_obbs = pow($edata['lvl'],1.3);
			$z_obbs = !$edata['type'] ? pow($edata['lvl'],1.3) : pow($edata['lvl'],1.15);
			if($dice < $N_obbs)
			{
				$pdata['itmsk0'] .= 'N'; 
				$log .= "不錯！份量不輕不重剛剛好！<br>";
			}
			if($dice < $z_obbs)
			{
				$pdata['itmsk0'] .= 'Z'; 
				$log .= "越是揮舞，越覺趁手！這屍體彷彿死來就是為你準備的！<br>哇，這下真正撿到寶了！<br>";
			}
			if(empty($pdata['itmsk0']))
			{
				$log .= "哎呀……好像這具屍體和你的相性不是很好。但是無所謂啦！<br>";
			}
			# 出生啊！
			$max_rp_dice = $pdata['itme0']+$pdata['itms0'] > 300 ? $pdata['itme0']+$pdata['itms0'] : 300;
			$rp_dice = rand(300,$max_rp_dice);
			include_once GAME_ROOT.'./include/state.func.php';
			rpup_rev($pdata,$rp_dice);
			# 做成棍了就没有尸体了
			destory_corpse($edata);
			include_once GAME_ROOT.'./include/game/itemmain.func.php';
			itemget();
		}
		else 
		{
			$log .= isset($cskills['tl_cstick']['lockdesc'][$lock]) ? $cskills['tl_cstick']['lockdesc'][$lock] : $lock;
		}
		return;
	}
	
	# 妙手给尸体/塞东西
	function skill_tl_pickpocket_act($itmn)
	{
		global $log,$pdata,$cskills,$db,$tablepre;
		$lock = check_skill_unlock('tl_pickpocket',$pdata);
	
		$id = (end($pdata['clbpara']['smeo']))[0];
		$result = $db->query("SELECT * FROM {$tablepre}players WHERE pid = '$id'");
		$edata = $db->fetch_array($result);
		
		if(!$edata)
		{
			$log .= "就當你剛拿出道具的時候，卻發現先前看到的屍體已經不見了。這是怎麼做到的？<br>";
			$action = ''; $bid = 0;
			$mode = 'command';
			return;
		}
		
		if(!$lock)
		{
			# 扣除怒气
			$pdata['rage'] -= get_skillvars('tl_pickpocket','ragecost');
			if(!$pdata['itms'.$itmn])
			{
				$log .= '此道具不存在！';
				$action = ''; $bid = 0;
				$mode = 'command';
				return;
			}
			//诅咒物品都放？做个人吧！
			elseif(strpos($pdata['itmsk'.$itmn],'V')!==false)
			{
				$log .= "你剛拿起這個道具，就感覺腦內一片空白。<br>……你本來打算幹什麼來着？<br>不知為何，你感到了強烈的負罪感。<br>";
				$pdata['rp'] += 2333;
				$action = ''; $bid = 0;
				return;
			}
			//灵魂绑定物品放上去会消失，赛博烧纸
			elseif(strpos($pdata['itmsk'.$itmn],'v')!==false)
			{
				$log .= "你將這個道具放到了屍體上，它瞬間化作灰燼消散了。<br>……<br>你感到內心稍微平靜了一些。<br>";
				destory_single_item($pdata, $itmn);
				$pdata['rp'] -= 777;
				$action = ''; $bid = 0;
				return;
			}

			for($i = 1;$i <= 6; $i++)
			{
				if(!$edata['itms'.$i]) 
				{
					$edata['itm'.$i] = $pdata['itm'.$itmn];
					$edata['itmk'.$i] = $pdata['itmk'.$itmn];
					$edata['itme'.$i] = $pdata['itme'.$itmn];
					$edata['itms'.$i] = $pdata['itms'.$itmn];
					$edata['itmsk'.$i] = $pdata['itmsk'.$itmn];
					player_save($edata);
					$log .= '你冷靜下來張望四周，然後迅速將一個道具放入了屍體身上的物品中。<br>希望不要有人發現……？<br>';
					destory_single_item($pdata, $itmn);	
					//坏东西！
					$pdata['rp'] += 233;				
					$action = ''; $bid = 0;
					return;
				}
			}
			$log .= "屍體身上已經放了不少東西，你找不到一個合適的位置來放下你的物品。<br>";
		}
		else 
		{
			$log .= isset($cskills['tl_pickpocket']['lockdesc'][$lock]) ? $cskills['tl_pickpocket']['lockdesc'][$lock] : $lock;
		}
		return;
	}


?>
