<?php 

$tmp=file_get_contents("/etc/passwd");
$arr=split("\n", $tmp);
//print_r($arr);
var_export($arr);
 ?>
