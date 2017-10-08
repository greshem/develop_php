// php 用到的gd 的扩展. 修改
if (!extension_loaded('gd')) { return; } // No GD, so forget it.
					
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
$src_width   = imageSx($src_img);
$src_height  = imageSy($src_img);
$dest_width  = $src_width * ($cnvt_percent / 100);
$dest_height = $src_height * ($cnvt_percent / 100);
if (gdVersion() >= 2) {
	$dst_img = imageCreateTruecolor($dest_width, $dest_height);
	imageCopyResampled($dst_img, $src_img, 0, 0, 0, 0,
		$dest_width, $dest_height, $src_width, $src_height);
} else {
	$dst_img = imageCreate($dest_width, $dest_height);
	imageCopyResized($dst_img, $src_img, 0, 0, 0, 0,
		$dest_width, $dest_height, $src_width, $src_height);
}
imageDestroy($src_img);
if (eregi('\.jpg$|\.jpeg$', $img_file) == TRUE
	&& (imageTypes() & IMG_JPG) == TRUE)
{
	imageJpeg($dst_img, $out_file, $cnvrt_arry['qual']);
} elseif (eregi('\.png$', $img_file) == TRUE
	&& (imageTypes() & IMG_PNG) == TRUE)
{
	imagePng($dst_img, $out_file);
} elseif (eregi('\.gif$', $img_file) == TRUE
	&& (imageTypes() & IMG_GIF) == TRUE)
{
	imageGif($dst_img, $out_file);
}
imageDestroy($dst_img);
