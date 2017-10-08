<?php 
	if(preg_match("/^include_host.php$/", $argv[0]))
	{
		print "aaaa";
	}	
	else
	{
		print "I'm included by others \n";
	}
 ?>
