<?php
if(!defined('IN_GAME')) exit('Access Denied');

# 套装相关配置文件

# 套装部件登记：（部位 → 装备名 → 对应套装编号）
$set_items = Array
(
	'wep' => Array
	(
		'節操炸彈' => 'jc',
		'寂寞' => 'jm',
		'幻之刃' => 'fan',
		'幻之使魔' => 'fan',
		'永恆之桶' => 'ete',
		'新華里的投入' => 'xhl',
		'新華里的震撼' => 'xhl',
		'新華里的亂舞' => 'xhl',
		'新華里的手勢' => 'xhl',
		'新華里的吶喊' => 'xhl',
		'新華里的眼神' => 'xhl',
	),

	'arb' => Array
	(
		'節操' => 'jc',
		'幻之甲' => 'fan',
		'永恆之甲' => 'ete',
		'新華里的西服' => 'xhl',
		'✦✦✦烈篝火' => 'fs2',
		'★華篝火★' => 'fs3',
		'☾真篝火☽' => 'fs4',
		'☼篝火☼' => 'fs5',
	),

	'arh' => Array
	(
		'節操' => 'jc',
		'寂寞' => 'jm',
		'幻之盔' => 'fan',
		'永恆之盔' => 'ete',
		'新華里的領帶' => 'xhl',
		'✦✦✦烈埋火' => 'fs2',
		'★華埋火★' => 'fs3',
		'☾真埋火☽' => 'fs4',
		'☼埋火☼' => 'fs5',
	),

	'ara' => Array
	(
		'節操' => 'jc',
		'寂寞' => 'jm',
		'幻之手鐲' => 'fan',
		'永恆之手鐲' => 'ete',
		'新華里的手錶' => 'xhl',
		'✦✦✦烈殘火' => 'fs2',
		'★華殘火★' => 'fs3',
		'☾真殘火☽' => 'fs4',
		'☼殘火☼' => 'fs5',
	),

	'arf' => Array
	(
		'節操' => 'jc',
		'寂寞' => 'jm',
		'幻之靴' => 'fan',
		'永恆之靴' => 'ete',
		'新華里的皮鞋' => 'xhl',
		'✦✦✦烈永火' => 'fs2',
		'★華永火★' => 'fs3',
		'☾真永火☽' => 'fs4',
		'☼永火☼' => 'fs5',
	),

	'art' => Array
	(
		'節操' => 'jc',
		'新華里的增員' => 'xhl',
	),
);

# 套装登记：
$set_items_info = Array
(
	'jc' => Array
	(
		// 套装名：
		'name' => '有節操！',
		// 套装组件上下限
		'active' => Array(1,6),
		// 套装奖励：
		// 套装奖励介绍：
	),
	'jm' => Array
	(
		'name' => '是寂寞...',
		'active' => Array(1,4),
	),
	'xhl' => Array
	(
		'name' => '業務員',
		'active' => Array(1,6),
	),
	'fan' => Array
	(
		'name' => '幻想之遺',
		'active' => Array(1,5),
	),
	'ete' => Array
	(
		'name' => '永恆之物',
		'active' => Array(1,5),
	),
	'fs2' => Array
	(
		'name' => '種火Ⅰ',
		'active' => Array(1,4),
	),
	'fs3' => Array
	(
		'name' => '種火Ⅱ',
		'active' => Array(1,4),
	),
	'fs4' => Array
	(
		'name' => '種火Ⅲ',
		'active' => Array(1,4),
	),
	'fs5' => Array
	(
		'name' => '種火Ⅳ',
		'active' => Array(1,4),
	),
);


?>
