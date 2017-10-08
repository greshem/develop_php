#!/usr/bin/php
<?
$tmp=file_get_contents("/tmp/passwd");
$arr=split("\n", $tmp);
$output=array_rand($arr);
shuffle($arr);
$arr2=array_map('add_rf', $arr);
$fileStr;
foreach($arr as $line)
{
	if($line)
	{
	global $fileStr;
	$fileStr.=$line."\n";	
	#$fileStr.="aaa";
	}
}
#file_put_contents("/tmp/passwd2", $fileStr);
file_put_contents("/tmp/passwd2", $arr2);
function add_rf($in)
{
	if($in)
	{
	return ($in."\n");
	}
}
?>
