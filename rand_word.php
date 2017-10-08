<?
	//#2010_08_26_22:05:33 add by qzj
	$file=fopen("/usr/share/dict/linux.words", "r");
	fseek($file, 0, SEEK_END);

	$length=ftell($file);
//	print $length."\n";
	$size=filesize ("/usr/share/dict/linux.words");
//	print $size."\n";
	assert($length==$size);
	
//	echo rand(0, $size);

	fseek($file, rand(0, $length));
	
	fgets($file, 1024);
	$a=fgets($file, 1024);
	fclose($file);
	$result=str_replace("-", "_", $a);
	print $result;
	
?>
