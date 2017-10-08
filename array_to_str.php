<?php
function	array_to_str($value)
{
	$ret_str;
	foreach($value as $key=>$value)
	{
	    $ret_str.="$value|";
	}
	return $ret_str;
}

$array=range(1,100);

print_r(array_to_str($array));
	

?>
