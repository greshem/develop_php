<?

file_sed("passwd", "root", "qianzhongjie");
function file_sed($file, $pattern, $dest)
{
	$tmp=file_get_contents($file);
	$out=preg_replace("/^$pattern.*\n/i", "$dest\n", $tmp);
	echo $out;
	file_put_contents($file, $tmp);
}
?>
