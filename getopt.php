#!/usr/bin/php
<?
	$opt=getopt("f:hp:");
	if(isset($opt{"h"}))
	{
		echo "This: is the \n";	
	}
	else
	{
		echo "Usage: ".$argv[0]." -f file.txt -h -p port\n";
	}
	//if($opt{"f"}
?>
