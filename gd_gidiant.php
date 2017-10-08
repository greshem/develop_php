<?php
////$strimgsrc = file_get_contents("http://127.0.0.1/5307754.jpg");
//$imgsrc = imagecreatefromstring("wenshuna");
$imgsrc = imageCreateFromJpeg("test.jpg");
$imgsrcw = imageSX($imgsrc);
$imgsrch = imageSY($imgsrc);

$width = 30;
$x1 = 2;
$x2 = $imgsrcw - $x1 - 20;
$y1 = ($imgsrch - $width) - 2;
$y2 = $y1 + $width;

$steps = $x2 - $x1;
for($i = 0; $i < $steps; $i ++)
{
        $alphaX = round($i/($steps/127))+60;
        if($alphaX >= 128)
                $alphaX = 127;
        $alpha = imagecolorallocatealpha($imgsrc, 255, 255, 255, $alphaX);
        imagefilledrectangle($imgsrc, ($i+$x1), $y1, ($i+$x1+1), $y2, $alpha);
}


header('Content-type: image/jpeg');

imagejpeg($imgsrc, "test_giadiant.jpg");
imagedestroy($imgsrc);
?>
