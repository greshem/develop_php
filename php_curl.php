#!/usr/bin/php
<?php
#method1
#$html1 =file_get_contents("http://www.baidu.com");
#$html2 = file("http://www.baidu.com");
#$html3 =readfile("http://www.nettuts.com");
// 1. 初始化
$ch = curl_init();
// 2. 设置选项，包括URL
curl_setopt($ch, CURLOPT_URL, "http://www.baidu.com");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
// 3. 执行并获取HTML文档内容
$output = curl_exec($ch);
// 4. 释放curl句柄
curl_close($ch);

echo $output;

?>
