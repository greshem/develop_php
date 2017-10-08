<?php
#$depth1=$_GET['depth1'];
$tmp=file_get_contents("/tftpboot/pxelinux.cfg/default");

#$tmp2=nl2br($tmp);
#echo $tmp2;
$lines=split("\n", $tmp);
foreach ($lines as $line)
{
	if(preg_match("/^http/", $line))
	{
		echo "<a href=".$line.">".basename($line)."</a>";
		echo "<br>";
	}
	else if(preg_match("/label/i", $line))
	{
		echo "<h3>".$line."</h3>";
	}
	else
	{
		echo $line."<br>";
	}

}
?>
