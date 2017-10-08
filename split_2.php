<?
$a="aa/bb/cc/dd/ff/eebb";
//$a="aa\bb\cc\dd\ff\eebb";
//str_
$b=preg_split("/\//", $a);

#echo basename($a);
print_r($b);
?>
