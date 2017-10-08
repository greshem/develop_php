<?
	if(isset( $_GET['pic']))
	{
		$pic=$_GET['pic'];
	}
	
	if(isset($pic))
	{
		$desc=preg_replace("/jpg$/","txt", $pic);
		echo  "read ".$desc."<br>";
		echo "<img  src=".$pic.">";
	}
	else
	{
		$pics=glob("images/*.jpg");
		$count=0;
		foreach ($pics as $each)
		{
			echo "<a href=show_single_pic.php?pic=".$each." > <img  src=".$each.">"."</a>";	
			$count++;
			if($count> 16)
			{
				break;
			}
		}
	}
?>
