#!/usr/bin/php
<?php

$create=0;
$delete=0;
$print=0;
$opt=getopt("cdp");
if(count($opt)==0)
{
	echo ("Usage".$argv[0]."-c -d -p\n");
	echo "-c create -d delete  -p print\n";
	die();
}
if(isset($opt{"c"}))
{
	$create=1;
}

if(isset($opt{"d"}))
{
	$delete=1;
}

if(isset($opt{"p"}))
{
	$print=1;
}

$array=parse_ini_file("petty.ini", 0);

if($print==1)
{
	print_r($array);
}

foreach ($array as $file=>$value)
{
	if(is_file($file.".html"))
	{
		if($delete==1)
		{
			echo "rm -f ".$file.".html\n";
		}
	}
	else
	{
	
		echo $file.".html �ļ� ������\n";
		if($create==1)
		{
			echo $file.".html �����ļ�\n";
			file_put_contents($file.".html", " $file main page");
		}
	}
}
#print "############keys \n";
#print_r(array_unique(array_keys($array)));

	

?>
