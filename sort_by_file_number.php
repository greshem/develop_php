<?php 
function sort_by_nubmer($a, $b)
{
	$aa=preg_replace("/(.*).jpg/", "$1", $a);
    $bb=preg_replace("/(.*).jpg/", "$1", $b);	
	if($aa< $bb)
	{
		return  0;
	}
	return 1;
}

$jpgs=array("3.jpg", "4.jpg", "5.jpg", "6.jpg");
usort($jpgs, "sort_by_nubmer");
print_r($jpgs);
 ?>
