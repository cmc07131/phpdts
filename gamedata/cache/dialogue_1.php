<?php
if(!defined('IN_GAME')) exit('Access Denied');

# 对话框相关配置文件：
# 用法：在行动中加入 $clbpara['dialogue'] = '单组对白名'; 行动后便会自动跳出对话框。默认情况下，对话框可以直接点击外侧窗口关闭（即跳过）；
# 如果想要生成不能跳过（比如存在选择肢）的对话框，加入 $clbpara['noskip_dialogue'] = 1；

# 单组对白：
$dialogues = Array
(
	//仅作演示用
	'thiphase' => Array
	(
		0 => '在你唱出那單一的旋律的霎那，<br>整個虛擬世界起了翻天覆地的變化……',
		1 => '世界響應着這旋律，產生了異變……<br>因為破滅之歌的作用，全部鎖定被打破了！',
		2 => '在下一個瞬間——像是受到電磁干擾般，<br>你的戰術界面突然變得花白一片。',
		3 => '<span class="grey">“……防火牆……已……<br>……請到……山丘上……來……”</span>',
		4 => '什麼？',
		5 => '沒等你反應過來，那位不速之客便已切斷了通訊。<br>你呆望着恢復如常的界面，試圖釐清這段語焉不詳的訊息究竟有何含義……',
	),
	// Time for this to be used!
	'club21entry' => Array
	(
		0 => '你將這個蛋狀物捧在手心，<br>你發現它上面並沒有什麼開關或縫隙。',
		1 => '正在你覺得是不是買到了個玩笑的時候。<br>蛋突然破成了四瓣！<br>隨後從蛋中冒出來大量灰黑色，青藍色，深紫色的像絲帶一樣的東西，<br>向着你的心口直刺而來！',
		2 => '你猝不及防，被這些絲帶一樣的東西擊中，頓時，大量的數據塞滿了你的大腦！<br>你頭像炸開一樣，不禁蹲躺了下去……',
		3 => '<span class="grey">🎶Ρжжηψψρип ρип, ρжжηψψρжжρип ρип<br>
		ρψψρип ρип, ρип ρип ρжжηψψρжж ρδ<br>
		ρжжηψψρип ρип, ρжжηψψρжжρип ρип<br>
		ρψψρип ρип, ρип ρип ρжжηψψρжж ρδ🎶<br></span>
		<span class="glitch1">“開開心心感嘆號，<br>
		搞搞弄弄真快活！<br>
		此地猶如三重彩，<br>
		不愧吾等折騰多！”<br></span>
		<span class="grey">🎶Ρжжηψψρип ρип, ρжжηψψρжжρип ρип<br>
		ρψψρип ρип, ρип ρип ρжжηψψρжж ρδ<br>
		ρжжηψψρип ρип, ρжжηψψρжжρип ρип<br>
		ρψψρип ρип, ρип ρип ρжжηψψρжж ρδ🎶<br></span>',
		4 => '你似乎看到了，聽到了，感覺到了一個模糊的場景，<br>但你不知道這是什麼。',
		5 => '大量類似的場景掠過你的腦海，而你已經無力吸收。<br>你渾身疼痛，不禁口吐鮮血，無助地等待着一切結束。',
	),
	'club22entry' => Array
	(
		0 => '你打開了這本筆記本，<br>上面空無一物，<br>但你卻感覺有聲音進入了你的腦海……<br>你的意識在被一些非「你」之物所佔據……',
		1 => '這就是你正在尋找的……<br>種火……的力量嗎？<br>那麼總之……<br>去尋找他們吧！',
	),

	//NPC Platform Usage
	'npcplatform' => Array
	(
		0 => '你將這個按鈕部署在了地上，它擴張成了一個平台。<br>你毅然地站了進去。',
		1 => '你看着腳底下的使用説明，將腳放在了平台邊緣的按鈕上，<br>將其按下。',
		2 => '剎那間，七彩的光束從平台湧動而出，將你淹沒。',
		3 => '你感覺你的一切都被讀取，扭曲，改寫。<br>血液在翻滾，內臟在舞動，意識在傾瀉。<br>你甚至已經有了一種你不是你自己的錯覺。',
		4 => '隨着光束散去，平台也憑空消失。<br>留下的只有一位嶄新的你。',
		5 => '希望……這真的值得。',
	),

	//TESTING ONLY - DELETE THIS WHEN DEPLOYING
	'testingDialog' => Array
	(
		0 => '這是測試對話第一頁',
		1 => '這是測試對話第二頁',
		2 => '現在給出選擇支',
	),

	// 带选择的测试对话
	'choiceTestingDialog' => Array
	(
		0 => '這是帶選擇的測試對話第一頁',
		1 => '這是帶選擇的測試對話第二頁',
		2 => '請選擇下面的選項：',
	),

	// RuleSet开场剧情
	'opening' => Array
	(
		0 => '歡迎來到遊戲世界！',
		1 => '在這裏，你將體驗到精彩的大逃殺玩法。',
		2 => '準備好開始你的冒險了嗎？',
	),
);

# 单组对白中哪一页对话会显示头像：
$dialogue_icon = Array
(
	'thiphase' => Array
	(
		//第三页时会显示头像
		3 => 'img/n_0.gif',
	),
);

# 单组对白结束时关闭对话框候显示的log
$dialogue_log = Array
(
	'thiphase' => "<span class='lime'>※ 權限重載完成，控制模塊已解鎖。</span><br>……這又是什麼時候的事？<br><br>",
	'club21entry' => "<span class='yellow'>雖然打開了蛋，但你被其中的<span class='glitchb'>數據風暴</span>狂暴吸入，受到了大量的傷害！</span><br>你屁滾尿流地重新站了起來。<br><br>",
	'testingDialog' => "<span class='yellow'>測試已結束！</span><br><br>",
	'choiceTestingDialog' => "<span class='yellow'>選擇測試已結束！</span><br><br>",
	'choiceTestingDialog_choice_0' => "<span class='yellow'>你選擇了選項A！</span><br>這是選項A的結果。<br><br>",
	'choiceTestingDialog_choice_1' => "<span class='yellow'>你選擇了選項B！</span><br>這是選項B的結果。<br><br>",
	'choiceTestingDialog_choice_2' => "<span class='yellow'>你選擇了選項C！</span><br>這是選項C的結果。<br><br>",
	'club22entry' => "<span class='yellow'>你獲得了收納種火的力量！</span><br>作為開始，去尋找種火的殘骸吧……<br><br>",
	'opening' => "<span class='lime'>※ 遊戲開始！</span><br>願你在這個世界中找到屬於自己的道路。<br><br>",
);

# 单组对白结束时提供选择肢：
$dialogue_branch = Array
(
	'testingDialog' => Array(
		//0 => '选项A',
		//1 => '选项B',
		//2 => '选项C',
		//3 => '选项A',
		//4 => '选项B',
		//5 => '选项C',
		'選項A','選項B','選項C',
	),
	'choiceTestingDialog' => Array(
		'選項A','選項B','選項C',
	),
);

# 单组对白结束提供特殊结束按钮（非必须、仅在结束对白会触发特殊事件时调用）：
$dialogue_ending = Array
(

);


?>
