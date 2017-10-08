#!/usr/bin/php
<?

$words;

if( ! isset($argv[1]))
{
	die("Usage: ".$argv[0]." input.txt\n");
}

$file=$argv[1];
$tmp= file_get_contents( $argv[1]);

$arr=split("\n", $tmp);

foreach ($arr as $line)
{
	$tmp=preg_split("/\s+/", $line);
	for($i=0; $i<count($tmp); $i++)
	{
		if(! isset($words[$tmp[$i]]))
		{
			$words[$tmp[$i]]=1;
		}
		else
		{
			$words[$tmp[$i]]++;
		}
	}
}

print_r($words);
// foreach ($word  $key=>$value)
// {
// 	echo $key.
// }

?>

