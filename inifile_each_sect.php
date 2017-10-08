<?php
function	keys($value)
{
	$retKey=array();
	foreach($value as $key=>$value)
	{
		array_push($retKey, $key);
	}
	return $retKey;
}

$array=range(1,100);

$array=parse_ini_file("petty.ini", 1);
print_r($array);
print "############keys \n";
print_r(array_unique(array_keys($array)));

foreach (array_unique(array_keys($array)) as $sect)
{
	print "[$sect]\n";
	foreach ( array_unique(array_keys($array[$sect]) ) as $iniKey)
	{
		print "\t".$iniKey."=". 	$array[$sect][$iniKey]."\n";
	}
}
	

?>
