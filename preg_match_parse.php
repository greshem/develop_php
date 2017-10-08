#!/usr/bin/php
<?
//20100317, qzj
//等同于PERL的代码
//$array=grep { -f &&/conf$/} (</etc/*>);
//当然PERL的简单多了。 
$a="aaa bbb ccc";
preg_match("/(\S+)\s+(\S+)(.*)/", $a, $match);

print_r($match);
?>

