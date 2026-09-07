<?php
/**
 * OSCE MCQ combat helper
 * Correct answer → damage enemy; wrong → damage player.
 * Bank: gamedata/osce-br-mcq-bank.json
 */

if (!defined('IN_GAME')) {
	exit('Access Denied');
}

define('OSCE_MCQ_BANK_PATH', GAME_ROOT . './gamedata/osce-br-mcq-bank.json');
define('OSCE_MCQ_DMG_ENEMY_MIN', 25);
define('OSCE_MCQ_DMG_ENEMY_MAX', 40);
define('OSCE_MCQ_DMG_PLAYER_MIN', 20);
define('OSCE_MCQ_DMG_PLAYER_MAX', 30);

/**
 * Current-map / traditional aliases → bank location key (simplified).
 * Bank locations that already exist on the live map (清水池, 墓地) need no alias.
 */
function osce_mcq_place_aliases()
{
	// Traditional display names + any extra stand-ins → bank simplified location key.
	// Built from gamedata/osce-map-places.json when present; otherwise empty.
	static $aliases = null;
	if ($aliases !== null) return $aliases;
	$aliases = array();
	$mapfile = GAME_ROOT . './gamedata/osce-map-places.json';
	if (is_readable($mapfile)) {
		$data = json_decode(file_get_contents($mapfile), true);
		if (!empty($data['places']) && is_array($data['places'])) {
			foreach ($data['places'] as $row) {
				if (empty($row['location'])) continue;
				$canon = $row['location'];
				if (!empty($row['display']) && $row['display'] !== $canon) {
					$aliases[$row['display']] = $canon;
				}
				// identity kept via bank map; alias self for clarity
				$aliases[$canon] = $canon;
			}
		}
	}
	return $aliases;
}

function osce_mcq_load_bank()
{
	static $bank = null;
	if ($bank !== null) return $bank;
	$bank = array('meta' => array(), 'map' => array(), 'questions' => array(), 'loc2topic' => array());
	$path = OSCE_MCQ_BANK_PATH;
	if (!is_readable($path)) return $bank;
	$raw = file_get_contents($path);
	$data = json_decode($raw, true);
	if (!is_array($data)) return $bank;
	$bank['meta'] = isset($data['meta']) ? $data['meta'] : array();
	$bank['map'] = isset($data['map']) ? $data['map'] : array();
	$bank['questions'] = isset($data['questions']) ? $data['questions'] : array();
	$loc2topic = array();
	$id2topic = array();
	foreach ($bank['map'] as $idx => $row) {
		if (empty($row['location']) || empty($row['topicId'])) continue;
		$loc2topic[$row['location']] = $row['topicId'];
		$id2topic[$idx] = $row['topicId'];
	}
	// Overlay place-id map from osce-map-places.json (authoritative remade map)
	$mapfile = GAME_ROOT . './gamedata/osce-map-places.json';
	if (is_readable($mapfile)) {
		$pmap = json_decode(file_get_contents($mapfile), true);
		if (!empty($pmap['places']) && is_array($pmap['places'])) {
			foreach ($pmap['places'] as $row) {
				if (!isset($row['id']) || empty($row['topicId'])) continue;
				$id2topic[intval($row['id'])] = $row['topicId'];
				if (!empty($row['location'])) $loc2topic[$row['location']] = $row['topicId'];
				if (!empty($row['display'])) $loc2topic[$row['display']] = $row['topicId'];
			}
		}
	}
	foreach (osce_mcq_place_aliases() as $alias => $canon) {
		if (isset($loc2topic[$canon])) {
			$loc2topic[$alias] = $loc2topic[$canon];
		}
	}
	$bank['loc2topic'] = $loc2topic;
	$bank['id2topic'] = $id2topic;
	return $bank;
}

function osce_mcq_place_name($pls = null)
{
	global $plsinfo, $hplsinfo, $pgroup;
	if ($pls === null) {
		global $pls;
	}
	if (isset($plsinfo[$pls])) return $plsinfo[$pls];
	if (isset($hplsinfo[$pgroup][$pls])) return $hplsinfo[$pgroup][$pls];
	return '';
}

function osce_mcq_topic_for_place($pls = null)
{
	$bank = osce_mcq_load_bank();
	if ($pls === null) {
		global $pls;
	}
	if (isset($bank['id2topic'][intval($pls)])) {
		return $bank['id2topic'][intval($pls)];
	}
	$name = osce_mcq_place_name($pls);
	if ($name !== '' && isset($bank['loc2topic'][$name])) {
		return $bank['loc2topic'][$name];
	}
	return '';
}

function osce_mcq_ensure_clbpara(&$data)
{
	if (!isset($data['clbpara']) || !is_array($data['clbpara'])) {
		$data['clbpara'] = get_clbpara(isset($data['clbpara']) ? $data['clbpara'] : '');
	} else {
		$data['clbpara'] = get_clbpara($data['clbpara']);
	}
}

function osce_mcq_answered_ids(&$data, $topicId)
{
	osce_mcq_ensure_clbpara($data);
	if (empty($data['clbpara']['osce_answered'][$topicId]) || !is_array($data['clbpara']['osce_answered'][$topicId])) {
		return array();
	}
	return $data['clbpara']['osce_answered'][$topicId];
}

function osce_mcq_mark_answered(&$data, $topicId, $qid)
{
	osce_mcq_ensure_clbpara($data);
	if (!isset($data['clbpara']['osce_answered']) || !is_array($data['clbpara']['osce_answered'])) {
		$data['clbpara']['osce_answered'] = array();
	}
	if (!isset($data['clbpara']['osce_answered'][$topicId]) || !is_array($data['clbpara']['osce_answered'][$topicId])) {
		$data['clbpara']['osce_answered'][$topicId] = array();
	}
	if (!in_array($qid, $data['clbpara']['osce_answered'][$topicId], true)) {
		$data['clbpara']['osce_answered'][$topicId][] = $qid;
	}
}

function osce_mcq_pick_question($topicId, &$data)
{
	$bank = osce_mcq_load_bank();
	if (empty($bank['questions'][$topicId]) || !is_array($bank['questions'][$topicId])) {
		return null;
	}
	$pool = $bank['questions'][$topicId];
	$answered = osce_mcq_answered_ids($data, $topicId);
	$unanswered = array();
	foreach ($pool as $q) {
		if (empty($q['id'])) continue;
		if (!in_array($q['id'], $answered, true)) $unanswered[] = $q;
	}
	$use = !empty($unanswered) ? $unanswered : $pool;
	$pick = $use[array_rand($use)];
	return $pick;
}

/**
 * Whether this encounter should show/force an OSCE MCQ (once per encounter).
 */
function osce_mcq_should_force(&$data, &$edata)
{
	$topicId = osce_mcq_topic_for_place(isset($data['pls']) ? $data['pls'] : null);
	if ($topicId === '') return false;
	osce_mcq_ensure_clbpara($data);
	$done_bid = isset($data['clbpara']['osce_done_bid']) ? intval($data['clbpara']['osce_done_bid']) : 0;
	if ($done_bid && $done_bid === intval($edata['pid'])) return false;
	return true;
}

/**
 * Start / refresh pending MCQ for current encounter. Returns battle-state array or empty.
 */
function osce_mcq_get_battle_state(&$data, &$edata)
{
	if (!osce_mcq_should_force($data, $edata) && empty($data['clbpara']['osce_mcq'])) {
		return array();
	}
	osce_mcq_ensure_clbpara($data);
	$pending = isset($data['clbpara']['osce_mcq']) ? $data['clbpara']['osce_mcq'] : null;
	if (is_array($pending) && !empty($pending['qid']) && intval($pending['enemy_pid']) === intval($edata['pid'])) {
		return osce_mcq_format_state($pending);
	}
	$topicId = osce_mcq_topic_for_place(isset($data['pls']) ? $data['pls'] : null);
	if ($topicId === '') return array();
	$q = osce_mcq_pick_question($topicId, $data);
	if (!$q) return array();
	$pending = array(
		'topicId' => $topicId,
		'qid' => $q['id'],
		'stem' => isset($q['stem']) ? $q['stem'] : '',
		'options' => isset($q['options']) && is_array($q['options']) ? array_values($q['options']) : array(),
		'correct' => isset($q['correct']) ? intval($q['correct']) : 0,
		'rationale' => isset($q['rationale']) ? $q['rationale'] : '',
		'enemy_pid' => intval($edata['pid']),
		'enemy_name' => isset($edata['name']) ? $edata['name'] : '',
	);
	$data['clbpara']['osce_mcq'] = $pending;
	return osce_mcq_format_state($pending);
}

function osce_mcq_format_state($pending)
{
	$opts = isset($pending['options']) ? $pending['options'] : array();
	while (count($opts) < 4) $opts[] = '—';
	return array(
		'topicId' => $pending['topicId'],
		'qid' => $pending['qid'],
		'stem' => $pending['stem'],
		'options' => array_slice($opts, 0, 4),
		'enemy_name' => isset($pending['enemy_name']) ? $pending['enemy_name'] : '',
	);
}

function osce_mcq_clear_pending(&$data, $mark_done_bid = 0)
{
	osce_mcq_ensure_clbpara($data);
	unset($data['clbpara']['osce_mcq']);
	if ($mark_done_bid) {
		$data['clbpara']['osce_done_bid'] = intval($mark_done_bid);
	}
}

function osce_mcq_roll_damage($for_enemy)
{
	if ($for_enemy) {
		return mt_rand(OSCE_MCQ_DMG_ENEMY_MIN, OSCE_MCQ_DMG_ENEMY_MAX);
	}
	return mt_rand(OSCE_MCQ_DMG_PLAYER_MIN, OSCE_MCQ_DMG_PLAYER_MAX);
}

/**
 * Resolve player answer. Returns:
 *  1 = continue encounter (findenemy_rev)
 *  2 = battle ended (corpse / death / leave)
 *  0 = invalid / redisplay
 */
function osce_mcq_handle_answer($answer_idx, &$data, &$edata)
{
	global $log, $mode, $main, $cmd;
	include_once GAME_ROOT . './include/state.func.php';

	osce_mcq_ensure_clbpara($data);
	$pending = isset($data['clbpara']['osce_mcq']) ? $data['clbpara']['osce_mcq'] : null;
	if (!is_array($pending) || empty($pending['qid'])) {
		$log .= '<span class="yellow">沒有待回答的 OSCE 題目。</span><br>';
		return 0;
	}
	if (intval($pending['enemy_pid']) !== intval($edata['pid'])) {
		$log .= '<span class="yellow">敵對目標已變更，OSCE 題目作廢。</span><br>';
		osce_mcq_clear_pending($data);
		return 0;
	}

	$answer_idx = intval($answer_idx);
	$correct = intval($pending['correct']);
	$rationale = isset($pending['rationale']) ? $pending['rationale'] : '';
	$qid = $pending['qid'];
	$topicId = $pending['topicId'];
	$enemy_name = isset($edata['name']) ? $edata['name'] : '敵人';

	osce_mcq_mark_answered($data, $topicId, $qid);
	osce_mcq_clear_pending($data, intval($edata['pid']));

	$place = osce_mcq_place_name(isset($data['pls']) ? $data['pls'] : null);
	$log .= '<span class="lime">【OSCE MCQ】</span> 地點「' . htmlspecialchars($place) . '」臨床問答（' . htmlspecialchars($qid) . '）<br>';

	if ($answer_idx === $correct) {
		$dmg = osce_mcq_roll_damage(true);
		$edata['hp'] = max(0, intval($edata['hp']) - $dmg);
		$log .= '<span class="yellow">回答正確！</span>你的臨床判斷命中了<span class="yellow">' . htmlspecialchars($enemy_name) . '</span>，造成 <span class="clan">' . $dmg . '</span> 點傷害！<br>';
		$log .= '<span class="grey">Rationale: ' . htmlspecialchars($rationale) . '</span><br>';
		player_save($edata);

		if ($edata['hp'] <= 0) {
			$data['nm'] = isset($data['name']) ? $data['name'] : '你';
			$edata['nm'] = $enemy_name;
			$log .= '<span class="red">' . htmlspecialchars($enemy_name) . '被你的正確臨床判斷擊敗了！</span><br>';
			$death_flag = 'N';
			$lastword = pre_kill_events($data, $edata, 1, $death_flag);
			$revival_flag = revive_process($data, $edata, 1);
			if (!$revival_flag) {
				final_kill_events($data, $edata, 1, $lastword);
			}
			player_save($edata);
			player_save($data);
			if ($edata['hp'] <= 0) {
				include_once GAME_ROOT . './include/game/battle.func.php';
				$data['action'] = 'corpse';
				$data['bid'] = $edata['pid'];
				findcorpse($edata);
				return 2;
			}
		}
	} else {
		$dmg = osce_mcq_roll_damage(false);
		$data['hp'] = max(0, intval($data['hp']) - $dmg);
		$log .= '<span class="red">回答錯誤！</span><span class="yellow">' . htmlspecialchars($enemy_name) . '</span>抓住了你的失誤，你受到 <span class="red">' . $dmg . '</span> 點傷害！<br>';
		$log .= '<span class="grey">Rationale: ' . htmlspecialchars($rationale) . '</span><br>';
		if ($data['hp'] <= 0) {
			$log .= '<span class="red">你因錯誤的臨床判斷而倒下了……</span><br>';
			death('event', $enemy_name, isset($edata['type']) ? $edata['type'] : 0, 'OSCE', $data);
			$data['action'] = '';
			$data['bid'] = 0;
			$mode = 'command';
			return 2;
		}
	}

	$mode = 'revcombat';
	return 1;
}

/**
 * True if command is an OSCE answer (osce_answer / osce_answer_0..3).
 */
function osce_mcq_parse_answer_command($command, $osce_answer = null)
{
	if ($osce_answer !== null && $osce_answer !== '' && is_numeric($osce_answer)) {
		return intval($osce_answer);
	}
	if (preg_match('/^osce_answer[_=]?([0-3])$/i', strval($command), $m)) {
		return intval($m[1]);
	}
	if ($command === 'osce_answer' && isset($GLOBALS['osce_answer']) && is_numeric($GLOBALS['osce_answer'])) {
		return intval($GLOBALS['osce_answer']);
	}
	return null;
}
