<?
foreach (glob("/etc/*") as $line)
{
	echo $line,"->", basename($line),"\n";
}
?>
