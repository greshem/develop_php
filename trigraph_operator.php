<?php 
	$id=isset($_GET['id'])?$_GET['id']:null;

	if($id)
	{
		echo ("success\n");
	}
	else
	{
		echo ("error \n");
	}
 ?>
