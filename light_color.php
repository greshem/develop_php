
<?php

if(! is_dir("/tmp/all"))
	mkdir("/tmp/all");
unlink(" /tmp/all/list.txt");


#R(250)G(128)B(10)
for($a=0;$a<=359;$a++)
{

	#echo $a."\n";
	gen_a_pic($a, 90);
}

gen_list();

system("cd /tmp/all && mencoder mf://@list.txt -mf w=400:h=400:fps=400:type=png -ovc lavc -lavcopts vcodec=mpeg4:mbd=2:trell -oac copy -o output1.avi ");


#gen_a_pic(0);
function gen_a_pic($start_offset, $angle)
{

	#php.ini 需要 开启 memory_limit = 1024M
	$width=400;
	$height=400;

	$image = imagecreatetruecolor($width, $height);
	$white = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);

	$gray = imagecolorallocate($image, 0xC0, 0xC0, 0xC0);

	#红
	$red = imagecolorallocate($image, 0xFF, 0x00, 0x00);

	#橙
	$org = imagecolorallocate($image, 250, 128,10);

	#黄色255 255 0
	$yellow=  imagecolorallocate($image, 255, 255,0);

	#绿色 0 255 0 #00FF00
	$blue  =  imagecolorallocate($image, 0, 255,0);

	#0000FF
	$green = imagecolorallocate($image , 0,0,255);

	#靛，RGB: 6,82,121
	#青 0    127  255
	#$dian= imagecolorallocate($image , 102,0,255);
	$dian= imagecolorallocate($image , 0,127,255);

	#zhi
	$zhi= imagecolorallocate($image , 128,0,255);
	$zhi= imagecolorallocate($image , 139,0,255);

	$darkred = imagecolorallocate($image, 0x90, 0x00, 0x00);
	imagefill($image,0,0,$white);



	#红45
	imagefilledarc($image, $width/2, $height /2, $width/2, $height /2,$start_offset*$angle+0,$start_offset*$angle+ 45, $red, IMG_ARC_PIE);

	#橙 25 
	imagefilledarc($image, $width/2, $height /2, $width/2, $height /2,$start_offset*$angle+ 45,$start_offset*$angle+ 45+25 , $org, IMG_ARC_PIE);

	#黄 80
	imagefilledarc($image, $width/2, $height /2, $width/2, $height /2,$start_offset*$angle+ 45+25,$start_offset*$angle+ 45+25+80 , $yellow, IMG_ARC_PIE);

	#绿 60
	imagefilledarc($image, $width/2, $height /2, $width/2, $height /2,$start_offset*$angle+ 45+25+80,$start_offset*$angle+ 45+25+80+60 , $blue, IMG_ARC_PIE);

	#蓝 60 
	imagefilledarc($image, $width/2, $height /2, $width/2, $height /2,$start_offset*$angle+ 45+25+80+60,$start_offset*$angle+ 45+25+80+60+60 , $green, IMG_ARC_PIE);

	#靛 40
	imagefilledarc($image, $width/2, $height /2, $width/2, $height /2,$start_offset*$angle+ 45+25+80+60+60,$start_offset*$angle+ 45+25+80+60+60+40 , $dian, IMG_ARC_PIE);

	#紫色 50
	imagefilledarc($image, $width/2, $height /2, $width/2, $height /2,$start_offset*$angle+ 45+25+80+60+60+40,$start_offset*$angle+ 45+25+80+60+60+40+50 , $zhi, IMG_ARC_PIE);

	// // flush image
	// header('Content-type: image/png');
	// imagepng($image);
	// imagedestroy($image);

	//发送对象至文件

	#$filename="/tmp/all/$start_offset.png";
	$filename="/tmp/all/$start_offset.jpg";
	echo "#generate /tmp/all/$start_offset.png\n" ;
	imagepng($image,$filename);
	#imagejpeg($image,$filename);
}

function gen_list()
{
	for($a=1;$a<360; $a++)
	{
		$str="$a.jpg\n";
		echo $str;
		file_put_contents("/tmp/all/list.txt", $str, FILE_APPEND);
	}
}
?>



