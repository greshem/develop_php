<?
	//sor
	$grays=array(250, 240, 230,220, 210, 200, 190, 180, 170, 160, 150);
	sort($grays);
	if(!is_sort_incr($grays))
	{
		$grays=array_reverse($grays);
	}
	
	$grays_len=count($gray2);
	$white=max($grays);
	$gray=min($grays);	
	$step=($white-$gray)/$grays_len;
	//´Ó°×µ½»Ò. 
	print_r($grays);
	$extend=1024;
	
	$scalar= 1024/($white-$gray);
	
	for($i=0;$i<1024; $i++)
	{
		$tmp= $gray+($i/$scalar)."\n";	
		echo $tmp." ->  ".get_number($grays, $tmp)."\n";;

	}
	
	if(is_sort_incr($grays)|| is_sort_desc($grays))
	{
		echo "grays is sort\n";	
	}
	else
	{
		die("grays no srot\n");
	}
	function get_number($range, $input)
	{
		//if(is_sort_desc($range))
		//{
		//	$tmp=array_reverse($range);
		//}
		$count=count($range);	
		$i=0;
		for($i=0;$i<$count; $i++)
		{
			if($input<= $range[$i])
			{
				return $range[$i];	
			}
		}
		
		return  $range[$i];	

	}
	


	function is_sort_incr($range)
	{
		$count=count($range);
		
		for($i=0;$i<$count-1;$i++)
		{
			if($range[$i+1] >=$range[$i])
			{
			}
			else
			{
				return 0;
			}
		}
		
		return 1;
	}

	function is_sort_desc($range)
	{
		$count=count($range);
		
		for($i=0;$i<$count-1;$i++)
		{
			if($range[$i+1] <=$range[$i])
			{
			}
			else
			{
				return 0;
			}
		}
		
		return 1;
	}

	

?>
