<?php

namespace revcombat
{
	if(!defined('IN_GAME')) {
		exit('Access Denied');
	}

	include_once GAME_ROOT.'./include/game/itemmain.func.php';
	include_once GAME_ROOT.'./include/game/revcombat.calc.php';
	include_once GAME_ROOT.'./include/game/revattr.func.php';
	include_once GAME_ROOT.'./include/game/revattr.calc.php';
	include_once GAME_ROOT.'./include/game/revattr_extra.func.php';
	include_once GAME_ROOT.'./include/game/quest.func.php';

	# 初始化双方的攻击相关参数：
	# 依以下次序判定：
	# 1.防守方防守方式、防守方被动技能参数、武器射程、攻击熟练度、武器名； 
	# 2.进攻方攻击方式、进攻方主动技能参数、进攻方被动技能参数、武器射程、攻击熟练度、武器名；
	function get_attr_wepbase(&$pa,&$pd,$active,$wep_kind='')
	{
		# 初始化pd攻击方式参数
		\revattr\get_wep_kind($pd); 
		$pd['wep_range'] = \revattr\get_wep_range($pd);
		$pd['wep_name'] = $pd['wep'];

		# 初始化pa攻击方式参数
		\revattr\get_wep_kind($pa,$wep_kind,$pd['wep_range']); 
		\revattr\get_attr_bskills($pa,$pd,$active);
		$pa['wep_range'] = \revattr\get_wep_range($pa);
		$pa['wep_name'] = $pa['wep'];

		# 初始化pa、pd被动技能相关参数
		\revattr\get_attr_passive_skills($pd,$pa,$active);
		\revattr\get_attr_passive_skills($pa,$pd,$active);

		# 初始化pa、pd熟练度相关参数
		$pd['wep_skill'] = \revattr\get_wep_skill($pd);
		$pa['wep_skill'] = \revattr\get_wep_skill($pa);
	}

	# 正式进入rev_combat战斗状态后，在判定伤害、反击流程前的事件执行阶段；
	# 即无论是否反击都只会触发1次的事件，返回值小于0时会直接中断战斗；
	function combat_prepare_events(&$pa,&$pd,$active)
	{
		# 百命猫 初始化事件： 每次初始化战斗时都会提升等级与怒气
		if (($pa['type'] == 89 && $pa['name']=='是TSEROF啦！') || ($pd['type'] == 89 && $pd['name']=='是TSEROF啦！'))
		{ 
			\revattr\attr_extra_89_100lifecat($pa,$pd,$active);
		}

		# 笼中鸟 初始化事件：喂养成功会跳过战斗
		if($pa['type'] == 89 && $pa['name'] =='籠中鳥')
		{
			$flag = \revattr\attr_extra_89_cagedbird($pa,$pd,$active);
			if($flag < 0) return $flag;
		}
		elseif($pd['type'] == 89 && $pd['name'] =='籠中鳥')
		{
			$flag = \revattr\attr_extra_89_cagedbird($pd,$pa,$active);
			if($flag < 0) return $flag;
		}

		# NPC换装判定：
		if($pa['type']) npc_changewep_rev($pa,$pd,$active);
					
		# 检查成就503
		if(!empty($pa['arbs']) && $pa['arb'] == '【智代專用熊裝】') \revattr\attr_ach53_check($pa,$pd,$active);
		if(!empty($pd['arbs']) && $pd['arb'] == '【智代專用熊裝】') \revattr\attr_ach53_check($pd,$pa,$active);

		# QUEST战斗前事件 / QUEST combat prepare events
		$quest_flag = \quest_combat_prepare_events($pa,$pd,$active);
		if($quest_flag < 0) return $quest_flag;

		return 1;
	}

	# 进入rev_combat战斗状态后，在判定伤害、反击流程前的喊话事件
	function combat_prepare_logs(&$pa,&$pd,$active)
	{
		global $log,$now;
		if(!empty($pa['message']))
		{
			$log.="<span class=\"lime\">{$pa['nm']}向{$pd['nm']}喊道：「{$pa['message']}」！</span><br>";
			if (!$pd['type']) 
			{
				$w_log = "<span class=\"lime\">{$pa['name']}對你大喊：「{$pa['message']}」！</span><br>";
				logsave ($pd['pid'],$now,$w_log,'c');
			}
		}
		if($active)
		{
			if(isset($pa['is_chase']))
			{
				$log .= "{$pa['nm']}再度向<span class=\"red\">{$pd['nm']}</span>發起攻擊！<br>";
			}
			elseif(isset($pa['is_dfight']))
			{
				$log .= "{$pa['nm']}抓住機會搶先向<span class=\"red\">{$pd['nm']}</span>發起攻擊！<br>";
			}
			elseif(isset($pa['is_coveratk']))
			{
				$log .= "<span class='yellow'>正當你們打的難解難分之際，{$pa['nm']}抓住機會，向<span class=\"red\">{$pd['nm']}</span>發起突襲！</span><br>";
			}
			else 
			{
				$log .= "{$pa['nm']}向<span class=\"red\">{$pd['nm']}</span>發起攻擊！<br>";
			}
		}
		else
		{
			if(isset($pa['is_chase']))
			{
				$log .= "<span class=\"red\">{$pa['nm']}</span>再度向{$pd['nm']}襲來！<br>";
			}
			elseif(isset($pa['is_dfight']))
			{
				$log .= "但是<span class=\"red\">{$pa['nm']}</span>搶先對{$pd['nm']}發起攻擊！<br>";
			}
			elseif(isset($pa['is_coveratk']))
			{
				$log .= "<span class='yellow'>正當你們打的難解難分之際，{$pa['nm']}抓住機會，向<span class=\"red\">{$pd['nm']}</span>發起突襲！</span><br>";
			}
			else
			{
				$log .= "<span class=\"red\">{$pa['nm']}</span>突然向{$pd['nm']}襲來！<br>";
			}
		}

		# NPC喊话判定
		if($pa['type']) $log .= npc_chat_rev ($pa,$pd,'attack');

		return;
	}

	# 单次打击结束后（即执行完rev_attack()，执行rev_combat_result()过程中检测到敌人未死亡时）需要判定的事件
	function attack_result_events(&$pa,&$pd,$active)
	{
		global $now,$log,$infinfo,$exdmginf,$plsinfo;

		# 真蓝凝防守事件：
		if($pd['type'] == 19 && $pd['name'] == '藍凝')
		{
			\revattr\attr_extra_19_azure($pa,$pd,$active);
		}

		# 「灭气」技能效果
		if(isset($pa['skill_c1_burnsp']))
		{
			$pd['sp'] = max($pd['sp']-round($pa['final_damage']*2/3),1);
			//$log .= "<span class='yellow'>「灭气」使{$pd['nm']}的体力降低了！</span><br>";
		}

		# 「猛击」眩晕效果
		if(isset($pa['skill_c1_crit']))
		{
			$sk_lvl = get_skilllvl('c1_crit',$pa);
			$sk_lst = get_skillvars('c1_crit','stuntime',$sk_lvl);
			$flag = \revattr\get_skillinf_rev($pd,'inf_dizzy',$sk_lst);
			if($flag)
			{
				if(!$pd['type'] && $pd['nm']!='你') $pd['logsave'] .= "兇猛的一擊直接將你打暈了過去！<br>";
				elseif(!$pa['type'] && $pa['nm']!='你') $pa['logsave'] .= "你兇猛的一擊直接將<span class=\"yellow\">{$pd['name']}</span>打暈了過去！<br>";
			}
		}

		# 「磁暴」效果判定
		if(isset($pa['bskill_c7_electric']))
		{
			if(strpos($pd['inf'],'e')!==false)
			{
				$flag = \revattr\get_skillinf_rev($pd,'inf_dizzy',get_skillvars('c7_electric','lasttimes'));
				if($flag)
				{
					$log .= "<span class='yellow'>由於已經處於麻痹狀態，狂暴的電流直接將{$pd['nm']}電暈了！</span><br>";
					if(!$pd['type'] && $pd['nm']!='你') $pd['logsave'] .= "狂暴的電流直接將你電暈！<br>";
					elseif(!$pa['type'] && $pa['nm']!='你') $pa['logsave'] .= "狂暴的電流直接將<span class=\"yellow\">{$pd['name']}</span>電暈！<br>";
				}
			}
			else 
			{
				$infr = get_skillvars('c7_electric','infr');
				$dice = diceroll(99);
				if($dice < $infr)
				{
					$flag = \revattr\get_inf_rev($pd,'e');
					$log .= "<span class='yellow'>「磁暴」使{$pd['nm']}{$exdmginf['e']}了！</span><br>";
				}
				else
				{
					$log .= "<span class='yellow'>{$pd['nm']}沒有受到「磁暴」影響！</span><br>";
				}
			}
		}

		# 「脉冲」效果判定
		if(isset($pa['bskill_c7_emp']) && $pa['bskill_c7_emp'] > 1)
		{
			if(strpos($pd['inf'],'e')!==false)
			{
				$flag = \revattr\get_skillinf_rev($pd,'inf_dizzy',get_skillvars('c7_electric','lasttimes'));
				if($flag)
				{
					$log .= "<span class='yellow'>由於已經處於麻痹狀態，狂暴的能量脈衝直接把{$pd['nm']}衝暈了過去！</span><br>";
					if(!$pd['type'] && $pd['nm']!='你') $pd['logsave'] .= "狂暴的能量脈衝把你衝暈了過去！<br>";
					elseif(!$pa['type'] && $pa['nm']!='你') $pa['logsave'] .= "狂暴的能量脈衝把<span class=\"yellow\">{$pd['name']}</span>衝暈了過去！<br>";
				}
			}
			else 
			{
				$flag = \revattr\get_inf_rev($pd,'e');
				$log .= "<span class='yellow'>「脈衝」使{$pd['nm']}{$exdmginf['e']}了！</span><br>";
			}
		}

		# 「渗透」效果判定
		if(isset($pa['skill_c8_infilt']))
		{
			$sk_lvl = get_skilllvl('c8_infilt',$pa);
			$infr = get_skillvars('c8_infilt','infr',$sk_lvl);
			$dice = diceroll(99);
			if($dice < $infr)
			{
				$flag = \revattr\get_inf_rev($pd,'p');
				include_once GAME_ROOT.'./include/game/itemmain.func.php';
				check_item_edit_event($pa,$pd,'c8_infilt');
				if($flag) $log .= "<span class='yellow'>「滲透」使{$pd['nm']}{$exdmginf['p']}了！</span><br>";
				else $log .= "<span class='yellow'>{$pd['nm']}沒有受到「滲透」影響……大概吧？</span><br>";
			}
			else
			{
				$log .= "<span class='yellow'>{$pd['nm']}沒有受到「滲透」影響！</span><br>";
			}
		}
		
		# 「延咒」效果判定
		if(isset($pa['skill_tl_cursetouch']))
		{
			$curse_obbs = get_skillvars('tl_cursetouch','curse_obbs');
			$curserate = get_skillvars('tl_cursetouch','curserate');
			$dice = diceroll(99);
			if (in_array('V',$pa['ex_keys'])) $curse_obbs *= $curserate;
			if($dice < $curse_obbs)
			{
				include_once GAME_ROOT.'./include/game/itemmain.func.php';
				$flag = check_item_edit_event($pa,$pd,'tl_cursetouch');
				if($flag) $log .= "<span class='yellow'>「延咒」使{$pd['nm']}受到了詛咒！</span><br>";
			}
		}
	
		# 「妙手」效果判定
		if (isset($pa['bskill_tl_pickpocket']))
		{
			$picklimit = get_skillvars('tl_pickpocket','picklimit');
			//这叫earn合适吗？
			$earn = round($pd['money'] * rand(0, $picklimit) / 100);
			if ($earn == 0) $log .= "<span class='yellow'>{$pa['nm']}沒有從{$pd['nm']}身上獲得金錢！</span><br>";
			else
			{
				$pd['money'] -= $earn;
				$pa['money'] += $earn;				
				$log .= "<span class='yellow'>你從{$pd['nm']}身上獲得了{$earn}元金錢！</span><br>";
				if(!$pd['type'] && $pd['nm']!='你') $pd['logsave'] .= "你被竊走了{$earn}元金錢！<br>";
				elseif(!$pa['type'] && $pa['nm']!='你') $pa['logsave'] .= "你從{$pd['name']}身上獲得了{$earn}元金錢！<br>";
			}
		}
		
		# 「冰心」效果判定
		if (isset($pd['skill_c9_iceheart']) && !empty($pd['inf']))
		{
			$purify = get_skillvars('c9_iceheart','purify');
			# 获取当前异常队列
			$now_inf = str_split($pd['inf']);
			# 计算最多可净化异常数
			$purify = min($purify,count($now_inf));
			for($p=0;$p<$purify;$p++)
			{
				$heal_inf = $now_inf[$p];
				$flag = \revattr\heal_inf_rev($pd,$heal_inf);
				if($flag)
				{
					$log .= "<span class='yellow'>{$pd['nm']}斂神聚氣，從{$exdmginf[$heal_inf]}中恢復了！</span><br>";
					$pd['rage'] = min(255,$pd['rage']+get_skillvars('c9_iceheart','ragegain'));
				}
			}
		}

		# 「天佑」技能判定
		if(isset($pd['skill_c6_godbless']) && empty($pd['skill_buff_godbless']) && !empty($pa['final_damage']))
		{
			$actmhp = get_skillvars('c6_godbless','actmhp');
			if($pa['final_damage'] >= $pd['mhp']*($actmhp/100) && $pd['hp'] > 0)
			{
				getclubskill('buff_godbless',$pd['clbpara']);
				$log .= "<span class=\"yellow\">{$pd['nm']}的技能「天佑」被觸發，暫時進入了無敵狀態！</span><br>";
			}
		}

		# 「火花」技能判定：触发后不会再触发协战流程
		if(isset($pa['askill_c20_sparkle']))
		{
			$sk = 'c20_sparkle';
			$dice = diceroll(99);
			$obbs = get_skillvars($sk,'tpr');
			if($dice < $obbs)
			{
				$pa['askill_c20_sparkle'] = 2;
				$plslist = get_safe_plslist(); 
				$sp_pls = $plslist[array_rand($plslist)];
				# 切换地图
				$pd['pls'] = $sp_pls;
				$pd['tp_by_sparkle'] = $sp_pls;
				# NPC敌人扣血，玩家在被送到新地图后强制探索一次
				if($pd['type'])
				{
					$pd['hp'] -= min($pd['hp']-1,rand(1,$sp_pls * 10));
				}
				else 
				{
					$pd['action'] = 'tpmove';
					$pd['logsave'] .= "<span class=\"grey\">{$pa['name']}點燃火花，將你傳送到了{$plsinfo[$sp_pls]}！</span><br>";
				}
				$log .= "<span class=\"yellow\">你點燃火花，將{$pd['nm']}送到了{$plsinfo[$sp_pls]}！祝他好運吧……</span><br>";
				addnews($now,'sparklemove',$pa['name'],$pd['name'],$plsinfo[$sp_pls]);
				return;
			}
		}

		# 「协战」判定
		# 拥有佣兵的情况下，主动攻击敌人/成功反击敌人，且敌人仍存活时，判定是否有佣兵协战
		if(!empty(get_skillpara('c11_merc','id',$pa['clbpara'])))
		{
			$sk = 'c11_merc';
			$cancovers = get_skillpara($sk,'cancover',$pa['clbpara']);
			shuffle($cancovers);
			$dice = diceroll(99);
			foreach($cancovers as $mkey => $mcan)
			{
				if($mcan)
				{
					$mcps = get_skillpara($sk,'coverp',$pa['clbpara'])[$mkey];
					if($dice < $mcps)
					{
						# 触发协战，将协战者ID记录在coopatk_flag内
						$pa['coveratk_flag'] = get_skillpara($sk,'id',$pa['clbpara'])[$mkey];
						//echo "触发了协战！协战对象ID：{$pa['coveratk_flag']}<br>";
						break;
					}
				}
			}
		}
		# 「灵俑」协战判定
		if(empty($pa['coveratk_flag']) && !empty($pa['clbpara']['zombieid']))
		{
			# 「灵俑」基础协战率：50
			$cover_obbs = 50; $cover_dice = diceroll(99);
			if($cover_dice < $cover_obbs)
			{
				$mate_list = $pa['clbpara']['mate']; shuffle($mate_list); 
				foreach($mate_list as $mid)
				{
					$mdata = fetch_playerdata_by_pid($mid);
					# 跳过不在同一地图的灵俑
					if($mdata['pls'] != $pd['pls'] || $mdata['hp'] < 1) continue;
					# 触发协战
					$pa['coveratk_flag'] = $mid;
					break;
				}
			}
		}

		# QUEST战斗结算事件 / QUEST attack result events
		$quest_flag = \quest_attack_result_events($pa,$pd,$active);
		if($quest_flag < 0) return $quest_flag;
		return;
	}

	# 单次打击结束后，检查是否需要循环打击流程，返回值不为0则循环
	function attack_check_can_loop(&$pa,&$pd,$active)
	{
		global $log;
		$loop = 0;

		# 「双响」效果判定
		if(!$loop && isset($pa['bskill_c5_double']))
		{
			unset($pa['bskill_c5_double']);unset($pa['bskilllog']);
			$log .= "<span class=\"yellow\">{$pa['nm']}引爆了預埋的另一組爆炸物！</span><br>";
			$loop = 1;
		}

		# 「海虎」效果判定
		if(!$loop && isset($pa['skill_c12_swell']))
		{
			$pa['skill_c12_swell'] --;
			if(empty($pa['skill_c12_swell'])) unset($pa['skill_c12_swell']);
			$log .= "<span class=\"lime\">{$pa['nm']}以雷霆萬鈞之勢再度襲向{$pd['nm']}！</span><br>";
			$loop = 1;
		}

		# 「快拳」效果判定
		if(!$loop && isset($pa['skill_c13_quick']))
		{
			$sk_dice = diceroll(99);
			$sk_obbs = get_skillvars('c13_quick','rapidr',get_skilllvl('c13_quick',$pa));

			#「乱击」概率增幅
			if(isset($pa['bskill_c13_wingchun'])) $sk_obbs += get_skillvars('c13_wingchun','rapidr',get_skilllvl('c13_wingchun',$pa));
			#「决战」概率增幅
			if(isset($pa['skill_buff_duel'])) $sk_obbs += get_skillvars('buff_duel','rapidr');

			if($sk_dice <= $sk_obbs)
			{
				$pa['skill_c13_quick'] --;
				if(empty($pa['skill_c13_quick'])) unset($pa['skill_c13_quick']);
				$log .= "<span class=\"lime\">{$pa['nm']}身法靈動，再度出拳！</span><br>";
				$loop = 1;
			}
		}

		# 循环打击触发时，注销所有的主动技触发标记
		if($loop && !empty($pa['bskill']) && !empty($pa['bskill_'.$pa['bskill']]))
		{
			unset($pa['bskill_'.$pa['bskill']]);
			unset($pa['bskill']);
			if(!empty($pa['bskilllog'])) unset($pa['bskilllog']);
			if(!empty($pa['bskilllog2'])) unset($pa['bskilllog2']);
		}

		return $loop;
	}

	# 执行完rev_attack() rev_combat_result()后 检查防守方(pd)是否能进行反击
	function attack_check_can_counter(&$pa,&$pd,$active)
	{
		# 被协战攻击无法反击
		if(isset($pa['is_coveratk']))
		{
			$pd['cannot_counter_log'] = "{$pd['nm']}雙拳難敵四手，逃跑了！";
			return 0;
		}
		# 被偷袭无法反击
		if(isset($pa['bskill_c1_stalk']))
		{
			$pd['cannot_counter_log'] = "{$pd['nm']}無法反擊！";
			return 0;
		}
		# 被留手了应不应该反击……？暂时定不会反击，但是会反击也很合理，人心险恶嘛！
		if(isset($pa['askill_c19_dispel']) && $pa['askill_c19_dispel'] == 2)
		{
			$pd['cannot_counter_log'] = "被你放了一馬的{$pd['nm']}一瘸一拐地逃開了。<br>希望你的決定是正確的……";
			return 0;
		}
		# 被火花传送走了不能反击
		if(isset($pd['tp_by_sparkle']))
		{
			$pd['cannot_counter_log'] = "{$pd['nm']}傳送走了！<br>";
			return 0;
		}
		# 处于眩晕状态时，无法反击
		if(isset($pd['skill_inf_dizzy']))
		{
			$pd['cannot_counter_log'] = "{$pd['nm']}正處於眩暈狀態，無法反擊！";
			return 0;
		}
		# 治疗姿态、躲避策略不能反击
		if($pd['pose'] == 5 || $pd['tactic'] == 4)
		{
			$pd['cannot_counter_log'] = "{$pd['nm']}處於無法反擊的狀態！轉身逃開了！";
			return 0;
		}
		# 哨戒姿态不会反击，但是会生气……
		# 生气后会变更为强袭姿态
		if($pd['pose'] == 7)
		{
			$pd['pose'] = 2;
			$pd['cannot_counter_log'] = "{$pd['nm']}看起來非常生氣！這回你可攤上事啦！";
			return 0;
		}

		# 检查是否在pa是否在pd的反击射程内
		$range_flag = calc_counter_range($pa,$pd,$active);

		# pd的射程不足，无法反击
		if(!$range_flag)
		{
			$pd['cannot_counter'] = 'cannot';
			$pd['cannot_counter_log'] = "<span class=\"red\">{$pd['nm']}攻擊範圍不足，不能反擊，逃跑了！</span><br>";
			return 0;
		}
		# pd的射程足够反击，计算反击率
		else 
		{
			# 计算反击率
			$counter = calc_counter_rate($pa,$pd,$active);
			# 掷骰
			$counter_dice = diceroll(99);
			if ($counter_dice < $counter) 
			{
				return 1;
			} 
			else 
			{
				$pd['cannot_counter'] = 'escape';
				$pd['cannot_counter_log'] = "<span class=\"red\">{$pd['nm']}沒能抓住機會反擊，逃跑了！</span><br>";
				return 0;
			}
		}
		return 1;
	}


}
?>
