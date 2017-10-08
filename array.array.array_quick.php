<?php 

include("File/Find.php");
$find = new File_Find();
$a=$find->maptree("/etc/");
print_r($a);

?>

