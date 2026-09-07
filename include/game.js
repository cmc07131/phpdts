function hotkey(evt)
{
	if(document.activeElement.tagName != 'INPUT'){
		evt = (evt) ? evt : ((window.event) ? window.event : '');
		var ky = evt.keyCode ? evt.keyCode : evt.which;
		if(!evt.ctrlKey && !evt.altKey && !evt.shiftKey){
			if(ky==90){
				$('submit').click();
			}
		}
	}
}

//update time
function updateTime(timing,mode)
{
	if(timing){
		t = timing;
		tm = mode;
		h = Math.floor(t/3600);
		m = Math.floor((t%3600)/60);
		s = t%60;
		// add a zero in front of numbers<10
		h=checkTime(h);
		m=checkTime(m);
		s=checkTime(s);
		$('timing').innerHTML = h + ':' + m + ':' +s;
		tm ? t++ : t--;
		setTimeout("updateTime(t,tm)",1000);
	}
	else{
		window.location.reload();
	}
}


function demiSecTimer(){
	if($('timer') && ms>=itv)	{
		ms -= itv;
		var sec = Math.floor(ms/1000);
		var dsec = Math.floor((ms%1000)/100);
		$('timer').innerHTML = sec + '.' + dsec;
	}	else {
		clearInterval(timerid);
		delete timerid;
	}
}

function demiSecTimerStarter(msec){
	itv = 100;//by millisecend
	ms = msec;
	timerid = setInterval("demiSecTimer()",itv);
}

function itemmixchooser(){
	for(i=1;i<=6;i++){
		var mname = 'mitm'+i;
		if($(mname) != null){
			if($(mname).checked){
				$(mname).value=i;
			}
		}
	}
}

//icon select
//function iconMover(){
//	gd = document.valid.gender[0].checked ? 'm' : 'f';
//	inum = document.valid.icon.selectedIndex;
//	$('iconImg').innerHTML = '<img src="img/' + gd + '_' + inum + '.gif" alt="' + inum + '">';
//}
function userIconMover(){
	ugd = $('male').checked ? 'm' : 'f';
	uinum = $('icon').value; // 使用value而不是selectedIndex

	// 檢查是否在RuleSet房間中
	if (typeof window.rulesetAvatarPath !== 'undefined' && window.rulesetAvatarPath) {
		$('userIconImg').innerHTML = '<img src="' + window.rulesetAvatarPath + ugd + '_' + uinum + '.gif" alt="' + uinum + '">';
	} else {
		$('userIconImg').innerHTML = '<img src="img/' + ugd + '_' + uinum + '.gif" alt="' + uinum + '">';
	}
}
function dniconMover(){
	dngd = $('male').checked ? 'm' : 'f';
	dninum = $('dnicon').selectedIndex;
	$('dniconImg').innerHTML = '<img src="img/' + dngd + '_' + dninum + '.gif" alt="' + dninum + '">';
}

function showNotice(sNotice) {
	$('notice').innerText = sNotice;
}

function sl(id) {
	$(id).checked = true;
}

//function postCommand(){
//	$('submit').disabled = true;
//	var oXmlHttp = zXmlHttp.createRequest();
//	var sBody = getRequestBody(document.forms['gamecmd']);
//	oXmlHttp.open("post", "command.php", true);
//	oXmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//	oXmlHttp.onreadystatechange = function () {
//		if (oXmlHttp.readyState == 4) {
//			if (oXmlHttp.status == 200) {
//				showGamedata(oXmlHttp.responseText);
//				$('submit').disabled = false;
//			} else {
//				showNotice(oXmlHttp.statusText);
//			}
//		}
//	};
//	oXmlHttp.send(sBody);
//}
//
//function showGamedata(sGamedata){
//	gamedata = sGamedata.parseJSON();
//	if(gamedata['url']) {
//		window.location.href = gamedata['url'];
//	} else if(!gamedata['main']) {
//		//window.location.href = 'index.php';
//		$('notice').innerHTML = sGamedata;
//	}
//	//timer = 0;
//	for(var id in gamedata) {
//		if(id == 'toJSONString' || id == 'timer') {
//			continue;
//		} else if(gamedata[id]){
//			if(id == 'team'){
//				$('team').value = gamedata['team'];
//			}else{
//				$(id).innerHTML = gamedata[id];
//			}
//		} else{
//			$(id).innerHTML = '';
//		}
//
//	}
//	if(gamedata['timer'] && typeof(timerid)=='undefined'){
//		demiSecTimerStarter(gamedata['timer']);
//	}
//}

//function postRegCommand(){
//	$('post').disabled = true;
//	$('reset').disabled = true;
//	var oXmlHttp = zXmlHttp.createRequest();
//	var sBody = getRequestBody(document.forms['reg']);
//	oXmlHttp.open("post", "register.php", true);
//	oXmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//	oXmlHttp.onreadystatechange = function () {
//		if (oXmlHttp.readyState == 4) {
//			if (oXmlHttp.status == 200) {
//				$('post').disabled = false;
//				$('reset').disabled = false;
//				showRegdata(oXmlHttp.responseText);
//			} else {
//				showNotice(oXmlHttp.statusText);
//			}
//		}
//	};
//	oXmlHttp.send(sBody);
//}
//
//function showRegdata(sRegdata){
//	regdata = sRegdata.parseJSON();
//	for(var id in regdata) {
//		if(id == 'toJSONString') {
//			continue;
//		} else if(regdata[id]){
//			$(id).innerHTML = regdata[id];
//		} else{
//			$(id).innerHTML = '';
//		}
//	}
//}

//function showNews(n){
//	var oXmlHttp = zXmlHttp.createRequest();
//
//	oXmlHttp.open("post", "news.php", true);
//	oXmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//	oXmlHttp.onreadystatechange = function () {
//		if (oXmlHttp.readyState == 4) {
//			if (oXmlHttp.status == 200) {
//				showNewsdata(oXmlHttp.responseText);
//			} else {
//				showNotice(oXmlHttp.statusText);
//			}
//		}
//	};
//	oXmlHttp.send('newsmode=' + n);
//}
//
//function showNewsdata(newsdata) {
//	news = newsdata.parseJSON();
//	if(news['msg']){
//		newchat = '';
//		for(var nid in news['msg']) {
//			if(nid == 'toJSONString') {continue;}
//			newchat += news['msg'][nid];
//		}
//		$('newsinfo').innerHTML = newchat;
//	} else {
//		$('newsinfo').innerHTML = news;
//	}
//}

//function showAlive(mode){
//	//window.location.href = 'alive.php?alivemode=' + mode;
//
//	var oXmlHttp = zXmlHttp.createRequest();
//
//	oXmlHttp.open("post", "alive.php", true);
//	oXmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//	oXmlHttp.onreadystatechange = function () {
//		if (oXmlHttp.readyState == 4) {
//			if (oXmlHttp.status == 200) {
//				showAlivedata(oXmlHttp.responseText);
//			} else {
//				showNotice(oXmlHttp.statusText);
//			}
//		}
//	};
//	oXmlHttp.send('alivemode=' + mode);
//}
//function showAlivedata(alivedata) {
//	alive = alivedata.parseJSON();
//	$('alivelist').innerHTML = alive;
//}

function postCmd(formName,sendto){
	console.log('%c正在提交命令', 'background: blue; color: white; font-size: 16px;');
	console.log('表單名稱: ' + formName + ', 發送到: ' + sendto);

	try {
		var oXmlHttp = zXmlHttp.createRequest();
		var formElement = document.forms[formName];

		if (!formElement) {
			console.error('找不到表單: ' + formName);
			alert('找不到表單: ' + formName);
			return;
		}

		var sBody = getRequestBody(formElement);
		console.log('請求體: ' + sBody);

		oXmlHttp.open("post", sendto, true);
		oXmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		oXmlHttp.onreadystatechange = function () {
			console.log('請求狀態變化: ' + oXmlHttp.readyState);

			if (oXmlHttp.readyState == 4) {
				console.log('請求完成，狀態碼: ' + oXmlHttp.status);

				if (oXmlHttp.status == 200) {
					console.log('請求成功，響應長度: ' + oXmlHttp.responseText.length);
					try {
						showData(oXmlHttp.responseText);
					} catch (e) {
						console.error('處理響應時出錯: ' + e.message);
						alert('處理響應時出錯: ' + e.message);
					}
				} else {
					console.error('請求失敗: ' + oXmlHttp.statusText);
					showNotice(oXmlHttp.statusText);
				}
			}
		}

		console.log('發送請求...');
		oXmlHttp.send(sBody);
		console.log('請求已發送');
	} catch (e) {
		console.error('發送請求時出錯: ' + e.message);
		alert('發送請求時出錯: ' + e.message);
	}
}

function showData(sdata){
	console.log('%c正在處理響應數據', 'background: green; color: white; font-size: 16px;');

	try {
		// 嘗試解析 JSON
		console.log('響應數據片段: ' + sdata.substring(0, 100) + '...');
		shwData = sdata.parseJSON();
		console.log('解析後的數據類型: ' + typeof(shwData));

		// 檢查是否需要重定向
		if(shwData['url']) {
			console.log('需要重定向到: ' + shwData['url']);
			window.location.href = shwData['url'];
		} else if(!shwData['innerHTML']) {
			console.log('沒有 innerHTML 屬性，顯示原始數據');
			if($('error')) {
				$('error').innerHTML = sdata;
			} else {
				console.error('error 元素不存在');
				alert('錯誤: ' + sdata);
			}
		} else {
			console.log('處理 innerHTML 和其他屬性');

			// 處理 value 屬性
			if(shwData['value']) {
				sDv = shwData['value'];
				console.log('value 屬性的鍵數量: ' + Object.keys(sDv).length);

				for(var id in sDv){
					if($(id)!=null){
						console.log('設置 ' + id + ' 的 value 為: ' + sDv[id]);
						$(id).value = sDv[id];
					} else {
						console.warn('元素 ' + id + ' 不存在，無法設置 value');
					}
				}
			}

			// 處理 innerHTML 屬性
			if(shwData['innerHTML']) {
				sDi = shwData['innerHTML'];
				console.log('innerHTML 屬性的鍵數量: ' + Object.keys(sDi).length);

				for(var id in sDi){
					if($(id)!=null){
						if(sDi[id] !== ''){
							console.log('設置 ' + id + ' 的 innerHTML，長度: ' + sDi[id].length);
							$(id).innerHTML = sDi[id];
						} else {
							console.log('清空 ' + id + ' 的 innerHTML');
							$(id).innerHTML = '';
						}
					} else {
						console.warn('元素 ' + id + ' 不存在，無法設置 innerHTML');
					}
				}
			}

			// 同步clbpara驅動的側邊欄數據
			if(shwData['clbpara']) {
				window.clbpara_data = shwData['clbpara'];
				window.clbpara = shwData['clbpara'];
				if(typeof updateQuestPanel === 'function') {
					updateQuestPanel();
				}
				if(typeof updateChargeProgressBars === 'function') {
					updateChargeProgressBars();
				}
				if(typeof updateFireseedTab === 'function') {
					updateFireseedTab();
				}
			}

			// 處理 display 屬性
			if(shwData['display']) {
				sDd = shwData['display'];
				console.log('display 屬性的鍵數量: ' + Object.keys(sDd).length);

				for(var id in sDd){
					if($(id)!=null){
						console.log('設置 ' + id + ' 的 display 為: ' + sDd[id]);
						$(id).style.display = sDd[id];
					} else {
						console.warn('元素 ' + id + ' 不存在，無法設置 display');
					}
				}
			}
		}

		// 處理計時器
		if(shwData['timer'] && typeof(timerid)=='undefined'){
			console.log('啓動計時器: ' + shwData['timer']);
			demiSecTimerStarter(shwData['timer']);
		}

		// 處理頁面刷新
		if ($('HsUipfcGhU')) {
			console.log('檢測到頁面刷新標記，即將刷新頁面');
			window.location.reload();
		}

		console.log('響應數據處理完成');
	} catch (e) {
		console.error('處理響應數據時出錯: ' + e.message);
		console.error('原始數據: ' + sdata);
		alert('處理響應數據時出錯: ' + e.message);

		// 嘗試顯示原始數據
		if($('error')) {
			$('error').innerHTML = '<div style="color: red; background-color: yellow; padding: 10px; border: 2px solid black;">錯誤: ' + e.message + '<br>原始數據: ' + sdata + '</div>';
		}
	}
}

var refchat = null;

function chat(mode,reftime) {
	clearTimeout(refchat);
	var oXmlHttp = zXmlHttp.createRequest();
	var sBody = getRequestBody(document.forms['sendchat']);
	oXmlHttp.open("post", "chat.php", true);
	oXmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	oXmlHttp.onreadystatechange = function () {
		if (oXmlHttp.readyState == 4) {
			if (oXmlHttp.status == 200) {
				showChatdata(oXmlHttp.responseText);
			} else {
				showNotice(oXmlHttp.statusText);
			}
		}
	};
	oXmlHttp.send(sBody);
	if(mode == 'send'){$('chatmsg').value = '';$('sendmode').value = 'ref';}
	rtime = reftime;
	refchat = setTimeout("chat('ref',rtime)",rtime);
}


function showChatdata(jsonchat) {
	chatdata = jsonchat.parseJSON();
	if(chatdata['msg']) {
		$('lastcid').value=chatdata['lastcid'];
		newchat = '';
		for(var cid in chatdata['msg']) {
			if(cid == 'toJSONString') {continue;}
			newchat += chatdata['msg'][cid];
		}
		$('chatlist').innerHTML = newchat + $('chatlist').innerHTML;
	}
}

function openShutManager(oSourceObj,oTargetObj,shutAble,oOpenTip,oShutTip){
	var sourceObj = typeof oSourceObj == "string" ? document.getElementById(oSourceObj) : oSourceObj;
	var targetObj = typeof oTargetObj == "string" ? document.getElementById(oTargetObj) : oTargetObj;
	var openTip = oOpenTip || "";
	var shutTip = oShutTip || "";
	if(targetObj.style.display!="none"){
	   if(shutAble) return;
	   targetObj.style.display="none";
	   if(openTip  &&  shutTip){
	    sourceObj.innerHTML = shutTip;
	   }
	} else {
	   targetObj.style.display="block";
	   if(openTip  &&  shutTip){
	    sourceObj.innerHTML = openTip;
	   }
	}
}

//1
