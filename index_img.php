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
		#if(is_dir($file))
		if(is_file($file))
		{
		array_push($pic, $file);
		}
	}

	sort($pic);

	return $pic;
}

$a=get_array_file(".");
$b=preg_grep("/gif$|jpg$|png$/", $a);
sort($b);
foreach ($b as $value)
{
	echo"<li> <img  src=".$value.">". $value."</li>\n";
}

?>
</ul>
</body>
</html>
