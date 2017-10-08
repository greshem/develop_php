<?	
	//increase array
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
	
///increase array
if(is_sort_incr(array(1,3,4,5,45,9,6,7)))
{
	echo "is sort";
}
else
{
	die("not sort\n");
}
