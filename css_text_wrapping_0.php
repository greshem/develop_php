<?
	$img=imagecreate(100,100);
	$color=imagecolorallocate($img, 200,200,200);
	imagejpeg($img, "gray.jpg");
	imagedestroy($img);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>new_html </title>
</head>

<body>
<div style="width:250;">

<img src="gray.jpg" style="display:inline;float:left">
	<?php 

		$text=shell_exec("/root/random_things/rand_article");
		echo $text;
	?>
</div>
</body>
</html>

