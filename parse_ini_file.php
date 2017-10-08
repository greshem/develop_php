<?php

//$array=parse_ini_file("petty.ini", 1);

//$array=parse_ini_file("/usr/share/rtiosrv/disk.ini", 1);
//$array=parse_ini_file("/usr/share/rtiosrv/dskgroup.ini", 1);
//$array=parse_ini_file("/usr/share/rtiosrv/graphmenu.ini", 1);
//$array=parse_ini_file("/usr/share/rtiosrv/hwc.ini", 1);
//$array=parse_ini_file("/usr/share/rtiosrv/option.ini", 1);
//$array=parse_ini_file("/usr/share/rtiosrv/recov.ini", 1);
$array=parse_ini_file("/usr/share/rtiosrv/server.ini", 1);
//$array=parse_ini_file("/usr/share/rtiosrv/wks.ini", 1);
//$array=parse_ini_file("/usr/share/rtiosrv/wksgroup.ini", 1);



//print_r($array);
//print_r(array_unique(array_keys($array)));

foreach (array_unique(array_keys($array)) as $sect)
{
	print "[$sect]\n";
	foreach ( array_unique(array_keys($array[$sect]) ) as $iniKey)
	{
		//print "\t".$iniKey."=". 	$array[$sect][$iniKey]."\n";
		print $iniKey."=". 	$array[$sect][$iniKey]."\n";
	}
}
	

?>
