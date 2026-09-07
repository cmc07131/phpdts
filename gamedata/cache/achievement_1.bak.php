<?php
if(!defined('IN_GAME')) exit('Access Denied');

# 成就大类列表：
$ach_type = Array
(
	'daily' => Array(
		'name' => '每日挑戰',
		'desc' => '<font color="olive">這裏是用來為日常遊玩調味的佐餐成就。<br>
		雖然叫做每日挑戰，但其實每六個小時就能刷新一次。</font>',
		'ach' => Array(601,602,603,604,605,606,607,608,609,610),
	),
	'end' => Array(
		'name' => '結局成就',
		'desc' => '<font color="olive">這裏是與遊戲結局相關的成就。<br>
		雖説有些看起來幫助中沒提到，但找尋它們也正是這遊戲的醍醐味之一。<br></font>',
		'ach' => Array(16,17,18,34,19,100,101,102),
	),
	'hunt' => Array(
		'name' => '獵人成就',
		'desc' => '<font color="olive">這裏是與其他玩家戰鬥相關的成就。<br>
		專注，戰鬥，取得勝利！<br></font>',
		'ach' => Array(2,60,61,62,63,64,65,66,67,68,69),
	),
	'battle' => Array(
		'name' => '戰鬥成就',
		'desc' => '<font color="olive">這裏是與擊破特定NPC相關的成就。<br>
		打倒他們來證明自己吧！<br></font>',
		'ach' => Array(3,56,57,27,4,13,22,23,25,20,21,24,26,255),
	),
	'mixitem' => Array(
		'name' => '合成成就',
		'desc' => '<font color="olive">這裏是與合成某些特殊物品相關的成就。<br>
		物是人的延展，這些物品背後或許有些值得一聽的故事。<br></font>',
		'ach' => Array(0,14,15,49,51,52,50),
	),
	'explore' => Array(
		'name' => '探索成就',
		'desc' => '<font color="olive">這裏是與你在遊戲中會遇到的驚奇發現相關的成就。<br>
		今天又會遇到些什麼呢？<br></font>',
		'ach' => Array(33,31,32),
	),
	'lifetime' => Array(
		'name' => '生涯成就',
		'desc' => '<font color="olive">這裏是記錄了你在這個遊戲中的積累相關的成就。<br>
		嗚呼——玩家們出發了……<br></font>',
		'ach' => Array(29,30,53,54,55,208,600,255),
	),
	'challenge' => Array(
		'name' => '挑戰成就',
		'desc' => '<font color="olive">這裏是與特定遊戲中挑戰相關的成就。<br>
		雖然頗為浮雲，但畢竟山就在那裏。<br></font>',
		'ach' => Array(1,200,201,28,202,203,204,205,206,207,255),
	),
);

# 日记大类列表：
$diary_type = Array
(
	'mixdiary' => Array
	(
		'name' => '合成日記',
		'desc' => '<font color="olive">這裏記載着你在遊戲中合成過的道具的記錄。<br>
		這些內容不會被統計在總成就完成度內。<br></font>',
		'ach' => Array(35,36,37,38,39,40,41,42,43,44,45,46,47,48),
	),
);

# 隐藏成就列表：（隐藏成就ID → 完成后会显示在哪个大类）只在完成时显示
$hidden_ach_type = Array
(
	//KEY系隐藏成就：吃下【像围棋子一样的饼干】【桔黄色的果酱】并且活下来
	501 => 'explore',
	//KEY系隐藏成就：使用【翼人的羽毛】打出7230点以上伤害
	502 => 'explore',
	//KEY系隐藏成就：穿着【智代专用熊装】连续攻击同一个玩家/NPC64次以上
	503 => 'explore',
	//KEY系隐藏成就：在【RF高校】使用每一种系的武器各杀死一个目标
	504 => 'explore',
	//KEY系隐藏成就：一击秒杀【守卫者 静流】
	505 => 'explore',

	//74隐藏成就：通过元素合成获得G.A.M.E.O.V.E.R
	103 => 'explore',
);

# 成就登记列表：
$ach_list = Array
(
	/*'example' => Array(
		//成就完成时所处阶段（必填）
		'lvl' => 3, 
		//各阶段成就名（必填）（PS：完成阶段名可填可不填，填了会显示，不填会显示前一个阶段的名字）
		'name' => Array('阶段0名','阶段1名','阶段2名','阶段完成'), 
		//各阶段状态名（选填，不填此项会应用默认状态名）
		'lvlname' => Array('<span class="red">[未完成]</span>','<span class="clan">[进行中]</span>','<span class="clan">[进行中]</span>','<span class="lime">[完成]</span>'),
		//各阶段用来显示完成情况的描述文本（选填，不填此项会应用默认完成情况描述）
		'request' => Array('目前进度：[:request:]点','目前进度：[:request:]点','目前进度：[:request:]点','完成次数：[:request:]次',),
		//各阶段头衔奖励（必填，无头衔奖励使用''占位）
		'title' => Array('完成阶段0头衔奖励','完成阶段1头衔奖励','完成阶段2头衔奖励'),
		//各阶段积分奖励（必填，无积分奖励使用''占位）
        'c1' => Array(1,100,250,250),
		//各阶段切糕奖励（必填，无切糕奖励使用''占位）
        'c2' => Array(10,0,0,0),
		//各阶段成就简介（必填）
		'desc' => Array( 
			'这是模板成就的阶段0',
			'这是模板成就的阶段1',
			'这是模板成就的阶段2',
		),
	),*/
	0 => Array(
		'lvl' => 3,
		'name' => Array('永恆世界的住人','1世界的往人','永恆的覆唱'),
		'title' => Array('','1','2'),
		'c1' => Array(0,200,700),
		'c2' => Array(10,0,0),
		'desc' => Array( 
			'合成物品【KEY系催淚彈】1次',
			'合成物品【KEY系催淚彈】5次',
			'合成物品【KEY系催淚彈】30次',
		),
	),
	3 => Array(
		'lvl' => 3,
		'name' => Array('腳本小子','3','幻境解離者？'),
		'title' => Array('','3','4'),
		'c1' => Array(0,200,500),
		'c2' => Array(5,0,15),
		),
	4 => Array(
		'lvl' => 2,
		'name' => Array('冒煙突火','紅殺將軍'),
        'title' => Array('','5'),
        'c1' => Array(50,0),
        'c2' => Array(75,0),
	),
	5 => Array(
		//'name' => Array('自作孽不可活'),
        //'title' => Array(''),
        //'c1' => Array(10),
        //'c2' => Array(5),
	),
	6 => Array(
		//'name' => Array('野生君的邂逅'),
        //'title' => Array(''),
        //'c1' => Array(10),
        //'c2' => Array(15),
	),
	7 => Array(
		//'name' => Array('野生君的暗恋'),
        //'title' => Array(''),
        //'c1' => Array(50),
        //'c2' => Array(120),
	),
	8 => Array(
		//'name' => Array('这么死也值了！'),
        //'title' => Array(''),
        //'c1' => Array(10),
        //'c2' => Array(10),
	),
	9 => Array(
		//'name' => Array('对下雷者的“大打击”'),
        //'title' => Array(''),
        //'c1' => Array(30),
        //'c2' => Array(15),
	),
	10 => Array(
		//'name' => Array('救命的迎击'),
        //'title' => Array(''),
        //'c1' => Array(15),
        //'c2' => Array(15),
	),
	11 => Array(
		//'name' => Array('真·地雷磁铁'),
        //'title' => Array('')
        //'c1' => Array(100),
        //'c2' => Array(100),
	),
	12 => Array(
		//'name' => Array('DeathNoter'),
        //'title' => Array(''),
        //'c1' => Array(30),
        //'c2' => Array(30),
	),
	13 => Array(
		'lvl' => 2,
		'name' => Array('深度凍結','6'),
        'title' => Array('','6'),
        'c1' => Array(150,0),
        'c2' => Array(250,0),
	),
	14 => Array(
		'lvl' => 3,
		'name' => Array('篝火的引導','世界的7','地=月'),
        'title' => Array('','7','8'),
        'c1' => Array(0,200,700),
        'c2' => Array(10,0,0),
	),
	15 => Array(
		'lvl' => 3,
		'name' => Array('不屈的生命','那種話最討厭了','明亮的未來'),
        'title' => Array('','9','10'),
        'c1' => Array(0,200,700),
        'c2' => Array(10,0,0),
	),
	20 => Array(
		'lvl' => 1,
		'name' => Array('尋星急襲'),
        'title' => Array('11'),
        'c1' => Array(268),
        'c2' => Array(263),
	),
	21 => Array(
		'lvl' => 1,
		'name' => Array('權限【嗶】的最期'),
        'title' => Array('12'),
        'c1' => Array(233),
        'c2' => Array(233),
	),
	22 => Array(
		'lvl' => 1,
		'name' => Array('233MAX'),
        'title' => Array('13'),
        'c1' => Array(2333),
        'c2' => Array(0),
	),
	23 => Array(
		'lvl' => 1,
		'name' => Array('真名解放'),
        'title' => Array('14'),
        'c1' => Array(0),
        'c2' => Array(888),
	),
	24 => Array(
		'lvl' => 1,
		'name' => Array('逆推'),
        'title' => Array('15'),
        'c1' => Array(211),
        'c2' => Array(299),
	),
	25 => Array(
		'lvl' => 1,
		'name' => Array('一屍兩命'),
        'title' => Array('16'),
        'c1' => Array(111),
        'c2' => Array(333),
	),
	26 => Array(
		'lvl' => 1,
		'name' => Array('正直者之死'),
        'title' => Array('17'),
        'c1' => Array(1),
        'c2' => Array(111),
	),
	27 => Array(
		'lvl' => 3,
		'name' => Array('秋後算賬','報仇雪恨','血洗英靈殿'),
        'title' => Array('','','18'),
        'c1' => Array(0,300,500),
        'c2' => Array(10,0,0),
	),
	29 => Array(
		'lvl' => 3,
		'name' => Array('及時補給','衣食無憂','奧義很爽'),
        'title' => Array('','19','20'),
        'c1' => Array(0,0,0),
        'c2' => Array(5,50,200),
		'desc' => Array(
			'使用無毒補給的總效果達到32767點',
			'使用無毒補給的總效果達到142857點',
			'使用無毒補給的總效果達到999983點',
		),
	),
	30 => Array(
		'lvl' => 3,
		'name' => Array('飢不擇食','嘗百草','吞食天地'),
        'title' => Array('','21','22'),
        'c1' => Array(0,0,0),
        'c2' => Array(5,50,200),
		'desc' => Array(
			'食用30效以上的有毒補給5次',
			'食用30效以上的有毒補給133次',
			'食用30效以上的有毒補給365次',
		),
	),
	35 => Array(
		'lvl' => 3,
		'name' => Array('試試看毆系吧！','熱血的機師','24'),
        'title' => Array('','23','24'),
        'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	36 => Array(
		'lvl' => 3,
		'name' => Array('試試看斬系吧！','25','26'),
        'title' => Array('','25','26'),
        'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	37 => Array(
		'lvl' => 3,
		'name' => Array('來精進斬系吧！','27','28'),
        'title' => Array('','27','28'),
		'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	38 => Array(
		'lvl' => 3,
		'name' => Array('試試看射系吧！','29','30'),
        'title' => Array('','29','30'),
        'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	39 => Array(
		'lvl' => 3,
		'name' => Array('試試看重槍吧！','31','32'),
        'title' => Array('','31','32'),
        'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	40 => Array(
		'lvl' => 3,
		'name' => Array('試試看遊戲王吧！','33','34'),
        'title' => Array('','33','34'),
        'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	41 => Array(
		'lvl' => 3,
		'name' => Array('進行35吧！','35','36'),
        'title' => Array('','35','36'),
        'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	42 => Array(
		'lvl' => 3,
		'name' => Array('試試看投系吧！','37','38'),
        'title' => Array('','37','38'),
        'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	43 => Array(
		'lvl' => 3,
		'name' => Array('試試看爆系吧！','39','40'),
        'title' => Array('','39','40'),
        'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	44 => Array(
		'lvl' => 3,
		'name' => Array('來精進爆系吧！','41','42'),
        'title' => Array('','41','42'),
        'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	45 => Array(
		'lvl' => 3,
		'name' => Array('試試看靈系吧！','43','44'),
        'title' => Array('','43','44'),
        'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	46 => Array(
		'lvl' => 3,
		'name' => Array('來精進靈系吧！','45','46'),
        'title' => Array('','45','46'),
        'c1' => Array(0,100,350),
        'c2' => Array(10),
	),
	47 => Array(
		'lvl' => 3,
		'name' => Array('知己知彼！','47','48'),
        'title' => Array('','47','48'),
        'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	48 => Array(
		'lvl' => 3,
		'name' => Array('感受一下混沌吧！','49','50'),
        'title' => Array('','49','50'),
        'c1' => Array(0,100,350),
        'c2' => Array(10,0,0),
	),
	53 => Array(
		'lvl' => 3,
		'name' => Array('來打釘子吧！','51','52'),
        'title' => Array('','51','52'),
        'c1' => Array(0,0,0),
        'c2' => Array(5,50,200),
	),
	54 => Array(
		'lvl' => 3,
		'name' => Array('來磨刀吧！','53','54'),
        'title' => Array('','53','54'),
        'c1' => Array(0,0,0),
        'c2' => Array(5,50,200),
	),
	55 => Array(
		'lvl' => 3,
		'name' => Array('來打補丁吧！','55','56'),
        'title' => Array('','55','56'),
        'c1' => Array(0,0,0),
        'c2' => Array(5,50,200),
	),
	56 => Array(
		'lvl' => 3,
		'name' => Array('種火？那是啥？','是57。','58'),
        'title' => Array('','57','58'),
        'c1' => Array(0,100,250),
        'c2' => Array(10,0,0),
	),
	57 => Array(
		'lvl' => 3,
		'name' => Array('外來的神秘','59','60'),
        'title' => Array('','59','60'),
        'c1' => Array(0,100,250),
        'c2' => Array(10,0,0),
	),
	# 结局成就:

	# 最后幸存
	16 => Array(
		'lvl' => 3,
		'name' => Array('最後倖存','只是運氣好而已','不止是運氣好而已？','不止是運氣好而已！'),
        'title' => Array('','61','62'),
		'c1' => Array(0,0,0),
        'c2' => Array(77,777,2777),
		'desc' => Array( 
			'達成結局：最後倖存 1次',
			'達成結局：最後倖存 17次',
			'達成結局：最後倖存 177次',
		),
	),
	# 独自逃脱
	34 => Array(
		'lvl' => 3,
		'name' => Array('逃避可恥？','但它有用！','直面現實','逃脱大師'),
		'title' => Array('63','64','65'),
		'c1' => Array(0,0,0),
		'c2' => Array(15,70,300),
		'desc' => Array( 
			'獨自逃離幻境1次。',
			'獨自逃離幻境36次。',
			'獨自逃離幻境101次。',
		),
	),
	# 核爆全灭
	17 => Array(
		'lvl' => 2,
		'name' => Array('核爆全滅','麻煩製造機？','麻煩製造機'),
        'title' => Array('','66'),
		'c1' => Array(0,0,0),
        'c2' => Array(100,500),
		'desc' => Array( 
			'達成結局：核爆全滅 1次',
			'達成結局：核爆全滅 7次',
		),
	),
	# 锁定解除
	18 => Array(
		'lvl' => 3,
		'name' => Array('鎖定解除','67','執念的殘火','68'),
        'title' => Array('','67','68'),
        'c1' => Array(0,0,0),
        'c2' => Array(300,1312,1777),
		'desc' => Array( 
			'<span tooltip="獨自完成、或與團隊共同達成結局時，均可達成此成就">參與達成結局：鎖定解除 1次</span>',
			'<span tooltip="獨自完成、或與團隊共同達成結局時，均可達成此成就">參與達成結局：鎖定解除 17次</span>',
			'<span tooltip="獨自完成、或與團隊共同達成結局時，均可達成此成就">參與達成結局：鎖定解除 77次</span>',
		),
	),
	# 幻境解离
	19 => Array(
		'lvl' => 3,
		'name' => Array('幻境解離','69','■■的■火','70'),
		'title' => Array('69','','70'),
		'c1' => Array(1000,0,0),
		'c2' => Array(1000,3000,76531),
		'desc' => Array( 
			"<span tooltip=\"獨自完成、或與團隊共同達成結局時，均可達成此成就\">參與達成結局：幻境解離 1次</span>",
			"<span tooltip=\"獨自完成、或與團隊共同達成結局時，均可達成此成就\">參與達成結局：幻境解離 17次</span>",
			"<span tooltip=\"獨自完成、或與團隊共同達成結局時，均可達成此成就\">參與達成結局：幻境解離 77次</span>",
		),
	),
	# 执行官解禁
	100 => Array(
		'lvl' => 1, 
		'name' => Array('結束了？','未完待續'), 
		'title' => Array('71'),
        'c1' => Array(0),
        'c2' => Array(450),
		'desc' => Array( 
			'使用 <span class="sienna">幻影執行官</span> 掉落的道具達成結局：鎖定解除'
		),
	),
	# 真红蓝解禁
	101 => Array(
		'lvl' => 1, 
		'name' => Array('勢如水火','合縱連橫'), 
		'title' => Array('72'),
		'c1' => Array(0),
		'c2' => Array(950),
		'desc' => Array( 
			'使用 <span class="sienna">參戰者 紅暮&藍凝</span> 掉落的道具達成結局：鎖定解除',
		),
	),
	# DF解禁
	102 => Array(
		'lvl' => 1, 
		'name' => Array('不可能的偉業','73'), 
		'title' => Array('73'),
		'c1' => Array(0),
		'c2' => Array(1730),
		'desc' => Array( 
			'使用 <span class="sienna">未名存在 Dark Force</span> 掉落的道具達成結局：鎖定解除',
		),
	),
	# 74达成幻境解离结局
	103 => Array(
		'lvl' => 1, 
		'name' => Array('我的口袋呢？'), 
		'title' => Array('74'),
		'c1' => Array(0),
		'c2' => Array(0),
		'desc' => Array( 
			'以<span class="sienna">追本溯源</span>的方式達成結局：幻境解離',
		),
	),

	# 猎人成就：
	# 击杀玩家：
	2 => Array(
		'lvl' => 3,
		'name' => Array('Run With Wolves','Day Game','Thousand Enemies'),
		'title' => Array('','75','76'),
		'c1' => Array(10,500,0),
		'c2' => Array(0,0,200),
		'desc' => Array( 
			'累計擊殺10名玩家',
			'累計擊殺100名玩家',
			'累計擊殺1000名玩家',
		),
	),
	# 击杀存在击杀数的玩家：
	60 => Array(
		'lvl' => 3, 
		'name' => Array('螳螂在前','黃雀在後','貓咪在哪？','貓咪在這兒！'), 
		'title' => Array('','77','78'),
		'c1' => Array(100,200,500),
		'c2' => Array(0,200,500),
		'desc' => Array( 
			'擊殺1名<span class="sienna">擊殺過其他玩家</span>的玩家',
			'擊殺10名<span class="sienna">擊殺過其他玩家</span>的玩家',
			'擊殺100名<span class="sienna">擊殺過其他玩家</span>的玩家',
		),
	),
	# 在死斗模式下击杀玩家
	61 => Array(
		'lvl' => 3, 
		'name' => Array('惺惺相惜','罕逢敵手','無可匹敵？','無可匹敵！'), 
		'title' => Array('','79','80'),
		'c1' => Array(155,455,755),
		'c2' => Array(0,0,0),
		'desc' => Array( 
			'在<span class="sienna">死鬥模式</span>下擊殺1名玩家',
			'在<span class="sienna">死鬥模式</span>下擊殺10名玩家',
			'在<span class="sienna">死鬥模式</span>下擊殺100名玩家',
		),
	),
	# 使用毒补给杀死玩家
	62 => Array(
		'lvl' => 3, 
		'name' => Array('好味！','呸呸呸！','嘔嘔嘔嘔！'), 
		'title' => Array('','81','82'),
		'c1' => Array(233,466,1791),
		'c2' => Array(0,0,0),
		'desc' => Array( 
			'使用<span class="sienna">毒性補給</span>毒殺1名玩家（不包括自己）',
			'使用<span class="sienna">毒性補給</span>毒殺10名玩家（不包括自己）',
			'使用<span class="sienna">毒性補給</span>毒殺100名玩家（不包括自己）',
		),
	),
	# 使用陷阱杀死玩家
	63 => Array(
		'lvl' => 3, 
		'name' => Array('小心腳下','此面向敵','荊棘叢生'), 
		'title' => Array('','83','84'),
		'c1' => Array(213,409,1234),
		'c2' => Array(0,0,0),
		'desc' => Array( 
			'通過<span class="sienna">埋設陷阱</span>殺死1名玩家（不包括自己）',
			'通過<span class="sienna">埋設陷阱</span>殺死10名玩家（不包括自己）',
			'通過<span class="sienna">埋設陷阱</span>殺死100名玩家（不包括自己）',
		),
	),
	# 使用■DeathNote■杀死玩家
	64 => Array(
		'lvl' => 1, 
		'name' => Array('DeathNoter','K.I.R.A'), 
		'title' => Array('85'),
		'c1' => Array(77),
		'c2' => Array(0),
		'desc' => Array( 
			'使用<span class="sienna">■DeathNote■</span>殺死1名玩家',
		),
	),
	# 击杀1名使用过移动PC的玩家
	65 => Array(
		'lvl' => 3, 
		'name' => Array('遵紀守法','繩之以法','私法制裁'), 
		'title' => Array('','86','87'),
		'c1' => Array(110,310,911),
		'c2' => Array(0,0,0),
		'desc' => Array( 
			'擊殺1名使用過<span class="sienna">移動PC</span>的玩家',
			'擊殺10名使用過<span class="sienna">移動PC</span>的玩家',
			'擊殺100名使用過<span class="sienna">移動PC</span>的玩家',
		),
	),
	# 击杀1名改变过天气的玩家
	66 => Array(
		'lvl' => 3, 
		'name' => Array('聽風是雨','年輕稚嫩','一切未曾改變'), 
		'title' => Array('','88','89'),
		'c1' => Array(110,310,911),
		'c2' => Array(0,0,0),
		'desc' => Array( 
			'擊殺1名<span class="sienna">改變過天氣狀況</span>的玩家',
			'擊殺10名<span class="sienna">改變過天氣狀況</span>的玩家',
			'擊殺100名<span class="sienna">改變過天氣狀況</span>的玩家',
		),
	),
	# 击杀1名使用了破灭之诗的活跃玩家
	67 => Array(
		'lvl' => 3, 
		'name' => Array('幻境防火牆','幻境防火牆？','幻境千年蟲'), 
		'title' => Array('','90','91'),
		'c1' => Array(334,667,1919),
		'c2' => Array(0,0,0),
		'desc' => Array( 
			'擊殺1名使用過<span class="sienna">破滅之詩</span>的活躍玩家',
			'在入場時間更晚的情況下，擊殺1名使用過<span class="sienna">破滅之詩</span>的活躍玩家',
			'在入場時間更晚的情況下，擊殺13名使用過<span class="sienna">破滅之詩</span>的活躍玩家',
		),
	),
	# 击杀数据碎片后，击杀1名发现过数据碎片尸体的玩家
	68 => Array(
		'lvl' => 1, 
		'name' => Array('正當防衞','防衞過當'), 
		'title' => Array('92'),
		'c1' => Array(233),
		'c2' => Array(0),
		'desc' => Array( 
			'擊殺任一數據碎片後，擊殺1名<span class="sienna">發現數據碎片屍體</span>的活躍玩家',
		),
	),
	# 击杀从福袋中开出稀有道具的玩家
	69 => Array(
		'lvl' => 3, 
		'name' => Array('汪？','海豹？','歐鰉？'), 
		'title' => Array('','93','94'),
		'c1' => Array(233,234,235),
		'c2' => Array(0,0,0),
		'desc' => Array( 
			'擊殺1位<span class="sienna">從福袋中開出SR物品</span>的活躍玩家',
			'擊殺1位<span class="sienna">從福袋中開出SSR物品</span>的活躍玩家',
			'在入場時間更晚的情況下，擊殺13位<span class="sienna">從福袋中開出SSR物品</span>的活躍玩家',
		),
	),

	# 合成成就
	# 合成春雨夏海 > 这个应该挪到合成成就里
	49 => Array(
		'lvl' => 3,
		'name' => Array('超級ＫＥＹ愛好者','95'),
		'title' => Array('','95'),
		'c1' => Array(0,700),
		'c2' => Array(100,0),
		'desc' => Array( 
			'合成物品【春雨夏海，秋葉冬雪】1次',
			'合成物品【春雨夏海，秋葉冬雪】7次',
		),
	),
	# 合成一发逆转神话 > 同上
	50 => Array(
		'lvl' => 2,
		'name' => Array('人，能夠挑戰神嗎？','96'),
		'title' => Array('','96'),
		'c1' => Array(0,700),
		'c2' => Array(100,0),
		'desc' => Array( 
			'合成物品★一發逆轉神話★1次',
			'合成物品★一發逆轉神話★7次',
		),
	),
	# 合成EX 你们都挤在挑战里干什么？？
	51 => Array(
		'lvl' => 2,
		'name' => Array('究極的靈魂','97'),
		'title' => Array('','97'),
		'c1' => Array(0,700),
		'c2' => Array(100,0),
		'desc' => Array( 
			'合成物品模式『EX』1次',
			'合成物品模式『EX』7次',
		),
	),
	# 合成光之创造神 ……
	52 => Array(
		'lvl' => 2,
		'name' => Array('真正的34','◎勝利之光◎'),
		'title' => Array('','97'),
		'c1' => Array(0,700),
		'c2' => Array(100,0),
		'desc' => Array( 
			'合成物品◎光之創造神◎1次',
			'合成物品◎光之創造神◎7次',
		),
	),

	# 探索成就
	# 98：这是一个存在固定模板的成就
	33 => Array(
		'lvl' => 1,
		'name' => Array('詛咒之刃'),
        'title' => Array('98'),
        'c1' => Array(0),
        'c2' => Array(522),
	),
	# RTS：这是一个存在固定模板的成就
	31 => Array(
		'lvl' => 1,
		'name' => Array('Return to Sender'),
		'title' => Array('99'),
		'c1' => Array(0),
		'c2' => Array(0),
	),
	# KEY系隐藏成就：吃下【像围棋子一样的饼干】【桔黄色的果酱】并且活下来
	501 => Array(
		'lvl' => 1,
		'name' => Array('異世般的食材'),
		'request' => '倖存次數：[:request:]次',
		'title' => Array('100'),
		'c1' => Array(0),
		'c2' => Array(0),
		'desc' => Array( 
			'親身體驗了來自<span class="sienna">水瀨秋子及月宮亞由</span>的無敵料理。',
		),
	),
	# KEY系隐藏成就：使用【翼人的羽毛】打出7230点以上伤害
	502 => Array(
		'lvl' => 1,
		'name' => Array('空真理之威力'),
		'request' => '最高造成傷害：[:request:]點',
		'title' => Array('101'),
		'c1' => Array(0),
		'c2' => Array(0),
		'desc' => Array( 
			'親身獲得了匹敵與<span class="sienna">翼人</span>的力量。',
		),
	),
	# 穿着【智代专用熊装】连续攻击同一个玩家/NPC64次以上
	503 => Array(
		'lvl' => 1,
		'name' => Array('受難的馬桶圈'),
		'request' => '最高連擊次數：[:request:]次',
		'title' => Array('102'),
		'c1' => Array(0),
		'c2' => Array(0),
		'desc' => Array( 
			'親身重現了<span class="sienna">坂上智代</span>的偉業。',
		),
	),
	# 在【RF高校】使用每一种系的武器各杀死一个目标
	504 => Array(
		'lvl' => 1,
		'name' => Array('那就是Little Busters！'),
		'request' => '完成擊殺的系別：[:request:]種',
		'title' => Array('103'),
		'c1' => Array(0),
		'c2' => Array(0),
		'desc' => Array( 
			'親身再現了<span class="sienna">Little Busters</span>的日常。',
		),
	),
	# 一击秒杀【守卫者 静流】
	505 => Array(
		'lvl' => 1,
		'name' => Array('可愛，温柔，強大，但……'),
		'title' => Array('104'),
		'c1' => Array(0),
		'c2' => Array(0),
		'desc' => Array( 
			'親身讓<span class="sienna">守衞者的尖兵 中津靜流</span>瞭解到何為無奈。',
		),
	),

	# 挑战成就
	# key男
	1 => Array(
		'lvl' => 1,
		'name' => Array('清水池之王','清水池之王'),
		'request' => Array('最快速度：[:request:]秒'),
		'title' => Array('105'),
		'c1' => Array(30),
		'c2' => Array(16),
		'desc' => Array( 
			'在開局<span class="sienna">5分鐘內</span>合成【KEY系催淚彈】',
		),
	),
	# 开局15分钟内合成46
	200 => Array(
		'lvl' => 1,
		'name' => Array('不動的大圖書館'),
		'request' => Array('最快速度：[:request:]秒'),
		'title' => Array('106'),
		'c1' => Array(0),
		'c2' => Array(666),
		'desc' => Array( 
			'在開局<span class="sienna">15分鐘內</span>合成火水木金土符『46』',
		),
	),
	# 开局7分钟内合成✦烈埋火
	201 => Array(
		'lvl' => 1,
		'name' => Array('星星之火','滴水石穿'),
		'request' => Array('最快速度：[:request:]秒'),
		'title' => Array('107'),
		'c1' => Array(0),
		'c2' => Array(666),
		'desc' => Array( 
			'在開局<span class="sienna">7分鐘內</span>合成✦烈埋火',
		),
	),
	# 108
	28 => Array(
		'lvl' => 1,
		'name' => Array('烈火疾風',),
		'request' => Array('最快速度：[:request:]秒'),
		'title' => Array('108'),
		'c1' => Array(250),
		'c2' => Array(0),
		'desc' => Array( 
			'在開局<span class="sienna">30分鐘內</span>開啓死鬥模式',
		),
	),
	# 开局25分钟内达成锁定解除
	202 => Array(
		'lvl' => 1,
		'name' => Array('鎖孔','穿越無鑰之門'),
		'request' => Array('最快速度：[:request:]秒'),
		'title' => Array('109'),
		'c1' => Array(0),
		'c2' => Array(1024),
		'desc' => Array( 
			'在開局<span class="sienna">25分鐘內</span>達成結局：鎖定解除',
		),
	),
	# 开局55分钟内达成幻境解离
	203 => Array(
		'lvl' => 1,
		'name' => Array('宛如夢幻','幻境旅者'),
		'request' => Array('最快速度：[:request:]秒'),
		'title' => Array('110'),
		'c1' => Array(0),
		'c2' => Array(4096),
		'desc' => Array( 
			'在開局<span class="sienna">55分鐘內</span>達成結局：幻境解離',
		),
	),
	# 套装收集挑战（这是一个存在固定模板的成就）
	208 => Array(
		'lvl' => 3,
		'name' => Array('新綠的故事','111','112'),
		'title' => Array('','111','112'),
		'c1' => Array(0,0,0),
		'c2' => Array(233,234,235),
		'desc' => Array( 
			'觸發過任1種<span class="sienna">套裝</span>的完整效果',
			'觸發過3種不同<span class="sienna">套裝</span>的完整效果',
			'觸發過5種不同<span class="sienna">套裝</span>的完整效果',
		),
	),
	# 使用混沌武器打满伤害
	204 => Array(
		'lvl' => 1,
		'name' => Array('混沌的寵兒','隨機數之神的庇佑'),
		'title' => Array('113'),
		'c1' => Array(0),
		'c2' => Array(444),
		'desc' => Array( 
			'使用帶有<span class="sienna">混沌屬性</span>的武器攻擊時，造成1次滿額傷害',
		),
	),
	# 一击承受超过一百万伤害
	205 => Array(
		'lvl' => 1,
		'name' => Array('磁場高手','磁場顛佬'),
		'request' => Array('承受最多傷害：[:request:]點'),
		'title' => Array('114'),
		'c1' => Array(0),
		'c2' => Array(1919),
		'desc' => Array( 
			'在戰鬥中一次性受到超過<span class="sienna">1000000</span>點傷害',
		),
	),
	# 不使用合成/元素合成达成锁定解除/幻境解离结局
	206 => Array(
		'lvl' => 1,
		'name' => Array('你是怎麼做到的？'),
		'title' => Array('115'),
		'c1' => Array(7777),
		'c2' => Array(0),
		'desc' => Array( 
			'不使用<span class="sienna">合成/元素合成/隊伍</span>功能<br>達成結局：鎖定解除 或 幻境解離',
		),
	),
	# 不击杀小兵/种火达成锁定解除结局
	207 => Array(
		'lvl' => 1,
		'name' => Array('這是人能做到的嗎？'),
		'title' => Array('116'),
		'c1' => Array(0),
		'c2' => Array(7777),
		'desc' => Array( 
			'不擊殺<span class="sienna">各路黨派與種火</span>達成結局：鎖定解除',
		),
	),
	# 117 > TODO：修改为一个版本成就
	32 => Array(
		'lvl' => 2,
		'name' => Array('0xFFFFFFFFFFFFFFFF','kernel on chessboard'),
        'title' => Array('117'),
        'c1' => Array(0),
        'c2' => Array(0),
	),
	
	# 日常任务
	# 混进来一个生涯成就：累计完成每日任务1/10/100/1001次
	600 => Array(
		'lvl' => 4,
		'name' => Array('新篇','十日談','百言詩','一千零一夜','尾聲？'),
        'title' => Array('','','118','119'),
		'request' => '累計完成次數：[:request:]次',
        'c1' => Array(1,10,101,1001),
        'c2' => Array(1,10,101,1001),
		'desc' => Array( 
			'累計完成1次<span class="sienna">每日挑戰</span>',
			'累計完成10次<span class="sienna">每日挑戰</span>',
			'累計完成100次<span class="sienna">每日挑戰</span>',
			'累計完成1001次<span class="sienna">每日挑戰</span>',
		),
	),
	# 日常任务1：击杀10名NPC
	601 => Array(
		'lvl' => 1,
		'daily' => 1,
		'name' => Array('蜂羣71'),
        'title' => Array(''),
        'c1' => Array(150),
        'c2' => Array(0),
		'desc' => Array( 
			'擊殺10名NPC',
		),
	),
	# 日常任务2：击杀1名活跃玩家
	602 => Array(
		'lvl' => 1,
		'daily' => 1,
		'name' => Array('觸手71'),
		'title' => Array(''),
		'c1' => Array(0),
		'c2' => Array(150),
		'desc' => Array( 
			"擊殺1名<span class=\"sienna\" tooltip=\"什麼是活躍玩家？\r總之小號是不行的！\">活躍玩家</span>",
		),
	),
	# 日常任务3：达成一次解禁/解离结局
	603 => Array(
		'lvl' => 1,
		'daily' => 1,
		'name' => Array('尖兵71'),
		'title' => Array(''),
		'c1' => Array(250),
		'c2' => Array(0),
		'desc' => Array( 
			'達成結局：<span class="sienna">鎖定解除</span>或<span class="sienna">幻境解離</span>',
		),
	),
	# 日常任务4：开启一次死斗模式
	604 => Array(
		'lvl' => 1,
		'daily' => 1,
		'name' => Array('榮耀71'),
		'title' => Array(''),
		'c1' => Array(250),
		'c2' => Array(0),
		'desc' => Array( 
			'開啓1次<span class="sienna">死鬥模式</span>',
		),
	),
	# 日常任务5：击杀10名种火
	605 => Array(
		'lvl' => 1,
		'daily' => 1,
		'name' => Array('循環71'),
		'title' => Array(''),
		'c1' => Array(177),
		'c2' => Array(0),
		'desc' => Array( 
			'擊殺10名<span class="sienna">種火</span>',
		),
	),
	# 日常任务6：以毒药/陷阱的方式击杀1名活跃玩家
	606 => Array(
		'lvl' => 1,
		'daily' => 1,
		'name' => Array('偏門71'),
		'title' => Array(''),
		'c1' => Array(0),
		'c2' => Array(188),
		'desc' => Array( 
			'使用<span class="sienna">毒性補給</span>或<span class="sienna">陷阱</span>殺死1名活躍玩家',
		),
	),
	# 日常任务7：使用凸眼鱼一次吸收20具尸体
	607 => Array(
		'lvl' => 1,
		'daily' => 1,
		'name' => Array('暴食71'),
		'title' => Array(''),
		'c1' => Array(0),
		'c2' => Array(155),
		'desc' => Array( 
			'使用道具<span class="sienna">凸眼魚</span>一次性吸收20具屍體',
		),
	),
	# 日常任务8：使用移动PC解除一次禁区
	608 => Array(
		'lvl' => 1,
		'daily' => 1,
		'name' => Array('無月71'),
		'title' => Array(''),
		'c1' => Array(155),
		'c2' => Array(0),
		'desc' => Array( 
			'使用道具<span class="sienna">移動PC</span>解除1次禁區',
		),
	),
	# 日常任务9：合成一次KEY系催泪弹
	609 => Array(
		'lvl' => 1,
		'daily' => 1,
		'name' => Array('雕像71'),
		'title' => Array(''),
		'c1' => Array(233),
		'c2' => Array(0),
		'desc' => Array( 
			'合成道具<span class="sienna">【KEY系催淚彈】</span>1次',
		),
	),
	# 日常任务10：使用一次歌唱功能
	610 => Array(
		'lvl' => 1,
		'daily' => 1,
		'name' => Array('搖滾71'),
		'title' => Array(''),
		'c1' => Array(0),
		'c2' => Array(233),
		'desc' => Array( 
			'使用一次<span class="sienna">歌唱</span>功能',
		),
	),
);

?>