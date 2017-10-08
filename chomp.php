<?php
function chomp(&$string)
{
	if (is_array($string))
	{
		foreach ($string as $i=>$val)
		{
			$endchar=chomp($string[$i]);
		}
	}
	else
	{
		$endchar=substr($string, strlen($string)-1, 1);
		if($endchar=="\n")
		{
			$string=substr($string, 0, -1);
		}
	}
	
}
$cata=fopen("cata_cata_no_number","r") or die("file no exists\n");
$lang=fopen("cata_lang_no_number","r") or die ("file no exists\n");
$array_cata=array();
$array_lang=array();
while($line_lang=fgets($lang,1024))
{ 
	chomp($line_lang);
	array_push($array_lang, $line_lang);
}

while($line_cata=fgets($cata,1024))
{ 
	chomp($line_cata);
	array_push($array_cata, $line_cata);
}

foreach ( $array_lang as $each2)
{
	foreach ( $array_cata as $each)
	{
	echo $each2."---".$each,"\n";
	}
}
?>
