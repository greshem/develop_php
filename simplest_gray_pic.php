<?
	//#2010_08_20_12:04:37 add by qzj
	// 000 像炮弹， 所以是黑色的。 
	$img=imagecreate(100,100);
	$color=imagecolorallocate($img, 200,200,200);
	imagejpeg($img, "gray.jpg");
?>
