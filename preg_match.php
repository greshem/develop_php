#!/usr/bin/php
<?
//20100317, qzj
//��ͬ��PERL�Ĵ���
//$array=grep { -f &&/conf$/} (</etc/*>);
//��ȻPERL�ļ򵥶��ˡ� 
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

