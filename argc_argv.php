<?php

	print_r($argv);
	print "argv[0]=".$argv[0]."\n";
	print "argv[1]=".$argv[1]."\n";

if(!defined($argv[1]))
{
	die("Usage: $argv[0]  input_file \n");
}
	
?>

