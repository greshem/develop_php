<?php 
	$_TEST['tasfa']="bb";
	#$_TEST['tasfa']=null;
	#if(isset($_TEST['tasfab']))
	if(isset($_TEST['tasfa']))
	{
		echo "isset \n";
	}
	else
	{
		echo "not set\n";
	}


	if(is_null ($_TEST['tasfa']))
	{
		print "is_null \n";
	}
	else
	{
		print "not_null\n";
	}
 ?>
