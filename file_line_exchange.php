#!/usr/bin/php
<?
if(!$argv[1] && !$argv[2])
{
	echo "Usage: $argv[0] from_line to_line "; 
	exit(-1);
}
$from_line=$argv[1];
$to_line=$argv[2];

$tmp=file_get_contents("/tmp/passwd");
$arr=split("\n", $tmp);
$output=array_rand($arr);
#shuffle($arr);
$arr2=array_map('add_rf', $arr);
$count=count($arr2);
if( ($from_line > $count ) || ($to_line > $count))
{
	echo "Outof Range! \n Maxnumber $count\n";
	exit(2);
}
//exchange
$tmp=$arr2[$to_line];
$arr2[$to_line]=$arr2[$from_line];
$arr2[$from_line]=$tmp;
/*$fileStr;
foreach($arr as $line)
{
	if($line)
	{
	global $fileStr;
	$fileStr.=$line."\n";	
	#$fileStr.="aaa";
	}
}*/
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
