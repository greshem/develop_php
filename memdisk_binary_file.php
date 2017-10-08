<?php 

$tmp=file_get_contents("./memdisk");
//$arr=split("\n", $tmp);
//print_r($arr);
//var_export($arr);
//print_r($tmp);
if(strstr($tmp, "MEMDISK"))
{
	print "file is MEMDISK \n";	
}
 ?>
