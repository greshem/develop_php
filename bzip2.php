<?php

$filename = "/tmp/testfile.bz2";
$str = "This is a test string.\n";

// 以写入方式打开文件
$bz = bzopen($filename, "w");

// 写入字符串到文件
bzwrite($bz, $str);

// 关闭文件
bzclose($bz);

// 以读取方式打开文件
$bz = bzopen($filename, "r");

// 读取 10 个字符
echo bzread($bz, 10);

// 输出直到文件结尾（或后续的 1024 字节）并关闭它。
echo bzread($bz);

bzclose($bz);

?>

