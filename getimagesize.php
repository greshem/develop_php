#!/usr/bin/php
<?php
	if(isset($argv[1]))
	{
		$file=$argv[1];
	}
	else if(isset($_GET['img']))
	{
		$file=$_GET['img'];
	}
	if (! isset($file))
	{
		print("Usage: ".$argv[0]." image.file\n");
		foreach (glob("/usr/share/backgrounds/nature/*.jpg")  as $line)
		{
			print "php $argv[0]  $line \n";
		}	
	}
	
	$size=getimagesize($file);
	print_r($size);

	$width=$size[0];
	$height=$size[1];

	print "X=".$width."|"."Y=".$height."\n";
?>

<?php  
function  demo_output()
{
echo <<<EOF
	Array
	(
		[0] => 1600
		[1] => 1200
		[2] => 2
		[3] => width="1600" height="1200"
		[bits] => 8
		[channels] => 3
		[mime] => image/jpeg
	)
EOF;
}
?>

