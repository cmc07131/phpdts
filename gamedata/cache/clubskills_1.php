<?php
if(!defined('IN_GAME')) exit('Access Denied');

# 技能相关配置文件：

# 社团变更时可获得的技能清单：
$club_skillslist = Array
(
	1  => Array('s_hp','s_ad','f_heal','c1_def','c1_crit','c1_stalk','c1_burnsp','c1_bjack','c1_veteran'), #'街头霸王',
	2  => Array('s_hp','s_ad','f_heal','c2_butcher','c2_intuit','c2_raiding','c2_master','c2_annihil'), #'见敌必斩',
	3  => Array('s_hp','s_ad','f_heal','c3_pitchpow','c3_enchant','c3_potential','c3_hawkeye','c3_offset','c3_numerous'), #'灌篮高手',
	4  => Array('s_hp','s_ad','f_heal','c4_stable','c4_break','c4_aiming','c4_loot','c4_roar','c4_sniper','c4_headshot'), #'狙击鹰眼',
	5  => Array('s_hp','s_ad','f_heal','c5_sneak','c5_caution','c5_review','c5_focus','c5_higheg','c5_double'), #'拆弹专家',
	6  => Array('s_hp','s_ad','f_heal','c6_godluck','c6_godsend','c6_godbless','c6_godpow','c6_godeyes','c6_justice'), #'宛如疾风',
	7  => Array('s_hp','s_ad','f_heal','c7_radar','c7_shield','c7_electric','c7_field','c7_overload','c7_emp'), #'锡安成员',
	8  => Array('s_hp','s_ad','f_heal','c8_expert','c8_infilt','c8_catalyst','c8_deadheal','c8_assassin'), #'黑衣组织',
	9  => Array('s_hp','s_ad','f_heal','c9_spirit','c9_lb','c9_iceheart','c9_charge','c9_heartfire'), #'超能力者',
	10 => Array('s_hp','s_ad','f_heal','c10_inspire','c10_insight','c10_decons'), #'天赋异禀', //高速成长与天赋异禀合并为天赋异禀
	11 => Array('s_hp','s_ad','f_heal','c11_ebuy','c11_merc','c11_stock','c11_renjie'), #'富家子弟',
	12 => Array('s_hp','s_ad','f_heal','c12_huge','c12_enmity','c12_garrison','c12_rage','c12_bloody','c12_swell'), #'全能兄贵', //根性兄贵、肌肉兄贵、全能骑士合并为全能兄贵
	13 => Array('s_hp','s_ad','f_heal','c13_master','c13_kungfu','c13_quick','c13_wingchun','c13_parry','c13_duel'),
	//13 => Array('s_hp','s_ad','f_heal'), #'根性兄贵',
	//14 => Array('s_hp','s_ad','f_heal'), #'肌肉兄贵',
	15 => Array('f_heal'), #'<span class="L5">L5状态</span>',
	//16 => Array('s_hp','s_ad','f_heal'), #'全能骑士',
	17 => Array('f_heal'), #'走路萌物',
	//18 => Array('s_hp','s_ad','f_heal'), #'天赋异禀',
	19 => Array('s_hp','s_ad','f_heal','c19_nirvana','c19_reincarn','c19_purity','c19_crystal','c19_redeem','c19_dispel','c19_woesea'), #'晶莹剔透', //晶莹剔透、决死结界合并为晶莹剔透
	20 => Array('s_hp','s_ad','f_heal','c20_fertile','c20_windfall','c20_lighting','c20_zombie','c20_sparkle','c20_lotus'), #'元素大师', #商店购买社团卡
	21 => Array('s_hp','s_ad','f_heal','c21_stormedge','c21_creation','c21_discovery','c21_sacrifice','c21_blaster'), #'码语行人', #商店购买社团卡
	22 => Array('s_hp','s_ad','f_heal','c22_fireseed'), #'枫火歌者', #暂定名，「除错大师」头衔奖励
	98 => Array('s_hp','s_ad','f_heal'), #'换装迷宫',
	99 => Array('s_hp','s_ad','f_heal'), #'第一形态'
);

# 社团技能黑名单：（禁止特定社团升级/学习对应技能）
$cskills_blist = Array
(
	# 走路萌物无法升级生命
	's_hp' => Array(0,17),
	# 走路萌物无法升级攻防
	's_ad' => Array(0,17),
);

# 社团技能白名单：（允许特定社团升级/学习对应技能）
$cskills_wlist = Array
(

);

# 社团技能标签介绍：
$cskills_tags = Array
(
	//'club' => '<span tooltip="隐藏标签：代表这个技能会显示在称号技能页面" class="gold">【称号】</span>',
	'battle' => '<span tooltip="可以在戰鬥中主動使用" class="gold">【戰鬥技】</span>',
	'passive' => '<span tooltip="滿足條件時自動觸發" class="gold">【被動技】</span>',
	'switch' => '<span tooltip="可主動啓用或停用效果" class="gold">【開關技】</span>',
	'active' => '<span tooltip="可在技能界面直接使用" class="gold">【主動技】</span>',
	'openning' => '<span tooltip="僅在初次先制發現敵人時可用" class="gold">【開幕技】</span>',
	'limit' => '<span tooltip="每局遊戲內可發動次數有限" class="gold">【限次技】</span>',
	//'inf' => '<span tooltip="隐藏标签：代表这是一个负面状态，这个技能会显示在状态页面" class="gold">【异常】</span>',
	//'buff' => '<span tooltip="隐藏标签：代表这是一个正面状态，这个技能会显示在状态页面" class="gold">【增益】</span>',
	//'unlock_battle_hidden' => '<span tooltip="隐藏标签：未解锁时不会在战斗界面显示" class="gold">【隐藏】</span>',
	//'player' => '<span tooltip="隐藏标签：只有玩家会有此技能" class="gold">【玩家】</span>',
);

// tips
$sktrapidatk = '<span class="gold" tooltip2="【連續攻擊】：攻擊完畢、且造成的最終傷害結算後，在敵人反擊前再度發起攻擊">連續攻擊</span>';
$sktpshield = '<span class="gold" tooltip2="【護盾】：可抵消等同於護盾值的傷害。護盾值只在抵消屬性傷害時消耗，抵消電擊傷害時雙倍消耗。護盾存在時不會受到反噬傷害或陷入異常狀態。">護盾</span>';
$sktprp = '<span class="yellow">報應點數</span>';
$sktpwhitedmg = '<span class="gold" tooltip2="【純粹傷害】：不會受防禦、抹消或制御效果影響的定值傷害">純粹傷害</span>';
$sktpzombie = '<span class="gold" tooltip2="【靈俑】：此狀態下的角色造成的最終傷害降低50%，受到的傷害降低25%；不會受到反噬傷害，但不能再造成除毒性、凍氣外的屬性傷害；">靈俑</span>';
$sktpemsdmg = "<span class=\"gold\" tooltip2=\"【亮晶晶】：造成純粹傷害（不受防禦、抹消或制御效果影響的定值傷害）\r【暖洋洋】：造成火焰傷害\r【冷冰冰】：造成凍氣傷害\r【冷冰冰】：造成凍氣傷害\r【鬱萌萌】：造成毒性傷害\r【晝閃閃】：造成電氣傷害\r【夜靜靜】：造成音波傷害\">屬性/純粹</span>";
# 技能登记：
$cskills = Array
(
	'fireseed1' => Array
	(
		'name' => '種火I',
		'tags' => Array('passive'),
		'desc' => '套裝技能，使你因為戰鬥受到的所有最終傷害都降低為75%。',
	),
	'fireseed2' => Array
	(
		'name' => '種火II',
		'tags' => Array('passive'),
		'desc' => '套裝技能，使你因為戰鬥受到的所有最終傷害都降低為50%。',
	),
	'fireseed3' => Array
	(
		'name' => '種火III',
		'tags' => Array('passive'),
		'desc' => '套裝技能，使你因為戰鬥受到的所有最終傷害都變為1。',
	),
	'fireseed4' => Array
	(
		'name' => '種火IV',
		'tags' => Array('passive'),
		'desc' => '套裝技能，使你受到的所有傷害（包括戰鬥、事件、陷阱、食用毒物等）都變為0。',
	),
	'tl_2ndchance' => Array
	(
		'name' => '奇機',
		'tags' => Array('passive'),
		'desc' => '在戰鬥中，受到將大於目前生命值的傷害時，以一線生機存活下來。',
	),
	'tl_oncemore' => Array
	(
		'name' => '起跡',
		'tags' => Array('passive'),
		'desc' => '在戰鬥中，只要自己的生命值為1，則只有一次可以免除下一次傷害（狀態可刷新）。',
	),
	'npc_overrainbow' => Array
	(
		'name' => '破虹',
		'tags' => Array('passive'),
		'desc' => '發動禁咒反「Over The Rainbow」，以七色彈幕對對手造成反彈傷害。微小几率發射出無縫彈幕。',
	),
	'npc_7colour' => Array
	(
		'name' => '七色', #HOROU用，无实际作用，逻辑直接写入Tooltip
		'tags' => Array('passive'),
		'desc' => '你擁有七種顏色的符卡。',
	),
	'npc_wrelease' => Array
	(
		'name' => '解放',
		'tags' => Array('switch'),
		'desc' => '打開後探索時消耗額外體力，但只在戰鬥中基礎攻擊力與防禦力增加。',
		'svars' => Array(
			'active' => 1, // 初始激活
			'level' => 2, // 初始倍数为2
		),
	),
	'npc_flying' => Array
	(
		'name' => '飛行',
		'tags' => Array('passive'),
		'desc' => '你移動不消耗體力值。',
	),
	'npc_mecstasy' => Array
	(
		'name' => '來潮',
		'tags' => Array('switch'),
		'desc' => '打開後你對敵人以及敵人對你造成的傷害全部變為真實判定。（對防禦特別高的玩家不適用）',
		'svars' => Array(
			'active' => 1, // 初始激活
		),
	),
	'npc_perfectspy' => Array
	(
		'name' => '勇諜',
		'tags' => Array('passive'),
		'desc' => '你受到的來自陷阱的傷害成為0，且只要你的HP大於200，則在戰鬥中你的HP不會被下降到200以下。',
	),
	'npc_wisp' => Array
	(
		'name' => '指像',
		'tags' => Array('passive'),
		'desc' => '你對除<span class="yellow">[:targets:]%</span>以外其他玩家戰鬥造成和受到的傷害均變為0。',
		'svars' => Array(
			'targets' => Array(), // 初始无目标
		),
	),
	'npc_purity' => Array
	(
		'name' => '潔淨',
		'tags' => Array('passive'),
		'desc' => '戰鬥時無法獲得經驗值。',
	),
	'c22_fireseed' => Array
	(
		'name' => '楓火',
		'tags' => Array('passive'),
		'desc' => '你可以通過在發現種火的屍體頁面收納種火，並通過側邊欄進行部署。<br>',
	),
	// 可以通过在此文件中填写配置项来创建一个新技能，系统会自动生成模板。如果配置文件不能满足需求，可以自己创建一个模板文件
	/*'技能编号' => Array
	(
		'name' => '技能名', //（必填）技能名
		'tags' => Array(), //（非必填）定义一个技能带有的标签
		'desc' => '', //（非必填）技能介绍，显示在技能面板上，可以使用[: :]设置一些静态参数，会在生成时自动替换对应参数。
			// [:cost:]：消耗的技能点
			// [::]：还可以替换为任意'effect'、'vars'内定义过的键名
			// [^^]：可以被替换为在'pvars'内定义过的角色数据，比如lvl

		'bdesc' => '', //（战斗技必填）显示在战斗界面上的短介绍，战斗技必填
		'maxlvl' => 0, //（非必填）定义一个技能为可升级技能，并定义该技能的等级上限。注意：带有等级上限的技能如果设置了'cost'，'cost'的值必须是一个数组，对应每等级升级时需消耗的技能点
		'cost' => 1, //（可升级/操作技能必填）升级/操作技能要花费的技能点，如果设置过'maxlvl'，这里应该设置成一个Array
		'input' => '升级',//（可升级/操作技能必填）自动生成模板时，对应操作按钮的名字，不存在时不会生成按钮
		'num_input' => 1,//（非必填）自动生成模板时，是否会为其生成数字输入框（便于快速提交多次升级）
		'log' => '', //（可升级/操作技能必填）升级/操作技能后显示的提示文本

		'status' => Array('hp','mhp'),//（非必填）每次升级时，直接提升的玩家属性。
			// 和头衔入场奖励类似，支持所有在数据库中登记过的字段名
			// 依 skillpara|c1_crit-lvl 格式设定，可以改变储存在clbpara内的内容。具体格式为：键名|技能名-子键名 如没有子键名只需要填 键名|技能名
		'effect' => Array(0 => Array('att' => 4, 'def' => 6),13 => Array('att' => 9, 'def' => 12),),//（非必填）每次升级时，直接提升的玩家属性对应的值。
			// 键名为 0 时，代表默认情况下会增加的对应属性值。键值可以是一个由字段名构成的数组。也可以只是一个数字——代表会增加所有'status'中登记的属性值
			// 键名为 其他数字 时，代表该数字对应 社团 会增加的属性值
		'events' => Array(''); //（非必填）每次升级时会触发的事件
		'link' => Array(), //（非必填）技能的关联对象：技能在生成介绍模板时，会同时从关联对象中获取静态参数
		'vars' => Array(), //（非必填）技能内预设的静态参数，比如'ragecost'怒气消耗。预设的参数可以自动填充'desc'中对应[::]的内容
		'svars' => Array(), //（非必填）初次获得技能时，保存在clbpara['skillpara']['技能编号']中的动态技能参数。可以用来定义技能的使用次数等。
		'pvars' => Array(), //（非必填）技能会受到对应的角色数据影响，可见技能-解牛；
		'slast' => Array('lasttimes' => 0,'lastturns' => 0,), //（非必填）初次获得时效性技能时，保存在clbpara内的数据。暂时只支持以下参数：
			// 'lasttimes' => 0,  代表技能持续的时间，保存在clbpara['lasttimes']['技能编号']中
			// 'lastturns' => 0,  代表技能持续的回合，保存在clbpara['lastturns']['技能编号']中
			// 时效性技能才初次霍德师，还会获得一个等于当前时间戳的'starttimes'，保存在clbpara['starttimes']['技能编号']中
			// 玩家在行动时会判断时效性技能是否结束，NPC敌人在被玩家发现时会判断时效性技能是否结束，并在战斗开始前保存状态
		'lockdesc' => '', //（需解锁技能必填）不满足解锁条件时的介绍
		'unlock' => Array('lvl' => '[:lvl:] >= 3',), //（非必填）技能解锁条件，键名和键值[::]内的内容要相同。键值须为PHP支持的条件判断语句。支持“或”类型判断，请参考下方例子。
			// Array('wepk+wep_kind' => "[:wepk:] == 'WP' || [:wep_kind:] == 'P'",), 键名中的+是分隔符，处理时会依此将条件分割为数组，替换键值内的判断语句
	),*/
	's_hp' => Array
	(
		'name' => '生命',
		'tags' => Array('player'),
		'desc' => '每消耗<span class="lime">[:cost:]</span>技能點，生命上限<span class="yellow">+[:hp:]</span>點',
		'cost' => 1,
		'input' => '升級',
		'num_input' => 1,
		'log' => '消耗了<span class="lime">[:cost:]</span>點技能點，你的生命上限增加了<span class="yellow">[:hp:]</span>點。<br>',
		'status' => Array('hp','mhp'),
		'effect' => Array(
			0 => Array( 'hp' => '+=::3', 'mhp' => '+=::3',),
			12 => Array( 'hp' => '+=::6', 'mhp' => '+=::6',),
			20 => Array( 'hp' => '+=::4', 'mhp' => '+=::4',),
		),
	),
	's_ad' => Array
	(
		'name' => '攻防',
		'tags' => Array('player'),
		'desc' => '每消耗<span class="lime">[:cost:]</span>技能點，基礎攻擊<span class="yellow">+[:att:]</span>點，基礎防禦<span class="yellow">+[:def:]</span>點',
		'cost' => 1,
		'input' => '升級',
		'num_input' => 1,
		'log' => '消耗了<span class="lime">[:cost:]</span>點技能點，你的基礎攻擊增加了<span class="yellow">[:att:]</span>點，基礎防禦增加了<span class="yellow">[:def:]</span>點。<br>',
		'status' => Array('att','def'),
		'effect' => Array(
			0 => Array('att' => '+=::4', 'def' => '+=::6'),
			12 => Array('att' => '+=::9', 'def' => '+=::12'),
		),
	),
	'f_heal' => Array
	(
		'name' => '自愈',
		'tags' => Array('player'),
		'desc' => '消耗<span class="lime">[:cost:]</span>技能點，解除全部受傷與異常狀態，並完全恢復生命與體力',
		'cost' => 1,
		'input' => '治療',
		'log' => '消耗了<span class="lime">[:cost:]</span>技能點。<br>',
		'events' => Array('heal'),
	),
	'c1_def' => Array
	(
		'name' => '格擋',
		'tags' => Array('passive'),
		'desc' => '持毆系武器時，武器效果值的<span class="yellow">[:trans:]%</span>計入防禦力(最多[:maxtrans:]點)<br>',
		'vars' => Array(
			'trans' => 40, //效&防转化率
			'maxtrans' => 2000, //转化上限
		),
		'lockdesc' => Array(
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">毆系武器</span>時生效',
		),
		'unlock' => Array(
			'wepk+wep_kind' => "strpos([:wepk:],'P')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'P')",
		),
	),
	'c1_crit' => Array
	(
		'name' => '猛擊',
		'tags' => Array('passive'),
		'desc' => '持毆系武器戰鬥時<span class="yellow">[:rate:]%</span>幾率觸發，觸發則物理傷害增加<span class="yellow">[:attgain:]%</span>，<br>
		且暈眩敵人<span class="clan">[:stuntime:]</span>秒。暈眩狀態下敵人無法進行任何行動或戰鬥。<br></span>',
		'maxlvl' => 2,
		'cost' => Array(10,11,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「猛擊」升級成功。</span>',
		'status' => Array('skillpara|c1_crit-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c1_crit-lvl' => '+=::1'),
		),
		'svars' => Array(
			'lvl' => 0, //初次获得时等级为0
		),
		'vars' => Array(
			'attgain' => Array(20,50,80), //物理伤害增加
			'stuntime' => Array(1,1,2), //晕眩时间（单位:秒）
			'rate' => 25, //触发率
		),
		'lockdesc' => Array(
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">毆系武器</span>時生效',
		),
		'unlock' => Array(
			'wepk+wep_kind' => "strpos([:wepk:],'P')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'P')",
		),
	),
	'c1_stalk' => Array
	(
		'name' => '偷襲',
		'tags' => Array('battle','opening'),
		'wepk' => Array('P'),
		'desc' => '本次攻擊必定觸發技能“<span class="yellow">猛擊</span>”且不會被反擊。<br>
		持毆系武器方可發動，發動消耗<span class="yellow">[:ragecost:]</span>點怒氣。<br>',
		'bdesc' => '必定觸發技能“<span class="yellow">猛擊</span>”且不會被反擊。消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 25, //消耗怒气
		),
		'lockdesc' => Array(
			'lvl' => '3級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">毆系武器</span>時可發動',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 3',
			'wepk+wep_kind' => "strpos([:wepk:],'P')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'P')",
		),
	),
	'c1_burnsp' => Array
	(
		'name' => '滅氣',
		'tags' => Array('passive'),
		'desc' => '持毆系武器攻擊後敵人體力減少<span class="yellow">傷害值的[:burnspr:]%</span>點<br>
		被攻擊時你額外獲得<span class="yellow">[:mingrg:]～[:maxgrg:]點</span>怒氣',
		'vars' => Array(
			'burnspr' => 33, //体力减少&伤害占比
			'mingrg' => 1, //最小怒气增益
			'maxgrg' => 2, //最大怒气增益
		),
		'lockdesc' => Array(
			'lvl' => '6級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">毆系武器</span>時可發動',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 6',
			'wepk+wep_kind' => "strpos([:wepk:],'P')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'P')",
		),
	),
	'c1_bjack' => Array
	(
		'name' => '悶棍',
		'tags' => Array('battle'),
		'wepk' => Array('P'),
		'desc' => '本次攻擊必定觸發技能“<span class="yellow">猛擊</span>”，<br>
		並對敵人額外造成(<span class="yellow">敵方體力上限減當前體力</span>)點的最終傷害。<br>
		持鈍器方可發動，發動消耗<span class="yellow">[:ragecost:]</span>點怒氣。',
		'bdesc' => '必定觸發技能“<span class="yellow">猛擊</span>”，並附加(<span class="yellow">敵方體力上限減當前體力</span>)點傷害。消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 85, //消耗怒气
		),
		'lockdesc' => Array(
			'lvl' => '11級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">毆系武器</span>時可發動',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 11',
			'wepk+wep_kind' => "strpos([:wepk:],'P')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'P')",
		),
	),
	'c1_veteran' => Array
	(
		# 这是一个使用固定模板的技能 在这里进行编辑不会有任何效果……等等，还是有点效果的……编辑下面提供的内容是会有效果的
		'name' => '百戰',
		'tags' => Array('passive'),
		'clog' => "切換了「百戰」的防禦類型。",
		'choice' => Array('P','K','C','G','F','D','I','U','q','W','E'), //可选择的单系防御类型
		'svars' => Array(
			'choice' => 'D', //初始默认选择的单项防御
		),
		'lockdesc' => Array(
			'lvl' => '18級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 18',
		),
	),
	'c2_butcher' => Array
	(
		'name' => '解牛',
		'tags' => Array('battle'),
		'wepk' => Array('K'),
		'desc' => '本次攻擊附加<span class="yellow">([:fixdmg:]+<span tooltip="基於你目前的等級">[^lvl^]</span>)</span>點的最終傷害，且武器損耗率減半。<br>
		持斬系武器方可發動，消耗<span class="yellow">[:ragecost:]</span>點怒氣',
		'bdesc' => '本次攻擊附加<span class="yellow">[:fixdmg:]+[^lvl^]</span>點傷害，且武器損耗率減半，消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 5,
			'fixdmg' => 30, //基础固定伤害
			'wepimpr' => 0.5, //武器损耗率
		),
		'pvars' => Array('lvl'),
		'lockdesc' => Array(
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">斬系武器</span>時可發動',
		),
		'unlock' => Array(
			'wepk+wep_kind' => "strpos([:wepk:],'K')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'K')",
		),
	),
	'c2_intuit' => Array
	(
		'name' => '直感',
		'tags' => Array('passive'),
		'desc' => '持斬系武器時，你的命中率<span class="yellow">+[:accgain:]%</span>，反擊率<span class="yellow">+[:countergain:]%</span>，<br>
		連擊命中率懲罰降低<span class="yellow">[:rbgain:]%</span>，武器傷害浮動範圍<span class="yellow">+[:flucgain:]%</span>，<br>
		有<span class="yellow">[:rangerate:]%</span>概率允許超射程反擊(爆系除外)<br>',
		'maxlvl' => 6,
		'cost' => Array(4,4,4,4,5,5,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「直感」升級成功。</span>',
		'status' => Array('skillpara|c2_intuit-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c2_intuit-lvl' => '+=::1'),
		),
		'svars' => Array(
			'lvl' => 0, //初次获得时等级为0
		),
		'vars' => Array(
			'accgain' => Array(0,2,4,6,8,11,14), //命中增益
			'rbgain' => Array(0,2,4,6,8,10,12), //连击命中惩罚降低
			'flucgain' => Array(0,5,10,15,20,25,30), //伤害浮动修正
			'rangerate' => Array(0,20,40,60,80,100,100), //超射程反击率
			'countergain' => Array(0,2,3,4,10,12,30), //基础反击率
		),
		'lockdesc' => Array(
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">斬系武器</span>時生效',
		),
		'unlock' => Array(
			'wepk+wep_kind' => "strpos([:wepk:],'K')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'K')",
		),
	),
	'c2_raiding' => Array
	(
		'name' => '強襲',
		'tags' => Array('battle'),
		'wepk' => Array('K'),
		'desc' => '本次攻擊無視減半類防禦屬性，最終傷害<span class="yellow">+[:findmgr:]%</span>',
		'bdesc' => '本次攻擊攻擊最終傷害<span class="yellow">+[:findmgr:]%</span>，無視敵方減半類防禦屬性；消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 70,
			'findmgr' => 40, //最终伤害加成
		),
		'lockdesc' => Array(
			'lvl' => '15級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">斬系武器</span>時可發動',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 15',
			'wepk+wep_kind' => "strpos([:wepk:],'K')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'K')",
		),
	),
	'c2_master' => Array
	(
		'name' => '舞鋼',
		'tags' => Array('passive'),
		'desc' => '使用斬系武器時，你的武器傷害浮動不會出現負值。',
		'lockdesc' => Array(
			'lvl' => '15級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">斬系武器</span>時生效',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 15',
			'wepk+wep_kind' => "strpos([:wepk:],'K')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'K')",
		),
	),
	'c2_annihil' => Array
	(
		'name' => '殲滅',
		'tags' => Array('active'),
		'desc' => '發動後獲得增益效果：<br>
		持斬系武器時，你的攻擊有<span class="yellow">[:rate:]%</span>概率造成<span class="red b">[:findmgr:]%</span>最終傷害；<br>
		計算屬性傷害時你的基礎攻擊力將視作武器攻擊力。<br>
		增益效果持續時間<span class="yellow">[:lasttimes:]</span>秒，冷卻時間<span class="clan">[:cd:]</span>秒。<br>',
		'input' => '發動',
		'log' => '<span class="lime">技能「殲滅」發動成功。</span><br>',
		'status' => Array('skillpara|c2_annihil-active'),
		'effect' => Array(
			0 => Array('skillpara|c2_annihil-active' => '=::1'),
		),
		'events' => Array('setstarttimes_c2_annihil','getskill_buff_annihil','active_news'),
		'link' => Array('buff_annihil'),
		'vars' => Array(
			'lasttimes' => 200, //持续时间 仅供介绍文本显示用
			'cd' => 900, //冷却时间
		),
		'svars' => Array(
			'active' => 0,
		),
		'lockdesc' => Array(
			'lvl' => '21級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">斬系武器</span>時可發動',
			'skillpara|c2_annihil-active' => '技能發動中！',
			'skillcooldown' => '技能冷卻中！<br>剩餘冷卻時間：<span class="red">[:cd:]</span> 秒',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 21',
			'wepk+wep_kind' => "strpos([:wepk:],'K')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'K')",
			'skillpara|c2_annihil-active' => 'empty([:skillpara|c2_annihil-active:])',
			'skillcooldown' => 0,
		),
	),
	'buff_annihil' => Array
	(
		'name' => '[狀態]殲滅',
		'tags' => Array('buff'),
		'desc' => '<span class="lime">「殲滅」生效中！<br>
		增益效果剩餘時間：<span class="yellow">[^lasttimes^]</span> 秒</span>',
		'vars' => Array(
			'rate' => 20, //发动概率
			'findmgr' => 200, //最终伤害加成
		),
		'slast' => Array(
			'lasttimes' => 200, //真正作用的持续时间
		),
		'pvars' => Array('lasttimes'),
		'lostevents' => Array('unactive_c2_annihil'),
		'lockdesc' => Array(
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">斬系武器</span>時生效',
		),
		'unlock' => Array(
			'wepk+wep_kind' => "strpos([:wepk:],'K')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'K')",
		),
	),
	'c3_pitchpow' => Array
	(
		'name' => '臂力',
		'tags' => Array('passive'),
		'desc' => '手持投系武器時，反擊率<span class="yellow">+[:countergain:]%</span>',
		'maxlvl' => 6,
		'cost' => Array(2,2,2,2,3,3,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「臂力」升級成功。</span>',
		'status' => Array('skillpara|c3_pitchpow-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c3_pitchpow-lvl' => '+=::1'),
		),
		'svars' => Array(
			'lvl' => 0, //初次获得时等级为0
		),
		'vars' => Array(
			'countergain' => Array(0,20,40,60,80,100,125),
		),
		'lockdesc' => Array(
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">投系武器</span>時生效',
		),
		'unlock' => Array(
			'wepk+wep_kind' => "strpos([:wepk:],'C')!==false || strpos([:wepk:],'B')!==false || (!empty([:wep_kind:]) && ([:wep_kind:] == 'C' || [:wep_kind:] == 'B'))",
		),
	),
	'c3_enchant' => Array
	(
		'name' => '附魔',
		'tags' => Array('battle','passive'),
		'wepk' => Array('C'),
		'desc' => '<span tooltip="主動發動時，若角色身上不存在傷害類屬性，則會為其臨時附加一項隨機屬性。"><span class="grey">[附加提示]</span>
		主動發動時，<br>在本次施加的下列屬性中隨機選擇一種，<br>你持投系武器造成的該屬性傷害永久<span class="yellow">+[:exdmggain:]%</span>(最高[:exdmgmax:]%)。<br>
		持投擲兵器時生效，消耗<span class="yellow">[:ragecost:]</span>點怒氣。<br>
		目前各屬性加成統計：<br></span>',
		'bdesc' => '<span tooltip="主動發動時，若角色身上不存在傷害類屬性，則會為其臨時附加一項隨機屬性。"><span class="grey">[附加提示]</span>
		發動後將使某一隨機屬性傷害永久<span class="yellow">+[:exdmggain:]%</span>；消耗<span class="red">[:ragecost:]</span>怒氣</span>',
		'vars' => Array(
			'ragecost' => 8,
			'exdmggain' => 3, //单项属性伤害加成
			'exdmgmax' => 150, //单项属性伤害加成上限
			'exdmgarr' => Array( //单项属性与加成的对应关系
				'u' => 'ur', 'f' => 'ur',
				'i' => 'ir', 'k' => 'ir',
				'e' => 'er',
				'p' => 'pr',
				'w' => 'wr',
				'd' => 'dr',
			),
			'exdmgdesc' => Array( //介绍该附魔对应的加成关系
				'u' => '火焰/灼焰',
				'i' => '凍氣/冰華',
				'p' => '毒性',
				'w' => '音波',
				'e' => '電氣',
				'd' => '爆炸',
			),
		),
		'svars' => Array(
			'ur' => 0,
			'ir' => 0,
			'pr' => 0,
			'er' => 0,
			'wr' => 0,
			'dr' => 0,
			'active_t' => 0,//技能发动次数
		),
		'lockdesc' => Array(
			'lvl' => '5級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">投系武器</span>時生效',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 5',
			'wepk+wep_kind' => "strpos([:wepk:],'C')!==false || strpos([:wepk:],'B')!==false || (!empty([:wep_kind:]) && ([:wep_kind:] == 'C' || [:wep_kind:] == 'B'))",
		),
	),
	'c3_potential' => Array
	(
		'name' => '潛能',
		'tags' => Array('battle'),
		'wepk' => Array('C'),
		'desc' => '本次攻擊必中且物理傷害<span class="yellow">+[:phydmgr:]%</span><br>
		持投系武器方可發動，消耗<span class="yellow">[:ragecost:]</span>點怒氣',
		'bdesc' => '攻擊必中且物理傷害<span class="yellow">+[:phydmgr:]%</span><br>消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 70,
			'phydmgr' => 20,
		),
		'lockdesc' => Array(
			'lvl' => '7級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">投系武器</span>時生效',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 7',
			'wepk+wep_kind' => "strpos([:wepk:],'C')!==false || strpos([:wepk:],'B')!==false || (!empty([:wep_kind:]) && ([:wep_kind:] == 'C' || [:wep_kind:] == 'B'))",
		),
	),
	'c3_hawkeye' => Array
	(
		'name' => '梟眼',
		'tags' => Array('passive'),
		'desc' => '如果你的武器射程不小於敵人，你對其先制攻擊率<span class="yellow">+[:actgain:]%</span>，<br>
		其攻擊你時命中率<span class="yellow">-[:accloss:]%</span>，連擊命中率懲罰<span class="yellow">+[:rbloss:]%</span>',
		'vars' => Array(
			'actgain' => 10,
			'accloss' => 12,
			'rbloss' => 8,
		),
		'lockdesc' => Array(
			'lvl' => '9級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">投系武器</span>時生效',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 9',
			'wepk+wep_kind' => "strpos([:wepk:],'C')!==false || strpos([:wepk:],'B')!==false || (!empty([:wep_kind:]) && ([:wep_kind:] == 'C' || [:wep_kind:] == 'B'))",
		),
	),
	'c3_offset' => Array
	(
		'name' => '對撞',
		'tags' => Array('switch'),
		'desc' => '持投系武器時，你有<span class="yellow">(<span tooltip="取決於你的投系熟練度">[^wc^]</span>×[:chancegainr:])%</span>的幾率(<span class="yellow">上限[:maxchance:]%</span>)，<br>
		在受到傷害時抵擋<span class="yellow">(武器效果值的平方根×[:wepeffectr:])</span>點傷害(<span class="yellow">上限[:maxeffect:]點</span>)。<br>
		成功抵擋傷害時，會使武器效果降低<span class="red">[:wepsloss:]%</span><br>
		點擊右側的<span class="yellow">“切換”</span>按鍵可以隨時激活或禁用該技能。<br>
		[^skill-active^]',
		'input' => '切換',
		'log' => '<span class="yellow">切換了「對撞」的狀態。</span>',
		'events' => Array('active|c3_offset'),
		'vars' => Array(
			'maxeffect' => 3000,
			'wepeffectr' => 10,
			'wepsloss' => 3,
			'minchance' => 0,
			'maxchance' => 70,
			'chancegainr' => 0.1,
		),
		'svars' => Array(
			'active' => 1,
		),
		'pvars' => Array('wc','skill-active'),
		'lockdesc' => Array(
			'lvl' => '13級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">投系武器</span>時生效',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 13',
			'wepk+wep_kind' => "strpos([:wepk:],'C')!==false || strpos([:wepk:],'B')!==false || (!empty([:wep_kind:]) && ([:wep_kind:] == 'C' || [:wep_kind:] == 'B'))",
		),
	),
	'c3_numerous' => Array
	(
		'name' => '百出',
		'tags' => Array('passive'),
		'desc' => '持投系武器時物理傷害<span class="yellow b">+([:dmgr:]×[^skillpara|c3_enchant-active_t^])%</span><br>
		其中<span class="yellow">×</span>後的數值是你發動<span class="yellow">“附魔”</span>的次數<br>',
		'vars' => Array(
			'dmgr' => 2,
		),
		'pvars' => Array('skillpara|c3_enchant-active_t'),
		'lockdesc' => Array(
			'skillpara|c3_enchant-ur+skillpara|c3_enchant-ir+skillpara|c3_enchant-pr+skillpara|c3_enchant-er+skillpara|c3_enchant-wr+skillpara|c3_enchant-dr' => '“附魔”中最高的屬性傷害加成達到120%時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">投系武器</span>時生效',
		),
		//……
		'unlock' => Array(
			'skillpara|c3_enchant-ur+skillpara|c3_enchant-ir+skillpara|c3_enchant-pr+skillpara|c3_enchant-er+skillpara|c3_enchant-wr+skillpara|c3_enchant-dr' => '[:skillpara|c3_enchant-ur:] >= 120 || [:skillpara|c3_enchant-ir:] >= 120 || [:skillpara|c3_enchant-er:] >= 120 || [:skillpara|c3_enchant-wr:] >= 120 || [:skillpara|c3_enchant-pr:] >= 120 || [:skillpara|c3_enchant-dr:] >= 120',
			'wepk+wep_kind' => "strpos([:wepk:],'C')!==false || strpos([:wepk:],'B')!==false || (!empty([:wep_kind:]) && ([:wep_kind:] == 'C' || [:wep_kind:] == 'B'))",
		),
	),
	'c4_stable' => Array
	(
		'name' => '靜息',
		'tags' => Array('passive'),
		'desc' => '持射系武器時，你的命中率<span class="yellow">+[:accgain:]%</span>，連擊命中率懲罰降低<span class="yellow">[:rbgain:]%</span><br>',
		'maxlvl' => 6,
		'cost' => Array(2,2,3,3,4,5,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「靜息」升級成功。</span><br>',
		'status' => Array('skillpara|c4_stable-lvl','skillpara|c4_stable-costcount'),
		'effect' => Array(
			0 => Array(
				'skillpara|c4_stable-lvl' => '+=::1',
				'skillpara|c4_stable-costcount' => Array('=::2','=::4','=::7','=::10','=::14','=::19','=::19'),
			),
		),
		'svars' => Array(
			'lvl' => 0, //初次获得时等级为0
			'costcount' => 0, //初次获得时花费点数为0
		),
		'vars' => Array(
			'accgain' => Array(0,2,4,6,8,10,12), //命中增益
			'rbgain' => Array(0,2,4,6,8,10,12), //连击命中惩罚降低
		),
		'lockdesc' => Array(
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">射系武器</span>或<span class="yellow">重型槍械</span>時生效',
			'weps' => '武器彈藥不足，無法發動',
		),
		'unlock' => Array(
			'wepk+wep_kind' => "strpos([:wepk:],'G')!==false || strpos([:wepk:],'J')!==false || (!empty([:wep_kind:]) && ([:wep_kind:] == 'G' || [:wep_kind:] == 'J' ))",
			'weps' => "[:weps:] != '∞'",
		),
	),
	'c4_break' => Array
	(
		'name' => '破甲',
		'tags' => Array('passive'),
		'desc' => '持射系武器時，你的攻擊致傷率<span class="yellow">[:infrgain:]</span>，造成的防具損壞效果<span class="yellow">+[:inftfix:]</span><br>
		戰鬥中每造成敵人一處受傷，最終傷害增加<span class="yellow">[:infdmgr:]%</span>',
		'maxlvl' => 3,
		'cost' => Array(6,6,7,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「破甲」升級成功。</span><br>',
		'status' => Array('skillpara|c4_break-lvl','skillpara|c4_break-costcount'),
		'effect' => Array(
			0 => Array(
				'skillpara|c4_break-lvl' => '+=::1',
				'skillpara|c4_break-costcount' => Array('=::6','=::12','=::19','=::19'),
			),
		),
		'svars' => Array(
			'lvl' => 0, //初次获得时等级为0
			'costcount' => 0, //初次获得时花费点数为0
		),
		'vars' => Array(
			'infrgain' => Array(0,50,100,150), //致伤率提高
			'inftfix' => Array(0,1,2,4), //额外耐久削减
			'infdmgr' => Array(0,10,20,30), //每处致伤提高最终伤害
		),
		'lockdesc' => Array(
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">射系武器</span>或<span class="yellow">重型槍械</span>時生效',
			'weps' => '武器彈藥不足，無法發動',
		),
		'unlock' => Array(
			'wepk+wep_kind' => "strpos([:wepk:],'G')!==false || strpos([:wepk:],'J')!==false || (!empty([:wep_kind:]) && ([:wep_kind:] == 'G' || [:wep_kind:] == 'J' ))",
			'weps' => "[:weps:] != '∞'",
		),
	),
	'c4_aiming' => Array
	(
		'name' => '瞄準',
		'tags' => Array('battle'),
		'wepk' => Array('G','J'),
		'desc' => '本次攻擊物理傷害<span class="yellow">+[:phydmgr:]</span>，命中率<span class="yellow">+[:accgain:]%</span><br>
		使用射系武器方可發動，消耗<span class="yellow">[:ragecost:]</span>點怒氣',
		'bdesc' => '本次攻擊物理傷害<span class="yellow">+[:phydmgr:]%</span>，<br>命中率<span class="yellow">+[:accgain:]%</span><br>
		消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 20,
			'accgain' => 15, //命中增益
			'phydmgr' => 20, //物理伤害加成
		),
		'lockdesc' => Array(
			'lvl' => '3級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">射系武器</span>或<span class="yellow">重型槍械</span>時生效',
			'weps' => '武器彈藥不足，無法發動',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 3',
			'wepk+wep_kind' => "strpos([:wepk:],'G')!==false || strpos([:wepk:],'J')!==false || (!empty([:wep_kind:]) && ([:wep_kind:] == 'G' || [:wep_kind:] == 'J' ))",
			'weps' => "[:weps:] != '∞'",
		),
	),
	'c4_loot' => Array
	(
		'name' => '掠奪',
		'tags' => Array('passive'),
		'desc' => '當你在戰鬥中擊殺敵人時，你立即獲得<span class="yellow">(<span tooltip="基於你目前的等級">[^lvl^]</span>×[:goldr:])</span>點金錢。',
		'vars' => Array(
			'goldr' => 2,
		),
		'pvars' => Array('lvl'),
		'lockdesc' => Array(
			'lvl' => '8級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 8',
		),
	),
	'c4_roar' => Array
	(
		'name' => '咆哮',
		'tags' => Array('battle','unlock_battle_hidden'),
		'wepk' => Array('G','J'),
		'desc' => '本次攻擊物理傷害<span class="yellow">+[:phydmgr:]%</span>，屬性傷害<span class="yellow">+[:exdmgr:]%</span>，<br>
		防具損壞效果<span class="yellow">+[:inftfix:]</span>。使用射系武器方可發動，消耗<span class="yellow">[:ragecost:]</span>點怒氣',
		'bdesc' => '物理傷害<span class="yellow">+[:phydmgr:]%</span>，屬性傷害<span class="yellow">+[:exdmgr:]%</span>，
		防具損壞效果<span class="yellow">+[:inftfix:]</span>。消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 75,
			'inftfix' => 2,
			'phydmgr' => 20, //物理伤害加成
			'exdmgr' => 80, //属性伤害加成
			'disableskill' => 'c4_sniper',
		),
		'lockdesc' => Array(
			'skillpara|c4_roar-disable' => '已無法使用該技能！',
			'skillpara|c4_roar-active' => '點擊「解鎖」獲得此技能，之後將無法使用技能「穿楊」<br>',
			'lvl' => '已解鎖，15級後可用',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">射系武器</span>或<span class="yellow">重型槍械</span>時生效',
			'weps' => '武器彈藥不足，無法發動',
		),
		'unlock' => Array(
			'skillpara|c4_roar-disable' => 'empty([:skillpara|c4_roar-disable:])',
			'skillpara|c4_roar-active' => '!empty([:skillpara|c4_roar-active:])',
			'lvl' => '[:lvl:] >= 15',
			'wepk+wep_kind' => "strpos([:wepk:],'G')!==false || strpos([:wepk:],'J')!==false || (!empty([:wep_kind:]) && ([:wep_kind:] == 'G' || [:wep_kind:] == 'J' ))",
			'weps' => "[:weps:] != '∞'",
		),
	),
	'c4_sniper' => Array
	(
		'name' => '穿楊',
		'tags' => Array('battle','unlock_battle_hidden'),
		'wepk' => Array('G','J'),
		'desc' => '物理傷害<span class="yellow">+[:phydmgr:]%</span>，命中率<span class="yellow">+[:accgain:]%</span>，射程<span class="yellow">+[:rangegain:]</span>，<span class="yellow">連擊</span>無效，<br>
		但<span class="yellow">[:prfix:]%概率貫穿</span>。使用遠程武器/重型槍械方可發動，消耗<span class="yellow">[:ragecost:]</span>點怒氣',
		'bdesc' => '物理傷害<span class="yellow">+[:phydmgr:]%</span>，命中率<span class="yellow">+[:accgain:]%</span>，射程<span class="yellow">+[:rangegain:]</span>，<span class="yellow">連擊</span>無效，
		但<span class="yellow">[:prfix:]%概率貫穿</span>。消耗<span class="yellow">[:ragecost:]</span>點怒氣',
		'vars' => Array(
			'ragecost' => 95,
			'rangegain' => 1,
			'phydmgr' => 80, //物理伤害加成
			'accgain' => 20, //命中率加成
			'prfix' => 90, //贯穿触发率定值
			'disableskill' => 'c4_roar',
		),
		'lockdesc' => Array(
			'skillpara|c4_sniper-disable' => '已無法使用該技能！',
			'skillpara|c4_sniper-active' => "點擊「解鎖」獲得此技能，之後將無法使用技能「咆哮」<br>",
			'lvl' => '已解鎖，15級後可用',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">射系武器</span>或<span class="yellow">重型槍械</span>時生效',
			'weps' => '武器彈藥不足，無法發動',
		),
		'unlock' => Array(
			'skillpara|c4_sniper-disable' => 'empty([:skillpara|c4_sniper-disable:])',
			'skillpara|c4_sniper-active' => '!empty([:skillpara|c4_sniper-active:])',
			'lvl' => '[:lvl:] >= 15',
			'wepk+wep_kind' => "strpos([:wepk:],'G')!==false || strpos([:wepk:],'J')!==false || (!empty([:wep_kind:]) && ([:wep_kind:] == 'G' || [:wep_kind:] == 'J' ))",
			'weps' => "[:weps:] != '∞'",
		),
	),
	'c4_headshot' => Array
	(
		'name' => '爆頭',
		'tags' => Array('passive'),
		'desc' => '使用射系武器造成超過<span class="yellow">[:killline:]%</span>目標當前生命值的傷害時，自動將其秒殺',
		'vars' => Array(
			'killline' => 85,
		),
		'lockdesc' => Array(
			'lvl' => '15級時解鎖',
			'skillpara|c4_stable-costcount+skillpara|c4_break-costcount' => '在「靜息」和「破甲」上共計花費至少15技能點以解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">射系武器</span>或<span class="yellow">重型槍械</span>時生效',
			'weps' => '武器彈藥不足，無法發動',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 15',
			'skillpara|c4_stable-costcount+skillpara|c4_break-costcount' => '[:skillpara|c4_stable-costcount:]+[:skillpara|c4_break-costcount:] >= 15',
			'wepk+wep_kind' => "strpos([:wepk:],'G')!==false || strpos([:wepk:],'J')!==false || (!empty([:wep_kind:]) && ([:wep_kind:] == 'G' || [:wep_kind:] == 'J' ))",
			'weps' => "[:weps:] != '∞'",
		),
	),
	'c5_sneak' => Array
	(
		'name' => '潛行',
		'tags' => Array('passive'),
		'desc' => '你的隱蔽率提高<span class="yellow">[:hidegain:]%</span>，主動攻擊時先攻率提高<span class="yellow">[:actgain:]%</span>',
		'maxlvl' => 5,
		'cost' => Array(2,3,3,4,4,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「潛行」升級成功。</span><br>',
		'status' => Array('skillpara|c5_sneak-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c5_sneak-lvl' => '+=::1',),
		),
		'svars' => Array('lvl' => 0),
		'vars' => Array(
			'hidegain' => Array(0,2,4,6,8,10),
			'actgain' => Array(0,2,4,6,8,10),
		),
	),
	'c5_caution' => Array
	(
		'name' => '謹慎',
		'tags' => Array('passive'),
		'desc' => '你的陷阱迴避率提高<span class="yellow">[:evgain:]%</span>，陷阱重複使用率提高<span class="yellow">[:reugain:]%</span>',
		'maxlvl' => 5,
		'cost' => Array(2,2,2,3,3,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「謹慎」升級成功。</span><br>',
		'status' => Array('skillpara|c5_caution-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c5_caution-lvl' => '+=::1',),
		),
		'svars' => Array('lvl' => 0),
		'vars' => Array(
			'evgain' => Array(0,2,4,6,8,10),
			'reugain' => Array(0,4,8,12,16,20),
		),
	),
	'c5_review' => Array
	(
		'name' => '反思',
		'tags' => Array('passive'),
		'desc' => "使用爆系武器時，<br>即使攻擊沒有命中，也可以獲得[:expgain:]點固定經驗值",
		'vars' => Array(
			'expgain' => 1,
		),
		'lockdesc' => Array(
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">爆系武器</span>時生效',
		),
		'unlock' => Array(
			'wepk+wep_kind' => "strpos([:wepk:],'D')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'D')",
		),
	),
	'c5_focus' => Array
	(
		'name' => '專注',
		'tags' => Array('passive'),
		'desc' => "你可隨意於下列三個狀態間切換：",
		'clog' => "切換了「專注」的狀態。",
		'choice' => Array(0,1,2), //无效果/重视遇敌/重视探物
		'svars' => Array(
			'choice' => 1,
		),
		'vars' => Array(
			'meetgain' => 15,
			'itmgain' => 15,
		),
		'lockdesc' => Array(
			'lvl' => '3級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 3',
		),
	),
	'c5_higheg' => Array
	(
		'name' => '高能',
		'tags' => Array('battle'),
		'wepk' => Array('D'),
		'desc' => '本次攻擊中爆炸屬性傷害無視一切增益減益效果，<br>
		使用爆系武器方可發動，消耗<span class="yellow">[:ragecost:]</span>點怒氣。',
		'bdesc' => '本次攻擊中爆炸屬性傷害無視一切增益減益效果；消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 40,
		),
		'lockdesc' => Array(
			'lvl' => '6級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">爆系武器</span>時生效',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 6',
			'wepk+wep_kind' => "strpos([:wepk:],'D')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'D')",
		),
	),
	'c5_double' => Array
	(
		'name' => '雙響',
		'tags' => Array('battle','limit'),
		'wepk' => Array('D'),
		'desc' => '本局已發動<span class="redseed"> [^skillpara|c5_double-active_t^]/[:maxactive_t:] </span>次<br>使用爆系武器方可發動，'.$sktrapidatk.'[:chase_t:]次。',
		'bdesc' => '本次戰鬥你將'.$sktrapidatk.'[:chase_t:]次；本局已發動<span class="redseed">[^skillpara|c5_double-active_t^]/[:maxactive_t:]</span>次',
		'svars' => Array(
			'active_t' => 0,
		),
		'vars' => Array(
			'ragecost' => 0,
			'chase_t' => 2,
			'maxactive_t' => 2,
		),
		'pvars' => Array(
			'skillpara|c5_double-active_t',
		),
		'lockdesc' => Array(
			'skillpara|c5_double-active_t' => '次數耗盡，已無法發動該技能',
			'lvl' => '19級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">爆系武器</span>時生效',
		),
		'unlock' => Array(
			'skillpara|c5_double-active_t' => '[:skillpara|c5_double-active_t:] < 2',
			'lvl' => '[:lvl:] >= 19',
			'wepk+wep_kind' => "strpos([:wepk:],'D')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'D')",
		),
	),
	'c9_kotodama' => Array
	(
		'name' => '言靈', //未完成
		'tags' => Array('passive'),
		'desc' => '使用靈力武器主動攻擊敵人時，可通過喊話觸發特殊效果<br>
		升級該技能可解鎖更多觸發關鍵詞，以下是目前可觸發的關鍵詞：',
		'maxlvl' => 3,
		'cost' => Array(3,3,4,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「言靈」升級成功。</span>',
		'status' => Array('skillpara|c9_kotodama-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c9_kotodama-lvl' => '+=::1'),
		),
		'svars' => Array(
			'lvl' => 0,
		),
		'vars' => Array(
		),
	),
	'c9_spirit' => Array
	(
		'name' => '靈力',
		'tags' => Array('passive'),
		'desc' => '敵人攻擊你時，其命中率降低<span class="yellow">[:accloss:]%</span>，連擊命中率懲罰<span class="yellow">+[:rbloss:]%</span><br>
		你使用靈系武器的體力消耗降低<span class="yellow">[:spcloss:]%</span>',
		'maxlvl' => 3,
		'cost' => Array(3,3,4,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「靈力」升級成功。</span>',
		'status' => Array('skillpara|c9_spirit-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c9_spirit-lvl' => '+=::1'),
		),
		'svars' => Array(
			'lvl' => 0, //初次获得时等级为0
		),
		'vars' => Array(
			'accloss' => Array(0,4,8,12),
			'rbloss' => Array(0,2,3,4),
			'spcloss' => Array(40,50,60,70),
		),
	),
	'c9_lb' => Array
	(
		'name' => '必殺',
		'tags' => Array('battle'),
		'desc' => '本次攻擊造成物理傷害<span class="yellow">×[:phydmgr:]</span><br>
		消耗<span class="yellow">[:ragecost:]</span>點怒氣，若擁有<span class="yellow">重擊輔助</span>屬性會額外返還<span class="yellow">[:rageback:]</span>點怒氣',
		'bdesc' => '本次攻擊物理傷害<span class="yellow">×[:phydmgr:]</span>，消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 40,
			'rageback' => 6,
			'phydmgr' => 2,
		),
		'lockdesc' => Array(
			'lvl' => '3級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 3',
		),
	),
	'c9_iceheart' => Array
	(
		'name' => '冰心',
		'tags' => Array('passive'),
		'desc' => '使用靈力武器攻擊時，你受到的反噬傷害降低<span class="yellow">[:hpshloss:]%</span><br>
		受到傷害時，即刻解除<span class="yellow">[:purify:]</span>個異常/受傷狀態。<br>
		每通過技能解除1個異常/受傷狀態，你的怒氣提升<span class="yellow">[:ragegain:]</span>點',
		'vars' => Array(
			'hpshloss' => 80,
			'purify' => 1,
			'ragegain' => 40,
		),
		'lockdesc' => Array(
			'lvl' => '7級時解鎖',
			'wepk+wep_kind' => '武器不適用，持<span class="yellow">靈力武器</span>時生效',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 7',
			'wepk+wep_kind' => "strpos([:wepk:],'F')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'F')",
		),
	),
	'c9_charge' => Array
	(
		'name' => '充能',
		'tags' => Array('active'),
		'desc' => '發動後立即增加<span class="yellow">[:rageadd:]</span>點怒氣。<br>
		前<span class="yellow">[:freet:]</span>次發動沒有冷卻時間，之後每次發動冷卻時間<span class="clan">[:cd:]</span>秒<br>
		本局已發動：<span class="redseed"> [^skillpara|c9_charge-active_t^] </span>次',
		'input' => '發動',
		'log' => '<span class="lime">技能「充能」發動成功。</span><br>',
		'events' => Array('charge','active_news'),
		'status' => Array('skillpara|c9_charge-active_t'),
		'effect' => Array(
			0 => Array('skillpara|c9_charge-active_t' => '+=::1'),
		),
		'svars' => Array(
			'active_t' => 0,
		),
		'vars' => Array(
			'rageadd' => 100,
			'freet' => 2,
			'cd' => 600, //冷却时间
		),
		'pvars' => Array(
			'skillpara|c9_charge-active_t',
		),
		'lockdesc' => Array(
			'lvl' => '11級時解鎖',
			'skillcooldown' => '技能冷卻中！<br>剩餘冷卻時間：<span class="red">[:cd:]</span> 秒',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 11',
			'skillcooldown' => 0,
		),
	),
	'c9_heartfire' => Array
	(
		'name' => '心火',
		'tags' => Array('battle'),
		'desc' => '本次攻擊造成的最終傷害<span class="yellow">×[:findmgr:]</span>。消耗<span class="yellow">[:ragecost:]</span>點怒氣<br>',
		'bdesc' => '本次攻擊最終傷害<span class="yellow">×[:findmgr:]</span>，消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 60,
			'findmgr' => 2,
		),
		'lockdesc' => Array(
			'lvl' => '19級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 19',
		),
	),
	'c6_godluck' => Array
	(
		'name' => '天運',
		'tags' => Array('passive'),
		'desc' => '升級後隨機提升以下兩類屬性中任一項<span class="yellow">[:flucmin:]~[:flucmax:]%</span><br>
		<span class="grey">(1)閃避率 +[^skillpara|c6_godluck-accloss^]%；敵人連擊命中率 -[^skillpara|c6_godluck-rbloss^]%<br>
		(2)命中率 +[^skillpara|c6_godluck-accgain^]%；連擊命中率 +[^skillpara|c6_godluck-rbgain^]%</span>',
		'maxlvl' => 10,
		'cost' => Array(1,1,2,2,2,3,3,3,4,4,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「天運」升級成功。</span><br>',
		'events' => Array('c6_godluck'),
		'status' => Array('skillpara|c6_godluck-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c6_godluck-lvl' => '+=::1',),
		),
		'svars' => Array(
			'lvl' => 0,
			'accgain' => 0, 'rbgain' => 0, 'accloss' => 0, 'rbloss' => 0,
		),
		'vars' => Array(
			'flucmin' => 1,
			'flucmax' => 3,
		),
		'pvars' => Array('skillpara|c6_godluck-accgain','skillpara|c6_godluck-rbgain','skillpara|c6_godluck-accloss','skillpara|c6_godluck-rbloss'),
	),
	'c6_godsend' => Array
	(
		'name' => '天助',
		'tags' => Array('passive'),
		'desc' => '升級後隨機提升以下兩類屬性中的任一項<span class="yellow">[:flucmin:]~[:flucmax:]%</span><br>
		<span class="grey">(1)隱蔽率 +[^skillpara|c6_godsend-hidegain^]%；先攻率 +[^skillpara|c6_godsend-actgain^]%<br>
		(2)反擊率 +[^skillpara|c6_godsend-countergain^]% </span>',
		'maxlvl' => 10,
		'cost' => Array(2,2,2,2,2,4,4,4,4,4,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「天助」升級成功。</span><br>',
		'events' => Array('c6_godsend'),
		'status' => Array('skillpara|c6_godsend-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c6_godsend-lvl' => '+=::1',),
		),
		'svars' => Array(
			'lvl' => 0,
			'actgain' => 0, 'countergain' => 0, 'hidegain' => 0,
		),
		'vars' => Array(
			'flucmin' => 1,
			'flucmax' => 3,
		),
		'pvars' => Array('skillpara|c6_godsend-actgain','skillpara|c6_godsend-countergain','skillpara|c6_godsend-hidegain'),
	),
	'c6_godbless' => Array
	(
		'name' => '天佑',
		'tags' => Array('passive'),
		'desc' => '如果你受到不低於<span class="yellow">[:actmhp:]%</span>最大生命值的戰鬥或陷阱傷害<br>
		但存活，之後的<span class="yellow">[:lasttimes:]</span>秒內你免疫一切戰鬥和陷阱傷害
		<span tooltip="無效NPC：紅殺將軍、紅殺菁英、英雄、武神、天神、巫師、使徒、■■"><a>（對部分NPC無效）</a></span><br>',
		'link' => Array('buff_godbless'),
		'vars' => Array(
			'actmhp' => 35,
			'lasttimes' => 5,
		),
	),
	'buff_godbless' => Array
	(
		'name' => '[狀態]天佑',
		'tags' => Array('buff'),
		'desc' => '<span class="lime">「天佑」生效中！<br>
		增益效果剩餘時間：<span class="yellow">[^lasttimes^]</span>秒</span>',
		'vars' => Array(
			'no_type' => Array(1,9,20,21,22,23,24,88),//无效NPC
		),
		'slast' => Array(
			'lasttimes' => 30, //真正作用的持续时间
		),
		'pvars' => Array('lasttimes'),
	),
	'c6_godpow' => Array
	(
		'name' => '天威',
		'tags' => Array('battle'),
		'desc' => '計算武器熟練度時額外增加<span class="yellow"><span tooltip="(怒氣×等級/6)">([^rage^]×[^lvl^]/6)</span></span>點<br>
		(最高[:skmax:]點)，發動消耗<span class="yellow">[:ragecost:]</span>點怒氣<br>
		若擊殺敵人且傷害不超過其生命值[:mhpr:]倍，則返還<span class="yellow">[:rageback:]</span>點怒氣',
		'bdesc' => '計算熟練度時增加<span class="yellow">([^rage^]×[^lvl^]/6)</span>點(最高220點)，消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 25,
			'rageback' => 25,
			'skmax' => 220,
			'mhpr' => 1.5,
		),
		'pvars' => Array('rage','lvl'),
		'lockdesc' => Array(
			'lvl' => '5級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 5',
		),
	),
	'c6_godeyes' => Array
	(
		'name' => '天眼',
		'tags' => Array('passive'),
		'desc' => '在戰鬥界面你可以查看到對手的具體數值信息<br>
		且無視天氣影響',
		'lockdesc' => Array(
			'lvl' => '7級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 7',
		),
	),
	'c6_justice' => Array
	(
		'name' => '天義',
		'tags' => Array('passive'),
		'desc' => '你的武器視為具有<span class="yellow">衝擊屬性</span><br>
		敵人物理傷害防禦類屬性與物理抹消屬性失效幾率<span class="yellow">×[:pdefbkr:]</span>',
		'vars' => Array(
			'pdefbkr' => '3',
		),
		'lockdesc' => Array(
			'lvl' => '15級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 15',
		),
	),
	'c7_radar' => Array
	(
		'name' => '探測',
		'desc' => '消耗<span class="lime">1</span>技能點，進行一次廣域探測',
		'cost' => 1,
		'input' => '探測',
		'no_reload_page' => 1,
		'log' => '消耗了<span class="lime">[:cost:]</span>技能點，激活了廣域探測功能。<br>',
		'events' => Array('radar'),
	),
	'c7_shield' => Array
	(
		'name' => '護盾',
		'tags' => Array('passive'),
		'desc' => "進入戰鬥時，若生命值低於<span class='yellow'>[:hpalert:]%</span>，生成一個擁有<span class='yellow'>[:svar:]</span>點效果的$sktpshield<br>
		護盾值耗盡後，需要等待<span class='clan'>[:cd:]</span>秒才能重新激活。",
		'maxlvl' => 5,
		'cost' => Array(4,4,5,7,9,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「護盾」升級成功。</span><br>',
		'status' => Array('skillpara|c7_shield-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c7_shield-lvl' => '+=::1',),
		),
		'svars' => Array(
			'lvl' => 0,
			'accgain' => 0, 'rbgain' => 0, 'accloss' => 0, 'rbloss' => 0,
		),
		'vars' => Array(
			'svar' => Array(110,155,185,225,265,355),
			'cd' => Array(150,120,120,90,60,45),
			'hpalert' => Array(35,40,45,50,60,70),
		),
		'lockdesc' => Array(
			'skillpara|buff_shield-svar' => '護盾已存在，無法重複生成！',
			'skillcooldown' => '護盾充能中！<br>充能所需時間：<span class="red">[:cd:]</span> 秒',
		),
		'unlock' => Array(
			'skillpara|buff_shield-svar' => 'empty([:skillpara|buff_shield-svar:])',
			'skillcooldown' => 0,
		),
	),
	'c7_electric' => Array
	(
		'name' => '磁暴',
		'tags' => Array('battle'),
		'desc' => '消耗<span class="yellow">[:ragecost:]</span>點怒氣，本次攻擊<span class="yellow">帶電</span>，電擊屬性傷害<span class="yellow">+[:exdmgfix:]</span>點，
		且有<span class="yellow">[:infr:]%</span>概率使敵人陷入<span class="yellow">麻痹</span>狀態。<br>
		若敵人已處於<span class="yellow">麻痹</span>狀態，則<span class="yellow">眩暈</span>敵人<span class="clan">[:lasttimes:]</span>秒',
		'bdesc' => '本次攻擊<span class="yellow">帶電</span>，電擊屬性傷害<span class="yellow">+[:exdmgfix:]</span>，有<span class="yellow">[:infr:]%</span>概率<span class="yellow">麻痹</span>敵人，或使已麻痹敵人眩暈<span class="yellow">[:lasttimes:]</span>秒；消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 25,
			'exdmgfix' => 60,
			'infr' => 40,
			'lasttimes' => 2,
		),
		'lockdesc' => Array(
			'lvl' => '3級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 3',
		),
	),
	'c7_field' => Array
	(
		'name' => '力場',
		'tags' => Array('active'),
		'desc' => "消耗<span class=\"lime\">[:cost:]</span>技能點，無視冷卻立刻激活一個$sktpshield",
		'cost' => 2,
		'input' => '激活',
		'log' => '<span class="yellow">「護盾」已激活！</span><br>',
		'events' => Array('getskill_buff_shield','setskillvars_buff_shield|c7_shield|svar','active_news'),
		'link' => Array('c7_shield'),
		'lockdesc' => Array(
			'lvl' => '5級時解鎖',
			'skillpara|buff_shield-svar' => '護盾已存在，無法重複生成！',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 5',
			'skillpara|buff_shield-svar' => 'empty([:skillpara|buff_shield-svar:])',
		),
	),
	'buff_shield' => Array
	(
		'name' => '[狀態]護盾',
		'tags' => Array('buff'),
		'desc' => '<span class="lime"><span class="gold" tooltip2="【護盾】：可抵消等同於護盾值的傷害。護盾值只在抵消屬性傷害時消耗，抵消電擊傷害時雙倍消耗。護盾存在時不會受到反噬傷害或陷入異常狀態。">護盾</span>生效中！<br>
		當前護盾值：<span class="yellow">[^skillpara|buff_shield-svar^]</span> 點</span>',
		'svars' => Array('svar' => 0),
		'pvars' => Array('skillpara|buff_shield-svar'),
		'lostevents' => Array('setstarttimes_c7_shield'),
	),
	'c7_overload' => Array
	(
		'name' => '過載',
		'tags' => Array('passive'),
		'desc' => '你造成的電擊傷害沒有上限',
		'lockdesc' => Array(
			'lvl' => '15級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 15',
		),
	),
	'c7_emp' => Array
	(
		'name' => '脈衝',
		'tags' => Array('battle','limit'),
		'desc' => '本局已發動<span class="redseed"> [^skillpara|c7_emp-active_t^]/[:maxactive_t:] </span>次<br>
		消耗<span class="yellow">[:ragecost:]</span>點怒氣，同時無效化你與敵人的<span class="yellow">抹消/制御類</span>屬性，<br>
		成功無效化時，使敵人進入<span class="yellow">麻痹</span>狀態。<br>
		若敵人已處於<span class="yellow">麻痹</span>狀態，則眩暈敵人<span class="clan">[:lasttimes:]</span>秒<br>',
		'bdesc' => '無效化雙方的<span class="yellow">抹消/制御類</span>屬性，並<span class="yellow">麻痹</span>敵人，或使已麻痹敵人眩暈<span class="yellow">[:lasttimes:]</span>秒；
		消耗<span class="red">[:ragecost:]</span>怒氣<br>本局已發動<span class="redseed"> [^skillpara|c7_emp-active_t^]/[:maxactive_t:] </span>次',
		'vars' => Array(
			'ragecost' => 60,
			'maxactive_t' => 2,
			'lasttimes' => 3,
		),
		'svars' => Array('active_t' => 0),
		'pvars' => Array('skillpara|c7_emp-active_t'),
		'lockdesc' => Array(
			'skillpara|c7_emp-active_t' => '次數耗盡，已無法發動該技能',
			'lvl' => '21級時解鎖',
		),
		'unlock' => Array(
			'skillpara|c7_emp-active_t' => '[:skillpara|c7_emp-active_t:] < 2',
			'lvl' => '[:lvl:] >= 21',
		),
	),
	'c8_expert' => Array
	(
		'name' => '特攻',
		'tags' => Array('passive'),
		'desc' => '你造成的最終屬性傷害提高<span class="yellow">[:exdmgr:]%</span>',
		'maxlvl' => 4,
		'cost' => Array(6,6,6,6,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「特攻」升級成功。</span><br>',
		'status' => Array('skillpara|c8_expert-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c8_expert-lvl' => '+=::1',),
		),
		'svars' => Array('lvl' => 0),
		'vars' => Array(
			'exdmgr' => Array(10,20,30,40,50),
		),
	),
	'c8_infilt' => Array
	(
		'name' => '滲透',
		'tags' => Array('passive'),
		'desc' => '當你處於<span class="purple">中毒</span>狀態時，攻擊額外附加<span class="yellow">[:exext:]</span>次毒屬性攻擊，<br>
		且有<span class="yellow">[:infr:]%</span>概率使敵人陷入<span class="purple">中毒</span>狀態，並使敵人包裹內的補給<span class="purple">帶毒</span>',
		'maxlvl' => 6,
		'cost' => Array(2,3,4,5,6,9,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「滲透」升級成功。</span><br>',
		'status' => Array('skillpara|c8_infilt-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c8_infilt-lvl' => '+=::1',),
		),
		'svars' => Array('lvl' => 0),
		'vars' => Array(
			'exext' => Array(1,1,1,2,2,2,3),
			'infr' => Array(0,10,20,30,40,50,60),
		),
		'lockdesc' => Array(
			'inf' => '自身處於<span class="purple">中毒</span>狀態時才可觸發',
		),
		'unlock' => Array(
			'inf' => "strpos([:inf:],'p')!==false",
		),
	),
	'c8_catalyst' => Array
	(
		'name' => '催化',
		'tags' => Array('battle'),
		'desc' => '消耗<span class="yellow">[:ragecost:]</span>點怒氣，<br>
		本次攻擊每造成1次毒屬性傷害，最終屬性傷害<span class="yellow">+[:exdmgr:]%</span>',
		'bdesc' => '本次攻擊每造成1次<span class="purple">毒</span>屬性傷害，最終屬性傷害<span class="yellow">+[:exdmgr:]%</span>；消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 50,
			'exdmgr' => 25,
		),
		'lockdesc' => Array(
			'lvl' => '7級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 7',
		),
	),
	'c8_deadheal' => Array
	(
		'name' => '死療',
		'tags' => Array('passive'),
		'desc' => '不再受到<span class="purple">毒性</span>傷害，並將原本傷害的<span class="yellow">[:exdmgr:]%</span>轉化為治療效果',
		'vars' => Array(
			'exdmgr' => 75,
		),
		'lockdesc' => Array(
			'lvl' => '12級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 12',
		),
	),
	'c8_assassin' => Array
	(
		'name' => '暗殺',
		'tags' => Array('active','limit'),
		'desc' => '本局已發動<span class="redseed"> [^skillpara|c8_assassin-active_t^]/[:maxactive_t:] </span>次<br>
		發動後獲得以下增益：隱蔽率<span class="yellow">+[:hidegain:]%</span>，先制率<span class="yellow">+[:actgain:]%</span>，持續<span class="yellow">60</span>秒；<br>
		增益持續時間內發動攻擊會解除增益，但使此次攻擊<span class="yellow">必中</span>，<br>
		且敵人防禦、抹消、制御類屬性失效(貫穿)率<span class="yellow">+[:pdefbkr:]%</span>',
		'input' => '發動',
		'log' => '<span class="lime">技能「暗殺」發動成功。</span><br>',
		'status' => Array('skillpara|c8_assassin-active','skillpara|c8_assassin-active_t'),
		'effect' => Array(
			0 => Array(
				'skillpara|c8_assassin-active' => '=::1',
				'skillpara|c8_assassin-active_t' => '+=::1',
			),
		),
		'events' => Array('getskill_buff_assassin','active_news'),
		'link' => Array('buff_assassin'),
		'vars' => Array(
			'maxactive_t' => 2,
		),
		'svars' => Array('active' => 0, 'active_t' => 0,),
		'pvars' => Array('skillpara|c8_assassin-active_t'),
		'lockdesc' => Array(
			'skillpara|c8_assassin-active_t' => '次數耗盡，已無法發動該技能',
			'lvl' => '21級時解鎖',
			'skillpara|c8_assassin-active' => '技能發動中！',
		),
		'unlock' => Array(
			'skillpara|c8_assassin-active_t' => '[:skillpara|c8_assassin-active_t:] < 2',
			'lvl' => '[:lvl:] >= 21',
			'skillpara|c8_assassin-active' => 'empty([:skillpara|c8_assassin-active:])',
		),
	),
	'buff_assassin' => Array
	(
		'name' => '[狀態]暗殺',
		'tags' => Array('buff'),
		'desc' => '<span class="lime">「暗殺」生效中！<br>
		增益效果剩餘時間：<span class="yellow">[^lasttimes^]</span> 秒</span>',
		'vars' => Array(
			'hidegain' => 90,
			'actgain' => 100,
			'pdefbkr' => 25,
		),
		'slast' => Array(
			'lasttimes' => 60,
		),
		'pvars' => Array('lasttimes'),
		'lostevents' => Array('unactive_c8_assassin'),
	),
	'c10_inspire' => Array
	(
		'name' => '靈感',
		'tags' => Array('active'),
		'desc' => "選定一個稱號，升級本技能時將<span class='yellow'>隨機</span>獲得一個選定稱號的<span class='yellow'>技能</span><br>
		（可能會重複獲得）<br>",
		'maxlvl' => 8,
		'cost' => Array(4,5,7,9,11,14,17,20,-1),
		'input' => '思考',
		'log' => '……<br>',
		'choice' => Array(1,2,3,4,5,6,7,8,9,12), //无效果/重视遇敌/重视探物
		'clog' => '<span class="yellow">切換了選定稱號。</span><br>',
		'events' => Array('inspire'),
		'status' => Array('skillpara|c10_inspire-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c10_inspire-lvl' => '+=::1',),
		),
		'svars' => Array(
			'lvl' => 0,
			'choice' => 1,
		),
	),
	'c10_insight' => Array
	(
		'name' => '洞察',
		'tags' => Array('passive'),
		'desc' => '敵人所用武器熟練度低於你的<span class="gold" tooltip2="你當前所持武器熟練度+(其他系別熟練度×0.25)">戰鬥熟練度</span>時，<br>
		你對其命中率<span class="yellow">+[:accgain:]%</span>；先制率<span class="yellow">+[:actgain:]%</span><br>
		敵人對你的命中率<span class="yellow">-[:accloss:]%</span>；連擊命中率<span class="yellow">-[:rbloss:]%</span>',
		'maxlvl' => 4,
		'cost' => Array(2,3,4,6,-1),
		'input' => '升級',
		'log' => '<span class="yellow">「洞察」升級成功。</span><br>',
		'status' => Array('skillpara|c10_insight-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c10_insight-lvl' => '+=::1',),
		),
		'svars' => Array('lvl' => 0),
		'vars' => Array(
			'accgain' => Array(5,7,10,17,30),
			'actgain' => Array(3,5,8,12,17),
			'accloss' => Array(3,6,11,15,17),
			'rbloss' => Array(4,7,14,18,22),
		),
	),
	'c10_decons' => Array
	(
		'name' => '解構',
		'tags' => Array('battle'),
		'desc' => '消耗<span class="yellow">[:ragecost:]</span>點怒氣，本次攻擊物理傷害<span class="yellow">+[:phydmgr:]%</span><br>
		擊殺敵人時，額外獲得<span class="lime">敵人等級-(0.15×<span tooltip2="等同於你當前等級">[^lvl^])</span></span>點經驗',
		'bdesc' => '物理傷害<span class="yellow">+[:phydmgr:]%</span>,擊殺時額外獲得<span class="lime">敵人等級-(0.15×<span tooltip2="等同於你當前等級">[^lvl^]</span>)</span>點經驗；消耗<span class="red">[:ragecost:]</span>怒氣',
		'vars' => Array(
			'ragecost' => 18,
			'phydmgr' => 20,
		),
		'pvars' => Array('lvl'),
		'lockdesc' => Array(
			'lvl' => '3級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 3',
		),
	),
	'c11_ebuy' => Array
	(
		'name' => '網購',
		'tags' => Array('passive'),
		'desc' => '你可以在任意地圖訪問商店',
	),
	'c11_tutor' => Array
	(
		'name' => '家教', //不太合适
		'tags' => Array('active'),
		'desc' => "通過培訓機構<span class='yellow'>隨機</span>學習一個<span class='yellow'>技能</span><br>
		（可能會重複獲得）",
		'input' => '學習',
		'log' => '……<br>',
		'events' => Array('inspire'),
	),
	'c11_merc' => Array
	(
		'name' => '傭兵',
		'tags' => Array('active','limit'),
		'desc' => "本局已發動<span class=\"redseed\"> [^skillpara|c11_merc-active_t^]/[:maxactive_t:] </span>次<br>
		消耗<span class='yellow'>[:mcost:]</span>元，在當前地點隨機召喚一名傭兵；<br>
		僱傭關係存在時，你可以指揮傭兵<span class='gold' tooltip2='遭遇敵人時，可花費一定金錢命令與你在同一地點的傭兵主動攻擊敵人，傭兵主動攻擊敵人後會【標記】敵人。【標記】在你或傭兵離開地圖前將一直存在，存在時可通過傭兵面板繼續對傭兵下達【追擊】指令。'>主動出擊</span>，
		或從旁<span class='gold' tooltip2='當你攻擊敵人且敵人未死亡時，與你在同一地點的傭兵有概率主動為你助戰，概率取決於傭兵與你的關係。'>協戰</span>；<br>
		被僱傭後，傭兵會在你累計探索/移動次數達<span class='yellow'>[:mst:]</span>次時要求結算一次工資<br>
		被拖欠工資的傭兵不會再為你服務(可能會暴力討薪)<br>",
		'input' => '僱傭',
		'no_reload_page' => 1,
		'log' => '……這是個啥呀！<br>',
		'status' => Array('skillpara|c11_merc-active_t'),
		'effect' => Array(
			0 => Array('skillpara|c11_merc-active_t' => '+=::1',),
		),
		'events' => Array('hiremerc','active_news'),
		'svars' => Array(
			'active_t' => 0,
		),
		'vars' => Array(
			'mcost' => 1500,
			'mst' => 25,
			'movep' => 2, //移动佣兵花费
			'atkp' => 10, //主动出击花费
			'maxactive_t' => 4,
		),
		'pvars' => Array(
			'lvl',
			'skillpara|c11_merc-active_t',
		),
		'lockdesc' => Array(
			'skillpara|c11_merc-active_t' => '次數耗盡，已無法再召喚傭兵',
			'money' => '招募傭兵至少需要1500元！',
		),
		'unlock' => Array(
			'skillpara|c11_merc-active_t' => '[:skillpara|c11_merc-active_t:] < 4',
			'money' => '[:money:] >= 1500',
		),
	),
	'c11_stock' => Array
	(
		'name' => '理財',
		'tags' => Array('passive'),
		'desc' => "每探索/移動<span class='yellow'>[:mst:]</span>次，你所持金錢增加<span class='yellow'>[:earn:]%</span>；<br>
		所加金錢數最低不會低於<span class='yellow'>[:minmoney:]</span>元，最高不會超過<span class='yellow'>[:maxmoney:]</span>元<br>
		<span class='grey'>當前已探索/移動次數：[^skillpara|c11_stock-ms^] 次</span>",
		'svars' => Array('ms' => 0),
		'vars' => Array(
			'mst' => 50,
			'earn' => 20,
			'minmoney' => 100,
			'maxmoney' => 2500,
		),
		'pvars' => Array('lvl','skillpara|c11_stock-ms'),
		'lockdesc' => Array(
			'lvl' => '7級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 7',
		),
	),
	'c11_renjie' => Array
	(
		'name' => '人傑',
		'tags' => Array('passive'),
		'desc' => "戰鬥中，你的熟練度始終取用最高熟練值。",
		'lockdesc' => Array(
			'lvl' => '19級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 19',
		),
	),
	'c12_huge' => Array
	(
		'name' => '矚目',
		'tags' => Array('passive'),
		'desc' => '你對敵人的隱蔽率<span class="yellow">-[:hidegain:]%</span>；敵人對你的隱蔽率<span class="yellow">-[:hideloss:]%</span>',
		'vars' => Array(
			'hidegain' => 100,
			'hideloss' => 75,
		),
	),
	'c12_enmity' => Array
	(
		'name' => '底力',
		'tags' => Array('passive'),
		'desc' => '當前生命值越低，你造成的最終傷害越高<br>
		最終傷害增幅：<span class="yellow">[:findmgr:]%</span>×<span class="gold" tooltip2="底力系數計算公式：(1+2×已損失生命百分比)×已損失生命百分比">底力系數</span>',
		'maxlvl' => 6,
		'cost' => Array(1,1,2,2,2,3,-1),
		'input' => '升級',
		'log' => '<span class="yellow">「底力」升級成功。</span><br>',
		'status' => Array('skillpara|c12_enmity-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c12_enmity-lvl' => '+=::1',),
		),
		'svars' => Array('lvl' => 0),
		'vars' => Array(
			'findmgr' => Array(10,15,20,25,35,45,55),
		),
	),
	'c12_garrison' => Array
	(
		'name' => '根性',
		'tags' => Array('passive'),
		'desc' => '當前生命值越低，基礎防禦力越高<br>
		基礎防禦力增幅：<span class="yellow">[:defgain:]%</span>×<span class="gold" tooltip2="根性係數計算公式：(-1×已損失生命百分比^3)+4×已損失生命百分比">根性係數</span>',
		'maxlvl' => 8,
		'cost' => Array(2,2,2,3,4,5,7,11,-1),
		'input' => '升級',
		'log' => '<span class="yellow">「底力」升級成功。</span><br>',
		'status' => Array('skillpara|c12_garrison-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c12_garrison-lvl' => '+=::1',),
		),
		'svars' => Array('lvl' => 0),
		'vars' => Array(
			'defgain' => Array(19,24,29,34,42,52,63,75,90),
		),
	),
	'c12_rage' => Array
	(
		'name' => '狂怒',
		'tags' => Array('battle'),
		'desc' => "消耗相當於<span class=\"red\">[:hpcost:]%</span>生命上限的生命值，<br>
		附加等於<span class=\"yellow\">所消耗生命值</span>且受<span class=\"yellow\">「底力」</span>加成的{$sktpwhitedmg}<br>
		發動需消耗<span class=\"yellow\">[:ragecost:]</span>點怒氣",
		'bdesc' => "消耗<span class=\"red\">[:hpcost:]%</span>生命值，附加等於消耗值且受<span class=\"yellow\">「底力」</span>加成的{$sktpwhitedmg}；發動需消耗<span class=\"red\">[:ragecost:]</span>怒氣",
		'vars' => Array(
			'ragecost' => 50,
			'hpcost' => 25,
		),
		'lockdesc' => Array(
			'lvl' => '7級時解鎖',
			'hp+mhp' => '生命值在<span class="red">25%</span>以上時可發動',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 7',
			'hp+mhp' => '[:hp:] > [:mhp:]*0.25',
		),
	),
	'c12_bloody' => Array
	(
		'name' => '浴血',
		'tags' => Array('passive'),
		'desc' => '在生命值低於<span class="yellow">75%/50%/30%</span>生命上限的情況下，<br>
		擊殺敵人增加<span class="yellow">2/3/11</span>點基礎攻擊與<span class="yellow">4/5/15</span>點基礎防禦',
		'vars' => Array(
			'hplimit' => Array(75,50,30),
			'attgain' => Array(2,3,11),
			'defgain' => Array(4,5,15),
		),
		'lockdesc' => Array(
			'lvl' => '13級時解鎖',
			'hp+mhp' => '生命值低於<span class="red">75%</span>時可觸發',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 13',
			'hp+mhp' => '[:hp:] <= [:mhp:]*0.75',
		),
	),
	'c12_swell' => Array
	(
		'name' => '海虎',
		'tags' => Array('passive'),
		'desc' => '在生命值低於<span class="yellow">50%/30%</span>生命上限的情況下，<br>
		有<span class="yellow">[:swellr:]%×</span><span class="gold" tooltip2="底力系數計算公式：(1+2×已損失生命百分比)×已損失生命百分比">底力系數</span>概率造成<span class="yellow">2/3</span>次'.$sktrapidatk.'',
		'vars' => Array(
			'swellr' => 19,
		),
		'lockdesc' => Array(
			'lvl' => '21級時解鎖',
			'hp+mhp' => '生命值低於<span class="red">50%</span>時可觸發',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 21',
			'hp+mhp' => '[:hp:] <= [:mhp:]*0.5',
		),
	),
	'c13_kungfu' => Array
	(
		'name' => '拳法',
		'tags' => Array('passive'),
		'desc' => '空手作戰時，相當於持有等同於毆系熟練度數值的武器<br>
		攻擊時有<span class="yellow">35%/15%/5%/3%</span>的幾率額外獲得<span class="yellow">1/2/3/4</span>點熟練<br>',
		'lockdesc' => Array(
			'wepk+wep_kind' => "空手時可發動",
		),
		'unlock' => Array(
			'wepk+wep_kind' => "strpos([:wepk:],'N')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'N')",
		),
	),
	'c13_master' => Array
	(
		'name' => '宗師',
		'tags' => Array('passive'),
		'desc' => '手持武器時造成的物理傷害減少<span class="red">[:phydmgloss:]%</span>；<br>
		若武器是帶“拳”字的鈍器則減少<span class="red">[:phydmgloss_2:]%</span>；<br>
		你不能再埋設陷阱，且從陷阱處受到的傷害減少<span class="yellow">[:trapdmgloss:]%</span><br>',
		'vars' => Array
		(
			'phydmgloss' => 90,
			'phydmgloss_2' => 50,
			'trapdmgloss' => 60,
		),
	),
	'c13_quick' => Array
	(
		'name' => '快拳',
		'tags' => Array('passive'),
		'desc' => '空手戰鬥時有<span class="yellow">[:rapidr:]%</span>概率'.$sktrapidatk.'2次',
		'maxlvl' => 4,
		'cost' => Array(3,3,4,4,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「快拳」升級成功。</span><br>',
		'status' => Array('skillpara|c13_quick-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c13_quick-lvl' => '+=::1',),
		),
		'svars' => Array('lvl' => 0),
		'vars' => Array(
			'rapidr' => Array(10,15,20,25,30),
		),
		'lockdesc' => Array(
			'wepk+wep_kind' => "空手時可發動",
		),
		'unlock' => Array(
			'wepk+wep_kind' => "strpos([:wepk:],'N')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'N')",
		),
	),
	'c13_wingchun' => Array
	(
		'name' => '亂擊',
		'tags' => Array('battle'),
		'maxlvl' => 2,
		'cost' => Array(6,9,-1),
		'input' => '升級',
		'log' => '<span class="yellow">技能「亂擊」升級成功。</span><br>',
		'status' => Array('skillpara|c13_wingchun-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c13_wingchun-lvl' => '+=::1',),
		),
		'svars' => Array('lvl' => 0),
		'desc' => "空手時可發動，消耗<span class=\"yellow\">[:ragecost:]</span>點怒氣；<br>
		本次攻擊附加<span class=\"yellow\">[:ragecost:]%</span>毆熟的物理傷害；<br>
		且「快拳」的發動率<span class=\"yellow\">+[:rapidr:]</span>%<br>",
		'bdesc' => "消耗<span class=\"red\">[:ragecost:]</span>點怒氣，附加等於<span class=\"yellow\">[:phydmgr:]%</span>毆熟的物理傷害；本次攻擊「快拳」的觸發率<span class=\"yellow\">+[:rapidr:]</span>%",
		'vars' => Array(
			'ragecost' => Array(30,40,45),
			'phydmgr' => Array(25,33,50),
			'rapidr' => Array(5,15,25),
		),
		'lockdesc' => Array(
			'lvl' => '7級時解鎖',
			'wepk+wep_kind' => "空手時可發動",
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 7',
			'wepk+wep_kind' => "strpos([:wepk:],'N')!==false || (!empty([:wep_kind:]) && [:wep_kind:] == 'N')",
		),
	),
	'c13_parry' => Array
	(
		'name' => '消力',
		'tags' => Array('passive'),
		'desc' => '你的基礎防禦力增加<span class="yellow">毆系熟練度</span>點；<br>
		戰鬥中，你有<span class="yellow">[:parryr:]%</span>幾率消去<span class="yellow">毆系熟練度</span>點傷害（最多<span class="yellow">[:maxparry:]</span>點）<br>',
		'vars' => Array(
			'parryr' => 20,
			'maxparry' => 800,
		),
		'lockdesc' => Array(
			'lvl' => '11級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 11',
		),
	),
	'c13_duel' => Array
	(
		'name' => '決戰',
		'tags' => Array('active','limit'),
		'desc' => '發動後獲得增益效果：<br>
		當前毆系熟練翻倍，但每次探索/移動時減少<span class="red">[:wploss:]</span>點毆熟；<br>
		技能生效時，「快拳」與「消力」的發動率<span class="yellow">+[:rapidr:]%</span>',
		'input' => '發動',
		'no_reload_page' => 1,
		'log' => '<span class="L5">你感覺一股力量貫通全身！</span><br>',
		'status' => Array('wp','skillpara|c13_duel-active_t'),
		'effect' => Array(
			0 => Array(
				'wp' => '*=::2',
				'skillpara|c13_duel-active_t' => '+=::1'
			),
		),
		'events' => Array('getskill_buff_duel','active_news'),
		'link' => Array('buff_duel'),
		'vars' => Array(),
		'svars' => Array(
			'active_t' => 0,
		),
		'lockdesc' => Array(
			'skillpara|c13_duel-active_t' => '次數耗盡，已無法發動該技能',
			'lvl' => '21級時解鎖',
			'wp' => '需要至少250點毆熟才能發動！',
		),
		'unlock' => Array(
			'skillpara|c13_duel-active_t' => '[:skillpara|c13_duel-active_t:] < 1',
			'lvl' => '[:lvl:] >= 21',
			'wp' => '[:wp:] >= 250',
		),
	),
	'buff_duel' => Array
	(
		'name' => '[狀態]決戰',
		'tags' => Array('buff'),
		'desc' => '<span class="lime">「決戰」生效中！',
		'vars' => Array(
			'wploss' => 5, //每次移动减少的欧熟
			'rapidr' => 20, //增加的技能发动率
		),
		'lockdesc' => Array(
			'wp' => '需要至少5點毆熟才能生效！',
		),
		'unlock' => Array(
			'wp' => '[:wp:] >= 5',
		),
	),
	'c19_nirvana' => Array
	(
		'name' => '涅槃',
		'tags' => Array('passive','limit'),
		'desc' => "本局已生效<span class=\"redseed\"> [^skillpara|c19_nirvana-active_t^]/[:maxactive_t:] </span>次<br>
		因陷阱/戰鬥死亡時，轉化所有的{$sktprp}並立刻復活<br>
		每轉化<span class='yellow'>[:rpr:]</span>點{$sktprp}，復活後你的生命上限與防禦力<span class='yellow'>+[:hpgain:]</span>",
		'svars' => Array(
			'active_t' => 0,
		),
		'vars' => Array(
			'maxactive_t' => 1,
			'rpr' => 2,
			'hpgain' => 1,
		),
		'pvars' => Array(
			'skillpara|c19_nirvana-active_t',
		),
		'lockdesc' => Array(
			'skillpara|c19_nirvana-active_t' => '次數耗盡，無法生效',
		),
		'unlock' => Array(
			'skillpara|c19_nirvana-active_t' => '[:skillpara|c19_nirvana-active_t:] < 1',
		),
	),
	'c19_reincarn' => Array
	(
		'name' => '轉業',
		'tags' => Array('passive'),
		'desc' => "你的{$sktprp}增長量<span class=\"yellow\">-[:rpgain:]%</span>；降低量<span class=\"yellow\">+[:rploss:]%</span>",
		'maxlvl' => 6,
		'cost' => Array(1,2,3,4,5,6,-1),
		'input' => '升級',
		'log' => '<span class="yellow">「轉業」升級成功。</span><br>',
		'status' => Array('skillpara|c19_reincarn-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c19_reincarn-lvl' => '+=::1',),
		),
		'svars' => Array('lvl' => 0),
		'vars' => Array(
			'rpgain' => Array(7,15,24,34,45,57,69),
			'rploss' => Array(5,15,25,35,45,55,65),
		),
	),
	'c19_purity' => Array
	(
		'name' => '瑩心',
		'tags' => Array('passive'),
		'desc' => '你受到的最終傷害降低<span class="yellow">[:findmgdefr:]%</span>；向敵人造成的最終傷害降低<span class="yellow">[:findmgr:]%</span>',
		'maxlvl' => 6,
		'cost' => Array(5,6,6,3,2,1,-1),
		'input' => '升級',
		'log' => '<span class="yellow">「瑩心」升級成功。</span><br>',
		'status' => Array('skillpara|c19_purity-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c19_purity-lvl' => '+=::1',),
		),
		'svars' => Array('lvl' => 0),
		'vars' => Array(
			'findmgdefr' => Array(15,30,45,60,80,85,90),
			'findmgr' => Array(7,25,35,60,85,90,98),
		),
	),
	'c19_crystal' => Array
	(
		'name' => '晶璧',
		'tags' => Array('active'),
		'desc' => "消耗<span class='yellow'>[:ragecost:]</span>點怒氣，使戰場內所有參戰者獲得{$sktpshield}<br>
		護盾值等於<span class='yellow'>(<span tooltip2='取決於你的報應點數'>[^rp^]</span>×[:sldr:]%)</span>的絕對值；<br>
		每使一位參戰者(包括自己)獲得{$sktpshield}，你的{$sktprp}下降<span class='yellow'>[:rploss:]</span>點",
		'input' => '發動',
		'no_reload_page' => 1,
		'log' => '……<br>',
		'events' => Array('crystal','active_news'),
		'status' => Array('skillpara|c19_crystal-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c19_crystal-lvl' => '+=::1',),
		),
		'svars' => Array(
			'lvl' => 0,
		),
		'vars' => Array(
			'ragecost' => 75,
			'sldr' => 10,
			'rploss' => 160,
		),
		'pvars' => Array('rp'),
		'lockdesc' => Array(
			'lvl' => '7級時解鎖',
			'rage' => '怒氣不足，無法發動',
			'rp' => '報應點數為0，無法發動',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 7',
			'rage' => '[:rage:] >= 75',
			'rp' => '!empty([:rp:])',
		),
	),
	'c19_redeem' => Array
	(
		'name' => '祛障',
		'tags' => Array('battle'),
		'desc' => "消耗<span class=\"yellow\">[:ragecost:]</span>點怒氣，本次攻擊額外附加一段{$sktpwhitedmg}，<br>
		傷害量等於敵人與你的<span class=\"yellow\">報應點數之差</span>；<br>
		<span class=\"yellow\">差值為負</span>時不會造成傷害，但會將你的{$sktprp}部分轉移給敵人；<br>
		轉移量最低不低於<span class=\"yellow\">[:rpmin:]</span>，最高不超過敵人目前的{$sktprp}值",
		'bdesc' => "附加等於你與敵人<span class=\"yellow\">報應點數差值</span>的{$sktpwhitedmg}，或轉移報應點數；發動需消耗<span class=\"red\">[:ragecost:]</span>怒氣",
		'vars' => Array(
			'ragecost' => 40,
			'rpmin' => 100,
		),
		'lockdesc' => Array(
			'lvl' => '11級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 11',
		),
	),
	'c19_dispel' => Array
	(
		'name' => '量心',
		'tags' => Array('switch'),
		'desc' => '技能效果開啓時，你不會再直接擊殺敵人。<br>
		造成傷害時，至少會為對方保留<span class="red">1</span>點生命；<br>
		同時，你不會再遭遇僅有<span class="red">1</span>點生命值的敵人，除非對方主動攻擊你；<br>
		點擊右側的<span class="yellow">“切換”</span>鍵隨時激活或禁用該技能<br>
		[^skill-active^]',
		'input' => '切換',
		'log' => '<span class="yellow">切換了「量心」的狀態。</span>',
		'events' => Array('active|c19_dispel'),
		'svars' => Array(
			'active' => 0,
		),
		'pvars' => Array('skill-active'),
		'lockdesc' => Array(
			'lvl' => '17級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 17',
		),
	),
	'c19_woesea' => Array
	(
		'name' => '苦雨',
		'tags' => Array('active','limit'),
		'desc' => '本局已發動<span class="redseed"> [^skillpara|c19_woesea-active_t^]/[:maxactive_t:] </span>次<br>
		消耗<span class="yellow">[:sscost:]</span>點歌魂，將戰場天氣變更為<span class="minirainbow">光玉雨</span>；<br>
		<span class="minirainbow">光玉雨</span>持續<span class="yellow">[:wtht:]</span>秒，且不會被禁區或天氣控制改變；<br>
		天氣存在時，戰場上所有參戰者在行動時會<span class="yellow">超量</span>恢復<span class="yellow">生命、體力</span>；<br>
		技能發動者在該天氣下<span class="yellow">先制率</span>提升，且死亡後有概率<span class="yellow">復活</span>；<br>
		強化效力、復活概率隨天氣的<span class="yellow">持續時間</span>逐漸增長，<br>
		在第<span class="yellow">7</span>分鐘時達到峯值，之後漸弱<br>',
		'input' => '發動',
		'no_reload_page' => 1,
		'log' => '<br><br>',
		'status' => Array('skillpara|c19_woesea-active_t'),
		'effect' => Array(
			0 => Array(
				'skillpara|c19_woesea-active_t' => '+=::1',
			),
		),
		'events' => Array('woesea','active_news'),
		'vars' => Array(
			'sscost' => 100,
			'wtht' => 600,
			'maxactive_t' => 1,
		),
		'svars' => Array('active_t' => 0,),
		'pvars' => Array('skillpara|c19_woesea-active_t'),
		'lockdesc' => Array(
			'skillpara|c19_woesea-active_t' => '次數耗盡，已無法發動該技能',
			'lvl' => '21級時解鎖',
			'ss' => '需要100點歌魂才能發動！',
		),
		'unlock' => Array(
			'skillpara|c19_woesea-active_t' => '[:skillpara|c19_woesea-active_t:] < 1',
			'lvl' => '[:lvl:] >= 21',
			'ss' => '[:ss:] >= 100',
		),
	),
	'c20_fertile' => Array
	(
		'name' => '沃土',
		'tags' => Array('passive'),
		'desc' => '獲得元素時，獲得量<span class="yellow">+0%~[:emsgain:]%</span>；<br>
		每探索/移動<span class="yellow">[:mst:]</span>次，口袋中存量最低的元素數量<span class="yellow">+[:minemsgain:]%</span><br>
		<span class="grey">當前已探索/移動次數：[^skillpara|c20_fertile-ms^] 次</span>',
		'maxlvl' => 6,
		'cost' => Array(2,3,3,4,4,5,-1),
		'input' => '升級',
		'log' => '<span class="yellow">「沃土」升級成功。</span><br>',
		'status' => Array('skillpara|c20_fertile-lvl'),
		'effect' => Array(
			0 => Array('skillpara|c20_fertile-lvl' => '+=::1',),
		),
		'svars' => Array('lvl' => 0,'ms' => 0),
		'vars' => Array(
			'emsgain' => Array(1,2,2,3,3,4,5),
			'mst' => Array(35,35,30,30,25,25,20),
			'minemsgain' => Array(1,1,2,2,3,3,4),
		),
		'pvars' => Array('skillpara|c20_fertile-ms'),
	),
	'c20_windfall' => Array
	(
		'name' => '橫財',
		'tags' => Array('active','cd'),
		'desc' => '清空你口袋中的所有元素，<br>
		然後以儘可能平均的方式重新獲得它們。冷卻時間<span class="clan">[:cd:]</span>秒',
		'input' => '發動',
		'log' => '……<br>',
		'events' => Array('windfall','setstarttimes_c20_windfall','active_news'),
		'vars' => Array(
			'cd' => 900, //冷却时间
		),
		'lockdesc' => Array(
			'skillcooldown' => '技能冷卻中！<br>剩餘冷卻時間：<span class="red">[:cd:]</span> 秒',
		),
		'unlock' => Array(
			'skillcooldown' => 0,
		),
	),
	'c20_lighting' => Array
	(
		'name' => '閃電',
		'tags' => Array('battle'),
		'desc' => "消耗<span class='yellow'>[:ragecost:]</span>點怒氣與<span class='yellow'>[:emcost:]</span>份隨機元素，<br>
		根據所消耗元素種類附加{$sktpemsdmg}傷害；<br>
		累計發動次數達<span class='yellow'>(1+...+n)</span>次時，<br>
		消耗<span class='yellow'>(30×n)</span>份元素，同時觸發<span class='yellow'>(n)</span>次效果；<br>
		<span class='grey'>當前累計發動次數：[^skillpara|c20_lighting-active_t^] 次</span>",
		'bdesc' => "消耗<span class='yellow'>[:emcost:]</span>份隨機元素，根據所消耗元素種類附加{$sktpemsdmg}；消耗<span class='red'>[:ragecost:]</span>怒氣</span>",
		'vars' => Array(
			'ragecost' => 15,
			'emcost' => 30,
			'emextype' => Array( // 各类元素能造成的伤害类型
				0 => 'white',
				1 => 'u',
				2 => 'i',
				3 => 'p',
				4 => 'e',
				5 => 'w',
			),
		),
		'svars' => Array(
			'active_t' => 0,//技能发动次数
		),
		'pvars' => Array('skillpara|c20_lighting-active_t'),
		'lockdesc' => Array(
			'lvl' => '5級時解鎖',
			'element0+element1+element2+element3+element4+element5' => '至少需要30份元素才能發動',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 5',
			'element0+element1+element2+element3+element4+element5' => "[:element0:]>=30 || [:element1:]>=30 || [:element2:]>=30 || [:element3:]>=30 || [:element4:]>=30 || [:element5:]>=30",
		),
	),
	'c20_zombie' => Array
	(
		'name' => '靈俑',
		'tags' => Array('passive'),
		'desc' => "發現屍體時，消耗等同於<span class=\"yellow\">屍體等級的平方根×提煉屍體可獲得的元素數量</span>，將屍體復活為{$sktpzombie}；<br>
		復活後的{$sktpzombie}有<span class=\"yellow\">50%</span>概率為你<span class='gold' tooltip2='當你攻擊敵人且敵人未死亡時，與你在同一地點的靈俑有概率主動為你助戰。'>協戰</span>，並在你受到攻擊時，<br>
		為你抵擋最多不超過<span class=\"yellow\">[:maxdefhp:]%</span>靈俑當前生命的傷害",
		'vars' => Array(
			'maxdefhp' => 50,
			'notype' => Array(1,9,19,88,92), //不能复活为灵俑的NPC
		),
		'lockdesc' => Array(
			'lvl' => '11級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 11',
		),
	),
	'c20_sparkle' => Array
	(
		'name' => '火花',
		'tags' => Array('switch','limit'),
		'desc' => '技能開啓後，<br>
		造成傷害時有<span class="yellow">[:tpr:]%</span>概率將敵人傳送至隨機地點，<br>
		被傳送者會受到輕微傷害、或遭遇意外；<br>
		火花持有者受到<span class="red">致命傷害</span>時，會緊急傳送回避傷害，但<span class="red">永久失去</span>火花；<br>
		點擊右側的<span class="yellow">“切換”</span>鍵隨時激活或禁用該技能<br>
		[^skill-active^]',
		'input' => '切換',
		'log' => '<span class="yellow">切換了「火花」的狀態。</span>',
		'events' => Array('active|c20_sparkle'),
		'svars' => Array(
			'active' => 0,
			'active_t' => 0,
		),
		'vars' => Array(
			'tpr' => 15,
			'maxactive_t' => 1,
		),
		'pvars' => Array('skill-active','skillpara|c20_sparkle-active_t'),
		'lockdesc' => Array(
			'skillpara|c20_sparkle-active_t' => '已失去火花。',
			'lvl' => '13級時解鎖',
		),
		'unlock' => Array(
			'skillpara|c20_sparkle-active_t' => '[:skillpara|c20_sparkle-active_t:] < 1',
			'lvl' => '[:lvl:] >= 13',
		),
	),
	'c20_lotus' => Array
	(
		'name' => '黑蓮',
		'tags' => Array('active','limit'),
		'desc' => '本局已獻祭<span class="redseed"> [^skillpara|c20_lotus-active_t^]/[:maxactive_t:] </span>次<br>
		獻祭黑蓮花，口袋中所有元素存量<span class="yellow">x3</span><br>',
		'input' => '獻祭',
		'no_reload_page' => 1,
		'log' => '<span class="mtgblack">你將一坨不知道從哪弄來的黑糊糊的東西扔進了元素口袋裏……<br>
		片刻後，口袋裏傳來了令人毛骨悚然的咀嚼聲……</span><br>
		……<br>',
		'status' => Array('skillpara|c20_lotus-active_t'),
		'effect' => Array(
			0 => Array(
				'skillpara|c20_lotus-active_t' => '+=::1',
			),
		),
		'events' => Array('lotus','active_news'),
		'vars' => Array(
			'emsgain' => 3,
			'maxactive_t' => 3,
		),
		'svars' => Array('active_t' => 0,),
		'pvars' => Array('skillpara|c20_lotus-active_t'),
		'lockdesc' => Array(
			'skillpara|c20_lotus-active_t' => '黑蓮花已經用光了。',
			'lvl' => '17級時解鎖',
		),
		'unlock' => Array(
			'skillpara|c20_lotus-active_t' => '[:skillpara|c20_lotus-active_t:] < 3',
			'lvl' => '[:lvl:] >= 17',
		),
	),
	'c21_stormedge' => Array
	(
		'name' => '斥血',
		'tags' => Array('passive'),
		'desc' => '每次探索時，會損失一定比率的體力並增加體力上限；<br>
		每次移動時，會損失一定比率的生命和體力並增加生命和體力上限；<br>
		該損失比率：<span class="yellow">[:burn_rate:]%</span>×<span class="yellow">總行動次數</span><br>
		你不會因為該效果損失生命而死。<br>
		可以通過消耗代碼片段來降低該係數，<br>
		降低量：<span class="yellow">[:consume_rate:]%</span>×<span class="yellow">消耗代碼片段效耐和的平方根</span>',
		'vars' => Array(
			'burn_rate' => 0.03,
			'consume_rate' => 0.3,
			'gain_rate' => 0.006
		),
		'pvars' => Array('skillpara|c21_stormedge-ms', 'skillpara|c21_stormedge-consumpt'),
	),
	'c21_creation' => Array
	(
		'name' => '驅血',
		'tags' => Array('active'),
		'desc' => '選擇一個屬性，消耗等同於該屬性提取係數<span class="yellow">[:sp_rate:]</span>倍的體力值，<br>製造一個該屬性的代碼片段。<br>
		體力不足時會使用技能點代替，每技能點相當於<span class="yellow">[:skillpoint_value:]</span>體力<br>',
		'input' => '製造',
		'log' => '……<br>',
		'clog' => '……<br>',
		'events' => Array('creation'),
		'choice' => Array('A','a','B','b','C','c','D','d','E','e','F','f','G','g','H','h','I','i','J','j','K','k','l','M','m','N','n','o','P','p','q','R','r','S','s','U','u','V','v','W','w','X','x','y','Z','z','-','*','+','^','🧰','🍎'),
		'svars' => Array(
			'choice' => 'A',
		),
		'vars' => Array(
			'sp_rate' => 2,
			'skillpoint_value' => 30,
		),
		'lockdesc' => Array(
			'lvl' => '5級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 5',
		),
	),
	'c21_discovery' => Array
	(
		'name' => '湧血',
		'tags' => Array('active'),
		'desc' => '消耗<span class="yellow">[:spcost:]</span>體力上限和<span class="yellow">[:hpcost:]</span>生命上限，發現一個等級<span class="yellow">[^skillpara|c21_discovery-rank^]</span>的字段名。<br>
		提取出當前發現的字段達到<span class="yellow">[:task:]</span>次後，你不會再因為「斥血」損失生命和體力。<br>
		<span class="grey">當前發現的字段：</span><span class="yellow">[^skillpara|c21_discovery-frag^]</span><br>
		<span class="grey">當前已成功提取：[^skillpara|c21_discovery-count^]次</span>',
		'input' => '發現',
		'log' => '<span class="yellow">……</span>',
		'events' => Array('discovery'),
		'svars' => Array(
			'frag' => '暫無',
			'count' => 0,
			'rank' => 1
		),
		'vars' => Array(
			'spcost' => 15,
			'hpcost' => 20,
			'task' => 7
		),
		'pvars' => Array('skillpara|c21_discovery-frag', 'skillpara|c21_discovery-count', 'skillpara|c21_discovery-rank'),
		'lockdesc' => Array(
			'lvl' => '9級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 9',
		),
	),
	'c21_sacrifice' => Array
	(
		'name' => '燃血',
		'tags' => Array('switch'),
		'desc' => '技能開啓後，在提取代碼片段時，<br>
		可以支付等量的生命值代替不足的體力，<br>
		若生命值不足，<span class="yellow">[:death_obbs:]%</span>概率會立即死亡，若倖存則會剩餘<span class="yellow">1</span>點生命值<br>
		[^skill-active^]',
		'input' => '切換',
		'log' => '<span class="yellow">切換了「燃血」的狀態。</span>',
		'events' => Array('active|c21_sacrifice'),
		'vars' => Array(
			'death_obbs' => 50 //入乡随俗
		),
		'svars' => Array(
			'active' => 0,
		),
		'pvars' => Array('skill-active'),
		'lockdesc' => Array(
			'lvl' => '16級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 16',
		),
	),
	'c21_blaster' => Array
	(
		'name' => '爆血',
		'tags' => Array('battle'),
		'desc' => '消耗<span class="yellow">[:ragecost:]</span>點怒氣，引爆身上的全部代碼片段，<br>
		對敵人和自己造成等同於這些片段上的異常狀態，<br>
		並附加由這些片段的效果和與耐久和決定的最終傷害。<br>
		你每因此受到<span class="yellow">[:dmgrate:]</span>點傷害，就隨機造成敵人一處受傷。',
		'bdesc' => "引爆身上的全部代碼片段，根據片段的屬性對雙方造成額外傷害和效果；消耗<span class='red'>[:ragecost:]</span>怒氣</span>",
		'vars' => Array(
			'ragecost' => 100,
			'dmgrate' => 100, //造成一处部位受伤需要的伤害量
		),
		'lockdesc' => Array(
			'lvl' => '20級時解鎖',
		),
		'unlock' => Array(
			'lvl' => '[:lvl:] >= 20',
		),
	),
	'inf_zombie' => Array
	(
		'name' => '靈俑',
		'tags' => Array('inf'),
		'desc' => '你不會受到反噬傷害，但不能造成除了毒性、凍氣以外的屬性傷害<br>
		你造成的最終傷害降低<span class="yellow">[:findmgloss:]%</span>，從敵人處受到的傷害降低<span class="yellow">[:findmgr:]%</span>',
		'vars' => Array(
			'findmgloss' => 50,
			'findmgr' => 25,
		),
	),
	'tl_cstick' => Array
	(
		'name' => '掄屍',
		'tags' => Array('passive'),
		'desc' => '發現屍體時，可消耗<span class="red">[:ragecost:]</span>點怒氣將屍體作為<span class="yellow">毆系武器</span>拔出。<br>
		武器的<span class="yellow">效耐</span>取決於屍體的<span class="yellow">最大生命</span>與<span class="yellow">體力</span>，上限為<span class="red">[:limit:]</span>點。<br>
		優秀的屍源有概率為武器附加<span class="yellow">衝擊</span>與<span class="yellow">精英</span>屬性',
		'vars' => Array(
			'ragecost' => 100,
			'limit' => 117007,
			'notype' => Array(88,92),//不能用来抡的NPC
		),
	),
	'tl_pickpocket' => Array
	(
		'name' => '妙手',
		'tags' => Array('battle','passive'),
		'desc' => '消耗<span class="yellow">[:ragecost:]</span>點怒氣，獲得敵人隨機數量的金錢，<br>
		至多<span class="yellow">[:picklimit:]%</span>，但本次攻擊不造成傷害，且射程與持靈系武器相同；<br>
		發現屍體時，可消耗<span class="yellow">[:ragecost:]</span>點怒氣，將一個物品置入屍體的持有物品中',
		'bdesc' => '偷取敵人隨機數量（至多<span class="yellow">[:picklimit:]%</span>）的金錢；消耗<span class="red">[:ragecost:]</span>怒氣</span>',
		'vars' => Array(
			'picklimit' => 10,
			'ragecost' => 30,
		),
	),
	//技能名或许可以换一个
	'tl_cursetouch' => Array
	(
		'name' => '延咒',
		'tags' => Array('passive'),
		'desc' => '你每次攻擊命中後，有<span class="yellow">[:curse_obbs:]%</span>概率使敵人裝備或揹包中的隨機一件道具添加<span class="red">詛咒屬性</span>，<br>
		若你的裝備帶有<span class="red">詛咒屬性</span>，此概率變為<span class="yellow">[:curserate:]</span>倍',
		'vars' => Array(
			'curse_obbs' => 1,
			'curserate' => 5,
		),
	),
	'inf_dizzy' => Array
	(
		'name' => '眩暈',
		'tags' => Array('inf'),
		'desc' => '你感到頭暈目眩，無法進行任何行動或戰鬥！<br>眩暈狀態持續時間還剩<span class="red">[^lasttimes^]</span>秒',
		'pvars' => Array('lasttimes'),
		'slast' => Array(
			'lasttimes' => 0, //真正作用的持续时间
		),
	),
	'inf_cursed' => Array
	(
		'name' => '黴運',
		'tags' => Array('inf'),
		'desc' => '<span class="red b">你感覺自己要倒大黴了……</span>',
	),
);



?>
