
<?
//#2010_08_22_10:47:49 add by qzj
	$html_len=1224;
	//$img=ImageCreate($html_len,10);
	$img=imagecreatetruecolor($html_len, 1);
	$length=$html_len/7;
	
	$gray_start=0;
	$gray_end=100;
	$gray_layer=10;
	$step=($gray_end-$gray_start)/$gray_layer;//»Ò¶ÈÃ¿´Îstep

	$gray = ImageColorAllocate($img, 200,200,200);
	
	for($i=0; $i<255;$i++)
	//for($i=$html_len; $i>0;$i--)
	{
		//$tmp=$i*$step;
		//$tmp=$i%253;
		$tmp=$i;
		//$tmp=abs(255-$tmp);
	//	$gray=$tmp/10;
		$gray=abs($tmp/10-255);
		
		//echo $tmp."\t";
		$color=ImageColorAllocate($img,$gray, $gray, $gray);
		//$color=imagecreatetruecolor($img, $tmp, $tmp, $tmp);

		//echo $color,"\n";
		imagesetpixel($img, $i, 0, $color);
		imagesetpixel($img, $i, 1, $color);
		imagesetpixel($img, $i, 2, $color);
		imagesetpixel($img, $i, 3, $color);

		//imagecolordeallocate($img, $color);
		//echo "x=".$i."y=1 gray".$tmp."\n";
	}

	for($i=255; $i<($html_len-255);$i++)
	{
		$tmp=255;	
		$gray=abs($tmp/10 - 255);
		$white=255;
		//$gray=abs($tmp/10);
	
		//$color = ImageColorAllocate($img,$gray, $gray, $gray);
		$color = ImageColorAllocate($img,$white, $white, $white);
		imagesetpixel($img, $i, 0, $color);

	}	
	for($i=$html_len; $i>=($html_len-255); $i--)
	{
		$tmp=$i;
//		echo $tmp."\n";
		$tmp=abs(($html_len-$i) );
		$gray=abs($tmp/10-255);
		//$gray=abs($tmp/10);
		$color = ImageColorAllocate($img,$gray, $gray, $gray);
		
		imagesetpixel($img, $i, 0, $color);
	}
	Imagejpeg($img, "bg.jpg");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>new_html </title>
</head>

<body    width=780  background="bg.jpg" style="background-repeat:repeat-y">
	<div width="780px" >
	<strong><font>bgcolor.html</font></strong>
	</div>
</body>
</html>

