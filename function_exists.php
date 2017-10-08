<?php
	
function get_ini_file_sections($file)
{
	$ret=array();
	$array=parse_ini_file("petty.ini", 1);
	foreach (array_unique(array_keys($array)) as $sect)
	{
		#print "[$sect]\n";
		array_push($ret,  $sect);
	}
	return $ret;
}
if(! function_exists('get_ini_file_sections'))
{
	function get_ini_file_sections($file)
	{
		$ret=array();
		$array=parse_ini_file("petty.ini", 1);
		foreach (array_unique(array_keys($array)) as $sect)
		{
			#print "[$sect]\n";
			array_push($ret,  $sect);
		}

		return $ret;
	}
}

?>
