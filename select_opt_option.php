<?php 
function print_ini_array_to_select_opt_str($ini)
{
	//$sects= array_keys($ini);
	$str="<select >\n ";	
	foreach ( $ini as $key=> $item)
	{
		if(is_array($item))
		{
	//		print "[$key]\n";
			$str.="<optgroup label=".$key.">\n";

			foreach ($item as $key2 => $value2)
			{
	//			print "\t".$key2."=".$value2."\n";
				$str.= "\t<option value=".$key2.">".$value2."</option>\n";

			}
			$str.="</optgroup>\n";
		}
		else
		{
	//		print $key."=".$item."\n";
			$str.=$key."=".$item."\n";
		}
	}
	$str.="</select>\n";
	return $str;
}
//

$array=parse_ini_file("test.ini", 1);

print_ini_array_to_select_opt_str($array);

?>
