<?php
//生成验证码图片
//@Header("Content-type: image/PNG");
srand((double)microtime()*1000000);
$im = imagecreate(62,20);
$black = ImageColorAllocate($im, 0,0,0);
$white = ImageColorAllocate($im, 255,255,255);
$gray = ImageColorAllocate($im, 200,200,200);
imagefill($im,0,0,$gray);
while(($authnum=rand()%100000)<10000);
//将四位整数验证码绘入图片
//$authnum_s=$authnum; 
//$_SESSION['authnum_s'] = $authnum;
imagestring($im, 5, 10, 3, $authnum, $black);
for($i=0;$i<200;$i++)//加入干扰象素 
{ 
    $randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
    imagesetpixel($im, rand()%70 , rand()%30 , $randcolor);
} 
ImagePNG($im);
//ImageJPG($im);
ImageDestroy($im);
?>
