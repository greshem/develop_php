<?
	$stat;
	foreach (glob("images/*.jpg") as $each)
	{
		$img=imagecreatefromjpeg($each);
		
		$x=	imagesx($img);
		$y= imagesy($img);
		echo $each."->".$x."x".$y."\n";
		if(isset ($stat{$x."x".$y}))
		{
			$stat{$x."x".$y}++;
		}	
		else
		{
			#array_push($stat, $x."x".$y=>0);

			$stat{$x."x".$y}=0;
		}
	}
	print_r($stat);
?>
