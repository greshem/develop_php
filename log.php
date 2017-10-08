<?
$error="this is error\n";
file_put_contents("all.log", $error,  FILE_APPEND);
?>

<?php 
	function logger($str)
	{
		file_put_contents("all.log", $str,  FILE_APPEND);
	}
?>
