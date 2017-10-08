<?php 

// 2011_03_23_23:11:16   星期三   add by greshem
include("File/Find.php");
$find = new File_Find();
$a=$find->maptree("/etc/xinetd.d/");
print_r($a);

$b=File_Find::maptree("/tmp");

//这里 不是. /patter/
$file=File_Find::search("conf$", "/etc");
print_r($file);
 ?>

