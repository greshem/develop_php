<?php
//2010_07_29_13:23:50 add by qzj
if(isset ($_GET['in']))
{
	$in=$_GET['in'];
}
else
{
	$in="/";
}
//$file =$_GET['file'];
#if(! preg_match("/^\/tmp3/", $depth1))
#{
#	$depth1="/tmp3/sf_mirror/".$depth1;
#}
if(is_dir($in))
{
	foreach (glob($in."/*") as $depth2)
	{
		if( is_dir( $depth2) )
		{
			echo "<img src=/icons/folder.gif>  <a href=".$_SERVER['PHP_SELF']."?in=".$depth2.">".$depth2."</a>\n";
			echo "<br>\n";
		}
		if( is_file($depth2))
		{
			
			echo "<img src=/icons/text.gif > <a href=".$_SERVER['PHP_SELF']."?in=".$depth2.">".$depth2."</a>\n";
			echo "<br>\n";
		}
	}
}
else
{
	$tmp=file_get_contents($in);
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
		else
		{
			echo $line."<br>";
		}

	}
}
?>
