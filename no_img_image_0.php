#!/usr/bin/php
<?
//������֤��ͼƬ

#2010_08_18_11:21:10 add by qzj

if(! is_dir("images"))
{
	mkdir("images/");
}
if(is_file("images/no_img.png"))
{
	echo " images/no_img.png �Ѿ�������\n";
}
@Header("Content-type: image/PNG");
srand((double)microtime()*1000000);
$im = imagecreate(100,100);
$black = ImageColorAllocate($im, 0,0,0);
$white = ImageColorAllocate($im, 255,255,255);
$gray = ImageColorAllocate($im, 200,200,200);
imagefill($im,0,0,$gray);
while(($authnum=rand()%100000)<10000);
//����λ������֤�����ͼƬ
//$authnum_s=$authnum; 
imagestring($im, 5, 10, 3, $authnum, $black);
for($i=0;$i<200;$i++)//����������� 
{ 
    $randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
    imagesetpixel($im, rand()%100 , rand()%100 , $randcolor);
} 
ImagePNG($im,"images/no_img.png");
ImageDestroy($im);
?>
