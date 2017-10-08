<?php 
	$array=array(3,4,5,6,7,"aaa","bbb","cc");
	$tmp=preg_grep("/\d+/", $array);
	print_r($tmp);

	$tmp=preg_grep("/[a-z]+/", $array);
	print_r($tmp);

 ?>
