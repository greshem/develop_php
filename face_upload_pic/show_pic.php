<?
		$pics=glob("photos/*.jpg");
		$count=0;
		foreach ($pics as $each)
		{
			echo "<a> <img  src=".$each.">"."</a>";	
		}
?>
