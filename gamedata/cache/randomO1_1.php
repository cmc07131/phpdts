<?php
if(!defined('IN_GAME')) exit('Access Denied');

//杂项1福袋 - O1
//防具，经验书，强化药，补给
//SPECIAL TECH 「特选科技」
//(0-50)itmlow
//(51-75)itmmedium
//(76-98)itmhigh
//(99-100)antimeta 

$itmlow = <<<EOT
臉,HB,60,998,,
灼眼頭盔,DH,601,15,ZUC,
漂水盔甲,DB,602,15,ZEG,
疾風手套,DA,603,15,ZKq,
裂地跑鞋,DF,604,15,ZIW,
奇特數據,VV,101,1,,
勇氣數據,MA,151,1,,
防衞數據,MD,142,3,,
EOT;

$itmmedium = <<<EOT
【Poini Kune的死庫水】,DB,5,5,Bb,
【Madoka的死庫水】,DB,10,10,AB,
【Erul Tron的泳裝】,DB,30,30,b,
【空羽亞乃亞的泳裝】,DB,30,30,a,
【Tita Nium的泳裝】,DB,25,25,Aa,
【Emon 5的沙灘短褲】,DB,99999,1,,
奇特數據,VV,101,2,,
勇氣數據,MA,151,2,,
防衞數據,MD,142,6,,
大臉,HB,300,998,,
EOT;

$itmhigh = <<<EOT
毆系速成書,VP,251,2,,
斬系速成書,VK,252,2,,
射系速成書,VG,253,2,,
投系速成書,VC,254,2,,
爆系速成書,VD,255,2,,
靈系速成書,VF,256,2,,
蝙蝠俠速成書,VV,1234,1,,
超人藥,ME,1234,1,,
大圓臉,HB,666,998,,
EOT;

$antimeta = <<<EOT
隨機數之神的庇佑,Z,1,1,Zz
EOT;
?>