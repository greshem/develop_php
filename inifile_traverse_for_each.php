<?php 
	$file;
	if(! isset($argv[1]))
	{
		//die("Usage".$argv[0]."  file.ini");
		$file="product.ini";
	}
	else
	{
	$file=$argv[1];
	}
	traverse_ini_file($file);

function  traverse_ini_file($input_file)
{
	$ini=parse_ini_file($input_file , 1);

	foreach ($ini as $sect=> $item)
	{
		#print "处理新的sect\n";
		#print "[$item]\n";
		foreach ( $item as $key=>$value)
		{
			sino_pet_hook_function($sect, $key , $value);
		}
	}	
}


function sino_pet_hook_function($item, $key, $value)
{
 	#echo "处理 $item $key $value\n";
	$jpg_files=split(",", $value);
	foreach ($jpg_files as $file)
	{
		print "处理  $item->$key->$file \n";
	}

}	
 ?>
