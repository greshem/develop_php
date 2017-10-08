<html>
<? include("/var/www/html/login_session/index.php")?>
<body>

<ul>
<?
function get_array_file($dir)
{
	$dir=opendir($dir);
	$pic=array();
	while(false!=($file =readdir($dir)))      
	{
	#	print $file."\n";
		if(is_dir($file))
		{
		array_push($pic, $file);
		}
	}

	sort($pic);

	return $pic;
}

$a=get_array_file(".");
//$b=preg_grep("/php$/", $a);
sort($a);
foreach ($a as $value)
{
	echo"<li> <a target=_blank  href=".$value.">". $value."</a></li>\n";
}
echo "<li><a target=_blank href=index_file.php> index_file.php</a></li>\n";
?>
</ul>
</body>
</html>
