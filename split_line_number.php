<?
	$tmp=file_get_contents("/etc/passwd");
	$file=split("\n", $tmp);
	assert(isset($file[count($file)]));
	echo $file[count($file) -2 ];
	
	//ע�����һ������ �յģ� �����ڴ����ʱ����Ҫע�⡣ 
?>
