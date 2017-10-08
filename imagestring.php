<?php
//	#2010_08_06_12:18:01 add by qzj
	//创建图片。
	//用这个函数背景总是黑的。
	//$im=imagecreatetruecolor(100,100);
	
	//$bg=imagecolorallocate($im, 0,0,0);
	
	//$im=ImageCreate(100,100);
	$im=imagecreate(100,100);
	$black=imagecolorallocate($im, 125,255,0);
	$red=imagecolorallocate($im, 125,255,255);
	imagefill($im, 100, 100, $black);
	$textcolor=imagecolorallocate($im, 0,0,255);
	imagestring($im, 5, 0, 0, "Hello world! ", $textcolor);
	header("Content-type: image/jpg");
	imagejpeg($im);
?>
