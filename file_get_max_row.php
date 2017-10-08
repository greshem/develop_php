<?php
$b=file_get_contents("/etc/passwd");
$c=preg_replace("/:/", " ", $b);
if(! file_put_contents("passwd.txt", $c))
{
	die("passwd.txt cann't create , È¨ÏÞ´íÎó\n");
}
//$b=preg_replace("/__/","\n",$a);
echo get_max_row_file("passwd.txt");
function get_max_row_file($file)
{
		$tmp =file_get_contents($file);
		$lines=split("\n", $tmp);
		return get_max_row($lines);

}
function get_max_row($array)
{
	if(! is_array($array))
	{
		return -1;
	}
	$max=0;
	foreach ($array as $line)
	{
		$array=preg_split("/\s+/", $line);
		if(count($array) > $max)
		{
			$max=count($array);
		}
	}
	return $max;
}
?>

