<?
include("func.php");
file_sed(".config", "CONFIG_PCNET32=", "CONFIG_PCNET32=y");
#file_sed(".config", "CONFIG_PCNET32_NAPI=", "CONFIG_PCNET32_NAPI=y");
#file_sed(".config", "CONFIG_MII=", "CONFIG_MII=y");

#file_sed("test", "CONFIG_PCNET32=", "CONFIG_PCNET32=y");
function file_sed($file, $pattern, $dest)
{
	$tmp=file_get_contents($file);
	#echo $tmp;
	$out=preg_replace("/$pattern.*\n/i", "$dest\n", $tmp);
	#echo $out;
	file_put_contents(".config", $out);
}
?>
