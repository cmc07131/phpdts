<?php
if(!defined('IN_GAME')) exit('Access Denied');

//灵系福袋 - WF
//BORN FROM WISH 「幻想啼音」
//(0-50)itmlow
//(51-75)itmmedium
//(76-98)itmhigh
//(99-100)antimeta 

$itmlow = <<<EOT
臉,WF,60,12,d,
地獄「煉獄氣息」,WF,186,30,n,
傘符「細雪的過客」,WF,162,40,i,
水符「水色絨毯」,WF,115,60,,
秋符「落葉的疾風」,WF,121,55,,
魚符「魚的學校」,WF,95,78,,
御經「無限唸佛」,WF,72,111,w,
銃符「月之銃」,WF,76,99,,
EOT;

$itmmedium = <<<EOT
魔法「紫雲之兆」,WF,187,60,nd,
光符「淨化之魔」,WF,354,40,ed,
「信仰之針」,WF,288,80,pd,
神籤「犯規結界」,WF,404,80,d,
月見酒「瘋狂的九月」,WF,316,75,rwd,
EOT;

$itmhigh = <<<EOT
「信仰之山」,WF,1987,256,Zuwr,
「間斷的噩夢」,WF,1532,188,Zikr,
「運鈍根的捕物帳」,WF,840,256,Zkf,
EOT;

$antimeta = <<<EOT
隨機數之神的攝理,WF,88888,888,ZRx,
EOT;
?>