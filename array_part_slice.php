<?php 
	$a=array(1,2,3,4,5,6,7);
	$b=array_slice($a, 1,6); # Ϊ 2,3,4,5,6,7 , ���һ���ǳ���.
	print_r($b);

	$b=array_slice($a, 1,600);  # ̫���Ļ�, ֻ��ȡ�����.
	print_r($b);

 ?>
