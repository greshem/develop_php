<?php 
	function print_ini_array_to_table($ini)
	{
		//$sects= array_keys($ini);
		//$str="<select >\n ";	
		$str="<table border=0> \n";
		foreach ( $ini as $key=> $item)
		{
			if(is_array($item))
			{
		//		print "[$key]\n";

				$count=count($item);
				$count++;
				$str.="\t<tr><td rowspan=".$count."><strong>".$key."</strong></td><td></td><td></td></tr>\n";
				foreach ($item as $key2 => $value2)
				{
		//			print "\t".$key2."=".$value2."\n";
					$str.= "\t\t<tr><td> ".$key2."</td><td>".$value2."</td></tr>\n";

				}
				//$str.="</tr>\n";
			}
			else
			{
		//		print $key."=".$item."\n";
		//	$str.=$key."=".$item."\n";
			}
		}
		$str.="</table>\n";
		//$str.="</select>\n";
		return $str;
	}
	
	if(isset($argv[1]))
	{
		$inifile = $argv[1];	
	}
	else
	{
		die($argv[0]."   file.ini\n");
	}

	$array=parse_ini_file($inifile);
	$str=print_ini_array_to_table($array);

	print $str;
	file_put_contents("log.html", $str);
?>
