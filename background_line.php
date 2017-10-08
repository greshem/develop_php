<?
	$html_len=780;
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

	for($i=255; $i<(780-255);$i++)
	{
		$tmp=255;	
		$gray=abs($tmp/10 - 255);
		$white=255;
		//$gray=abs($tmp/10);
	
		//$color = ImageColorAllocate($img,$gray, $gray, $gray);
		$color = ImageColorAllocate($img,$white, $white, $white);
		imagesetpixel($img, $i, 0, $color);

	}	
	for($i=780; $i>=(780-255); $i--)
	{
		$tmp=$i;
		echo $tmp."\n";
		$tmp=abs((780-$i) );
		$gray=abs($tmp/10-255);
		//$gray=abs($tmp/10);
		$color = ImageColorAllocate($img,$gray, $gray, $gray);
		
		imagesetpixel($img, $i, 0, $color);
	}
	Imagejpeg($img, "bg.jpg");
?>
	
