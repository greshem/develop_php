<?
	$value="<a\\\">";
	echo $value."\n";
	$result=str_replace("\\\"", "\"", $value);
	//$result=str_replace("\\\"", "bbbbbbbbbbbbbbbbb", $value);
	echo $result;;
	
?>
