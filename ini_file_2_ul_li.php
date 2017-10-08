<?php
if( ! isset($argv[1]))
{
	die("Usage: ".$argv[0]." file.ini\n");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>new_html </title>
</head>
<style>
* { border:0px;
	border-style:solid;
}
ul {
/*width:200px;*/
list-style:none outside none;
}

</style>
<body>
	<strong><font>test.html</font></strong>

<?
$array=parse_ini_file($argv[1], 1);
//print_r($array);
//print_r(array_unique(array_keys($array)));



?>
<ul style="border:1px;border-style:solid;width:200px;">

<?
foreach (array_unique(array_keys($array)) as $sect)

{

	print "\t<li style=\"width:200px;\">\n";
	print "\t$sect\n";
	print "\t<ul>\n";
	foreach ( array_unique(array_keys($array[$sect]) ) as $iniKey)
	{
		//print "\t".$iniKey."=". 	$array[$sect][$iniKey]."\n";
		print "\t\t<li>".$iniKey."</li>\n";
	}
	print "\t</ul>\n";
	print "\t</li>\n";
	
}
print "</ul>\n";

?>
</body>
</html>

