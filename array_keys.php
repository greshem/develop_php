<?php
function	keys($value)
{
	$retKey=array();
	foreach($value as $key=>$value)
	{
		array_push($retKey, $key);
	}
	return $retKey;
}

$array=range(1,100);

print_r(array_keys($array));
	

?>
