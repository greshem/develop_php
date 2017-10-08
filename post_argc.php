<?php
 $lpar_id = isset($_REQUEST['test'])?$_REQUEST['test']:null;;
if( ! isset($lpar_id)) 
{
	$lpar_id=  $argv[1];
}

	#if(! isset($_REQUEST['test']))
	if(! isset(  $lpar_id) )
	{
		print "lpar id  empty   \n";
	}
	else
	{
		print "lpar id  $lpar_id \n";
	}
?>
