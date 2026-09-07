<?php

if (! defined ( 'IN_GAME' )) {
	exit ( 'Access Denied' );
}

// Handle skill book items
function item_skillbook($itmn, &$data) {
	global $log, $nosta, $cskills, $now;
	extract($data, EXTR_REFS);
	
	$itm = & ${'itm' . $itmn};
	$itmk = & ${'itmk' . $itmn};
	$itme = & ${'itme' . $itmn};
	$itms = & ${'itms' . $itmn};
	$itmsk = & ${'itmsk' . $itmn};
	
	$skill_minimum = 100;
	$skill_limit = 380;
	$log .= "你閲讀了<span class=\"red\">$itm</span>。<br>";
	$dice = rand(-10, 10);
	if (strpos($itmk, 'VV') === 0) {
		//global $wp, $wk, $wg, $wc, $wd, $wf;
		$ws_sum = $wp + $wk + $wg + $wc + $wd + $wf;
		if ($ws_sum < $skill_minimum * 5) {
			$vefct = $itme;
		} elseif ($ws_sum < $skill_limit * 5) {
			$vefct = round($itme * (1 - ($ws_sum - $skill_minimum * 5) / ($skill_limit * 5 - $skill_minimum * 5)));
		} else {
			$vefct = 0;
		}
		if ($vefct < 10) {
			if ($vefct < $dice) {
				$vefct = -$dice;
			}
		}
		$wp += $vefct; //$itme;
		$wk += $vefct; //$itme;
		$wg += $vefct; //$itme;
		$wc += $vefct; //$itme;
		$wd += $vefct; //$itme; 
		$wf += $vefct; //$itme;
		$wsname = "全系熟練度";
	} elseif (strpos($itmk, 'VP') === 0) {
		//global $wp;
		if ($wp < $skill_minimum) {
			$vefct = $itme;
		} elseif ($wp < $skill_limit) {
			$vefct = round($itme * (1 - ($wp - $skill_minimum) / ($skill_limit - $skill_minimum)));
		} else {
			$vefct = 0;
		}
		if ($vefct < 10) {
			if ($vefct < $dice) {
				$vefct = -$dice;
			}
		}
		$wp += $vefct; //$itme;
		$wsname = "鬥毆熟練度";
	} elseif (strpos($itmk, 'VK') === 0) {
		//global $wk;
		if ($wk < $skill_minimum) {
			$vefct = $itme;
		} elseif ($wk < $skill_limit) {
			$vefct = round($itme * (1 - ($wk - $skill_minimum) / ($skill_limit - $skill_minimum)));
		} else {
			$vefct = 0;
		}
		if ($vefct < 10) {
			if ($vefct < $dice) {
				$vefct = -$dice;
			}
		}
		$wk += $vefct; //$itme; 
		$wsname = "斬刺熟練度";
	} elseif (strpos($itmk, 'VG') === 0) {
		//global $wg;
		if ($wg < $skill_minimum) {
			$vefct = $itme;
		} elseif ($wg < $skill_limit) {
			$vefct = round($itme * (1 - ($wg - $skill_minimum) / ($skill_limit - $skill_minimum)));
		} else {
			$vefct = 0;
		}
		if ($vefct < 10) {
			if ($vefct < $dice) {
				$vefct = -$dice;
			}
		}
		$wg += $vefct; //$itme; 
		$wsname = "射擊熟練度";
	} elseif (strpos($itmk, 'VC') === 0) {
		//global $wc;
		if ($wc < $skill_minimum) {
			$vefct = $itme;
		} elseif ($wc < $skill_limit) {
			$vefct = round($itme * (1 - ($wc - $skill_minimum) / ($skill_limit - $skill_minimum)));
		} else {
			$vefct = 0;
		}
		if ($vefct < 10) {
			if ($vefct < $dice) {
				$vefct = -$dice;
			}
		}
		$wc += $vefct; //$itme; 
		$wsname = "投擲熟練度";
	} elseif (strpos($itmk, 'VD') === 0) {
		//global $wd;
		if ($wd < $skill_minimum) {
			$vefct = $itme;
		} elseif ($wd < $skill_limit) {
			$vefct = round($itme * (1 - ($wd - $skill_minimum) / ($skill_limit - $skill_minimum)));
		} else {
			$vefct = 0;
		}
		if ($vefct < 10) {
			if ($vefct < $dice) {
				$vefct = -$dice;
			}
		}
		$wd += $vefct; //$itme; 
		$wsname = "引爆熟練度";
	} elseif (strpos($itmk, 'VF') === 0) {
		//global $wf;
		if ($wf < $skill_minimum) {
			$vefct = $itme;
		} elseif ($wf < $skill_limit) {
			$vefct = round($itme * (1 - ($wf - $skill_minimum) / ($skill_limit - $skill_minimum)));
		} else {
			$vefct = 0;
		}
		if ($vefct < 10) {
			if ($vefct < $dice) {
				$vefct = -$dice;
			}
		}
		$wf += $vefct; //$itme; 
		$wsname = "靈擊熟練度";
	} elseif (strpos($itmk, 'VS') === 0) {
		//global $cskills,$clbpara;
		if(!empty($itmsk) && isset($cskills[$itmsk]))
		{

			$flag = getclubskill($itmsk,$clbpara);
			if($flag)
			{
				$log.="哇！沒想到這本書裏竟然介紹了<span class='yellow'>「{$cskills[$itmsk]['name']}」</span>的原理！<br>獲得了技能<span class='yellow'>「{$cskills[$itmsk]['name']}」</span>！<br>你心滿意足地把<span class='red'>{$itm}</span>吃進了肚裏。<br>";
				addnews($now,'getsk_'.$itmsk,$name,$itm,$nick);
			}
			else 
			{
				$log.="什麼嘛！原來裏面都是些你看過的東西了，你沒有從書中學到任何新東西。<br>你一怒之下把這本破書撕了個稀巴爛！<br>";
			}
		}
		else 
		{
			$log.="但是你橫看豎看，也弄不明白作者到底想表達什麼！<br>你一怒之下把這本破書撕了個稀巴爛！<br>";
		}
	}
	if(isset($vefct))
	{
		if ($vefct > 0) {
			$log .= "嗯，有所收穫。<br>你的{$wsname}提高了<span class=\"yellow\">$vefct</span>點！<br>";
		} elseif ($vefct == 0) {
			$log .= "對你來説書裏的內容過於簡單了。<br>你的熟練度沒有任何提升。<br>";
		} else {
			$vefct = -$vefct;
			$log .= "對你來説書裏的內容過於簡單了。<br>而且由於盲目相信書上的知識，你反而被編寫者的紕漏所誤導了！<br>你的{$wsname}下降了<span class=\"red\">$vefct</span>點！<br>";
		}
	}
	if ($itms != $nosta) {
		$itms --;
		if ($itms <= 0) {
			$log .= "<span class=\"red\">$itm</span>用光了。<br>";
			$itm = $itmk = $itmsk = '';
			$itme = $itms = 0;
		}
	}
}
