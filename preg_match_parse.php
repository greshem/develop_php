#!/usr/bin/php
<?
//20100317, qzj
//��ͬ��PERL�Ĵ���
//$array=grep { -f &&/conf$/} (</etc/*>);
//��ȻPERL�ļ򵥶��ˡ� 
$a="aaa bbb ccc";
preg_match("/(\S+)\s+(\S+)(.*)/", $a, $match);

print_r($match);
?>

