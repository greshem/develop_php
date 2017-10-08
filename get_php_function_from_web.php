#!/usr/bin/php
<?
if(!isset($argv[1]))
{
	echo "Usage: $argv[0]  funciont";
	exit(-1);
}
$function=$argv[1];

echo "http://www.php.net/".$function,"\n";
?>
