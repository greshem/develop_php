<?php 
	$ini=parse_ini_file("product.ini", 1);
	$all=array();;
	foreach ($ini as $sect => $item)
	{
		foreach ($item as $key2=> $value2)
		{
			$path="photos/".$sect."/".$key2;
			$path=strtolower($path);
			$jpg=glob($path."/*.jpg");
			foreach($jpg as $each)
			{
			//	echo $each."\n";
			//echo 	strftime("%Y_%m_%d_%T", filemtime($each))."\n";
			array_push($all, $each);
			}
		}
	}
		

	
	usort($all, "compare_by_mtime");

	function compare_by_mtime($a, $b)
	{
		if(filemtime($a) < filemtime($b))
		{
			return 1;
		}
		return 0;
	}

	//print_r($all);

	foreach ($all as $file)
	{
		//echo 	strftime("%Y_%m_%d_%T", filemtime($file))."\n";
		//echo filemtime($file)."\n";
	}
	$top_100=array();
	for($i=0; $i<=100; $i++)
	{
		array_push($top_100, array_shift($all));;
	}

	foreach ($top_100 as $file)
	{
		//echo 	strftime("%Y_%m_%d_%T", filemtime($file))."\n";
		echo filemtime($file)."\n";
	}

 ?>
