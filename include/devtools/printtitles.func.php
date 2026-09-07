<?php

function print_titles_list()
{
	global $checkstr,$exit;
	# 将旧成就数据格式转为新格式
	require config('achievement',1);
	$t_file = config('titles',$gamecfg);
	if(!file_exists($t_file))
	{
		$tarr = Array();
		foreach($ach_list as $akey => $alist)
		{
			if(!empty($alist['title']))
			{
				foreach($alist['title'] as $at)
				{
					if(!in_array($at,$tarr)) $tarr[] = $at;
				}
			}
		}
		$cont = '';
		$cont = str_replace('?>','',str_replace('<?','<?php',$checkstr));
		$cont .= '$titles = ' . var_export($tarr,1).";\r\n?>";
		writeover($t_file, $cont);
		chmod($t_file,0777);
		echo "成功生成了頭銜列表。<br>".$exit;
	}
	else 
	{
		echo "頭銜名列表已存在，如需要重新生成，請刪除{$t_file}後再次打開本頁面。<br>".$exit;
	}
}

?>
