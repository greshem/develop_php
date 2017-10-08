<?php
/*
* ÑéÖ¤Âë´úÂë
*/
session_start();
for ($i=0;$i<4;$i++)
{
$randstr.=dechex( rand(1,15) );
}
$randstr="qianzhongjie";
//echo $rand;
$im = ImageCreate (100,100);
$background = imagecolorallocate($im, 125, 255, 255);
$fontcolor = imagecolorallocate($im, 0, 0, 0);
imagestring($im,6,rand(1,25),rand(1,5),$randstr, $fontcolor);
header("Content-type: image/jpeg");
imagejpeg($im);
?>
