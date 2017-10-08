#!/usr/bin/php
<?php

$create=0;
$delete=0;
$print=0;
$opt=getopt("cdp");
if(count($opt)==0)
{
	echo("Usage".$argv[0]." -c -d -p\n");
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

$array=parse_ini_file("petty.ini", 1);
if($print==1)
{
	print_r($array);
	print_r(array_unique(array_keys($array)));
}

//section 
foreach (array_unique(array_keys($array)) as $sect)
{
	//print "[$sect]\n";
	if($delete==1 && is_file($sect.".html"))
	{
		echo "rm -f ".$sect.".html\n";
	}	
	if($create==1)
	{
		if(! is_file( $sect.".html" ))
		{
			echo $sect.".html 创建文件\n";
			file_put_contents($sect.".html", $sect."   main page");
		}
	}
	foreach ( array_unique(array_keys($array[$sect]) ) as $iniKey)
	{

	//	print "\t".$iniKey."=". 	$array[$sect][$iniKey]."\n";
		$value= $array[$sect][$iniKey];
		if($delete==1 && is_file($sect."_".$iniKey.".html"))
		{
			#echo "rm -f ".$sect.".html\n";			
			echo "rm -f ".$sect."_".$iniKey.".html\n";
		}
		
		if($create==1)
		{
			if(!is_file( $sect."_".$iniKey.".html"))
			{
				echo $sect."_".$iniKey.".html 创建文件\n";
				file_put_contents($sect."_".$iniKey.".html", $sect."_".$iniKey."main page");
			}
		}

	}
}
	

?>
