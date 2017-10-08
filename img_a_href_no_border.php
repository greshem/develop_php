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
		if(file_exists($desc))
		{
			$buf=file_get_contents($desc);
			$lines=spliti("\n", $buf);
			foreach ($lines as  $line)
			{
				echo "<h3>".$line."</h3>\n";
			}
		}
		else
		{
				echo "<h3>no desc </h3>\n";
		}
	}
	else
	{
		$pics=glob("images/*.jpg");
		$count=0;
		foreach ($pics as $each)
		{
			echo "<a href=show_single_pic.php?pic=".$each." > <img  style=\"border:0 none;padding:0;\" src=".$each.">"."</a>\n";	
			$count++;
			if($count> 16)
			{
				break;
			}
		}
	}
?>
