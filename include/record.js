//錄製處理
var recordedData = [];
var isRecording = true;
function startRecording() {
    isRecording = true;
    console.log('startRecording');
    window.alert('開始錄像，錄製中的遊戲數據會保留在瀏覽器內，請不要刷新或關閉該頁面。');
    // 監聽所有按鈕的點擊事件
    document.addEventListener('click', recordButtonClick);

    var linkElement = document.querySelector('a[onclick="startRecording()"]');
    if (linkElement) {
        linkElement.textContent = ">>停止錄像";
        linkElement.setAttribute('onclick', 'stopRecording()');
    }
}

document.addEventListener('click', recordButtonClick);

function stopRecording() {
    isRecording = false;

    var linkElement = document.querySelector('a[onclick="stopRecording()"]');
    if (linkElement) {
        linkElement.textContent = ">>開始錄像";
        linkElement.setAttribute('onclick', 'startRecording()');
    }

    // 停止監聽
    document.removeEventListener('click', recordButtonClick);
    //downloadRecordedData();
}

function downloadRecordedData() {
    var reader = new FileReader();
    reader.onload = function () {
        var arrayBuffer = reader.result;
        var uint8Array = new Uint8Array(arrayBuffer);
        var gzippedData = pako.gzip(uint8Array);
        var downloadLink = document.createElement("a");
        downloadLink.href = URL.createObjectURL(new Blob([gzippedData]));
        downloadLink.download = "recorded_data.html.gz";
        downloadLink.click();
    };
    reader.readAsArrayBuffer(new Blob(recordedData, { type: "text/html" }));
}

function recordButtonClick(event) {
    // 如果錄製狀態為 true，則將當前前端的全部靜態網頁數據保存到數組中
    if (isRecording) {
        recordedData.push(document.documentElement.outerHTML.concat("\n"));
        sendLastRecordedData(recordedData);
    }
}

function sendLastRecordedData(recordedData) {
    const nickinfoElement = document.getElementById('nickinfo');
    if (!nickinfoElement) {

        return;
    }


    const nickinfo = nickinfoElement.innerText;
    const lastRecord = recordedData[recordedData.length - 1];

    fetch('record_backend.php', {
        method: 'POST',
        body: JSON.stringify({ lastRecord, nickinfo }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            // 處理從後端返回的響應
            //console.log(data);
        })
        .catch(error => {
            // 處理錯誤
            console.error(error);
        });
}


