<?php 
	$a=array(1,2,3,4,5,6,7);
	$b=array_slice($a, 1,6); # 为 2,3,4,5,6,7 , 最后一个是长度.
	print_r($b);

	$b=array_slice($a, 1,600);  # 太长的话, 只截取到最后.
	print_r($b);

 ?>
