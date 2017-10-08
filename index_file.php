<html>
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
		if(is_file($file))
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

?>
</ul>
</body>
</html>
