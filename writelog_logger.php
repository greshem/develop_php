<?
function WriteLog($file_name,$message)
{
	$file_pointer = fopen($file_name, "a"); 
	$lock = flock($file_pointer, LOCK_EX); 
	if ($lock) {
		fwrite($file_pointer, date ("Y-m-d H:i:s" ,time()).":".$message."\r\n"); 
		flock($file_pointer, LOCK_UN); 
	}
	fclose($file_pointer); 
}

WriteLog("a.log", "this is test\n");
?>
