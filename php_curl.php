#!/usr/bin/php
<?php
#method1
#$html1 =file_get_contents("http://www.baidu.com");
#$html2 = file("http://www.baidu.com");
#$html3 =readfile("http://www.nettuts.com");
// 1. ��ʼ��
$ch = curl_init();
// 2. ����ѡ�����URL
curl_setopt($ch, CURLOPT_URL, "http://www.baidu.com");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
// 3. ִ�в���ȡHTML�ĵ�����
$output = curl_exec($ch);
// 4. �ͷ�curl���
curl_close($ch);

echo $output;

?>
