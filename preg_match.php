#!/usr/bin/php
<?
//20100317, qzj
//等同于PERL的代码
//$array=grep { -f &&/conf$/} (</etc/*>);
//当然PERL的简单多了。 
$file_arr=array();
function walk($value, $key)
{
	global $file_arr;
	if(is_file($value) &&preg_match("/conf$/", $value))
	{
		#echo $value,"\n";
		array_push($file_arr, $value);
	}
}
$a=glob("/etc/*");
array_walk($a, 'walk');

foreach ($file_arr as $file)
{
	print $file."\n";
}

?>

