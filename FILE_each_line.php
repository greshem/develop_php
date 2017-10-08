<?php 

$myFile=file("/etc/passwd");
     
for($index=0;$index<count($myFile);$index++)
{
	print($myFile[$index]);
} 

 ?>
