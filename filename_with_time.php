<?
#filemtime
function  gen_file_name_with_time($prefix, $suffix)
{
	$cur_time=strftime("%Y_%m_%d", time());	
	
	for($i=0;;$i++)
	{
		$filename=$prefix."_".$cur_time."_".$i.".".$suffix;
		if( ! file_exists($filename))
		{
			return $filename;
		}
	}
}

function touch_file($filename)
{
	file_put_contents($filename, $filename);
}

function must_be_exist($filename)
{
	if(! file_exists($filename))
	{
		echo $filename." ASSERT ERROR\n";
	}
}

for($i=0;$i<=100; $i++)
{
	$name=gen_file_name_with_time("back", "zip");
	print $name;
	touch_file($name);
	must_be_exist($name);	
}
?>
