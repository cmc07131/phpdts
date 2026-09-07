<?php
if(!defined('IN_GAME')) exit('Access Denied');

//斩系福袋 - WK
//PAVE THE WAY 「斩开前路」
//(0-50)itmlow
//(51-75)itmmedium
//(76-98)itmhigh
//(99-100)antimeta 

$itmlow = <<<EOT
臉,WK,60,12,,
死亡之吻,WK,221,20,n,
染血匕首,WK,181,40,w,
契約短劍,WK,161,80,,
失意背刺,WK,121,15,,
巨骨劍,WK,171,10,,
瓦明威,WK,161,100,r,
微縮斧劍,WKP,90,90,Zr,
EOT;

$itmmedium = <<<EOT
【狂暴兇刃】,WK,200,30,nd,
【紫色β大刀】,WK,460,20,e,
【翡翠騎士】,WK,480,40,p,
【念力刃】,WK,502,80,,
【花好月圓】,WK,478,15,rw,
【良辰美景】,WK,343,10,r,
【克拉姆·索萊斯】,WK,480,200,rui,
萬法破滅之符,WFK,180,180,Zrn,
EOT;

$itmhigh = <<<EOT
「碧海船歌」,WK,2222,256,Zuwdr,
「翼展」,WK,2777,188,Zfd,
「安謐」,WGK,1555,256,Zkw,
「午前許願」,WK,3877,158,Zikdr,
神之聖劍,WK,4788,480,Zkfd,
EOT;

$antimeta = <<<EOT
隨機數之神的聖劍,WK,88888,888,ZRx,
EOT;
?>