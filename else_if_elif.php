<?
#2011_02_20_21:03:26 add by greshem
$img_file="lnux.jpg";
if (eregi('\.jpg$|\.jpeg$', $img_file) == TRUE
	&& (imageTypes() & IMG_JPG) == TRUE)
{
//JPEG
	$src_img = imageCreateFromJpeg($in_file);
} elseif (eregi('\.png$', $img_file) == TRUE
	&& (imageTypes() & IMG_PNG) == TRUE)
{
	$src_img = imageCreateFromPng($in_file);
} elseif (eregi('\.gif$', $img_file) == TRUE
	&& (imageTypes() & IMG_GIF) == TRUE)
{
	$src_img = imageCreateFromGif($in_file);
} else {
	continue;
}

?>
