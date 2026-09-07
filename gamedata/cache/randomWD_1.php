<?php
if(!defined('IN_GAME')) exit('Access Denied');

//爆系福袋 - WD
//SUDDEN BREAKER 「突然爆裂」
//(0-50)itmlow
//(51-75)itmmedium
//(76-98)itmhigh
//(99-100)antimeta 

$itmlow = <<<EOT
臉,WD,60,12,d,
晨輝爆彈,WD,221,30,dn,
日蝕機雷,WD,181,40,dw,
光子火箭,WDG,161,60,d,
離子播散器,WD,121,55,d,
氫氣地雷,TN,600,1,,
破陣地雷,TN,300,5,,
連環地雷,TN,150,10,,
EOT;

$itmmedium = <<<EOT
【陣列撕裂者】,WD,200,60,nd,
【震撼火箭彈】,WD,460,40,ed,
【彗星發射器】,WD,480,80,pd,
【獵頭炸藥】,WD,502,80,d,
【災難尖刺】,WD,323,75,rwd,
【怨靈之瓶】,TN,2022,3,,
【單人用娛樂火箭】,TN,2503,2,,
【漢諾的崇高力量】,TN,3333,3,Z,
EOT;

$itmhigh = <<<EOT
「喧囂敍事曲」,WD,2222,256,Zuwdr,
「昇天」,WD,2777,188,Zikdr,
「曳光」,WD,1555,256,Zkfd,
「人生重來箱」,TN,9997,8,Z,
「菁英宅之怒」,TN,1333337,1,Z,
EOT;

$antimeta = <<<EOT
隨機數之神的震撼,WD,88888,888,ZRdx,
隨機數之神的惡戲,TN8,8,88888,Z,
EOT;
?>