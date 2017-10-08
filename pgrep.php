<?php
$strsearch="bdfas video=intelfb  fdaerd";
preg_match('/(\S+)\s+video=intelfb\s+(\S+)/', $strsearch, $submatch);
print_r($submatch);
?>
