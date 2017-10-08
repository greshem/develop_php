#!/usr/bin/php
<?
	if(! is_dir("images/"))
	{
		mkdir("images/");
	}
	$im=imagecreate(100,100);
	//$white=imagecolorallocate($im, 255, 255,255);
	$gray=imagecolorallocate($im, 111, 111,111);
	$black=imagecolorallocate($im, 0, 0,0);

	//font	默认的字体是 1 2 3 4 5 
	//	
	// for($i=1; $i<=5; $i++)
	// {
	// 	imagestring($im, $i, 10, 10*$i, "no product", $black);
	// }
	imagestring($im, 5, 10, 10*5, "no product", $black);

	imagejpeg($im, "images/no_image.jpg");

	echo "<table >\n";	
	for($i=0; $i<=4; $i++)
	{
		echo "<tr>\n";
		for($j=0; $j<=4; $j++)
		{
			echo "\t<td > <img src=images/no_image.jpg > </td>\n";
		}
		echo "</tr>\n";

	}
	echo "</table>\n";
?>
