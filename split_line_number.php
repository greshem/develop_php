<?
	$tmp=file_get_contents("/etc/passwd");
	$file=split("\n", $tmp);
	assert(isset($file[count($file)]));
	echo $file[count($file) -2 ];
	
	//注意最后一个总是 空的， 所有在处理的时候需要注意。 
?>
