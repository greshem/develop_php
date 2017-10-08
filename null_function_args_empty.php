#!/usr/bin/php
<?php 

#2011_01_09_23:21:09 add by greshem, 根据条件， 然后 决定echo 的那些要那些不要. 
//
function echo_eof_with_test($a, $b, $c)
{
if($a)
{
		echo <<<EOF
		aaaaaaaaaaaaaaaaaaaaaaa\n
EOF;
}

if($b)
{
		echo <<<EOF
		bbbbbbbbbbbbbbbbbbbb\n
EOF;
}

if($c)
{
			echo <<<EOF
	CCCCCCCCCCCCCCCCCCCCCCCC\n
EOF;
}


} 


echo_eof_with_test(null, null,null);

?>

