# OSCE MCQ Combat Integration

Clinical MCQs replace the **first attack** of an encounter when the player’s place maps to a topic in `gamedata/osce-br-mcq-bank.json` (58 locations / 98 questions).

## Map

The classic BR map was remade for OSCE:

- `$plsinfo` / `$xyinfo` in `gamedata/cache/resources_1.php` — **58 places** (ids `0..57`)
- Authoritative index: `gamedata/osce-map-places.json` (`location` = bank simplified name, `display` = 繁體 in-game name, `topicId`)
- Classic 菁英服 cores (诊所, 清水池, 墓地, …) plus satellites (诊所B/C, 消防署C, 墓地A, 观音堂侧, …)

Every `map[].location` in the bank exists as a real place id.

## Behaviour

1. On encounter, if the place has a topic and this enemy was not already quizzed, battle UI shows **【OSCE 臨床問答】** with 4 buttons.
2. POST `mode=revcombat` + `command=osce_answer_0` … `osce_answer_3` via `command.php`.
3. **Correct** → ~25–40 dmg to enemy; **wrong** → ~20–30 dmg to player. 繁體 log + English rationale.
4. One MCQ per enemy encounter, then normal combat. Escape (`back`) always allowed.

## Files

| File | Role |
|---|---|
| `include/osce_mcq.func.php` | Bank load, place→topic, pick Q, resolve + damage |
| `include/game/revbattle.func.php` | Hooks in `revbattle_prepare` / `findenemy_rev` |
| `templates/default/battlecmd_rev.htm` | MCQ buttons |
| `gamedata/osce-br-mcq-bank.json` | Question bank |
| `gamedata/osce-map-places.json` | Place id ↔ location ↔ topic |
| `gamedata/cache/resources_1.php` | Remade `$plsinfo` / `$xyinfo` |

## In-game trigger

1. Enter the game.
2. Move to any OSCE place (e.g. **診所** id 0, **清水池** id 3, **診所B** id 29).
3. Search until you meet an enemy → answer the MCQ.

## Smoke test outline

Login → enter → set `pls` + `action=enemy` + `bid` → `command.php` `mode=revcombat&command=chase` → POST `osce_answer_*` → verify HP in DB / JSON log.
