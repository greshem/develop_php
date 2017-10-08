<?php 
// 2011_03_22_12:14:52   ÐÇÆÚ¶þ   add by greshem
	function dir_is_empty($dir)
	{
		$a=glob($dir."/*");
		return  ! count($a);
	}
	
	if(dir_is_empty("/etc/tmp"))
	{
		echo ("dir is empty\n");
	}
	else
	{
		echo "dir is not empty\n";
	}
 ?>
