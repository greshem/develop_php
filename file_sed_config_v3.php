<?
# 20100507 4 post 
include("func.php");
$config= "CONFIG_PCNET32=";
foreach (array_keys($_REQUEST ) as $config)
{
	if(preg_match("/=/", $config))
	{
		file_sed(".config", $config, $config."=y");
	}
	else
	{	
		file_sed(".config", $config, $config."y");
	}
}
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
