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

function ClearLog($file_name)
{
	$file_pointer = fopen($file_name, "wb"); 
	$lock = flock($file_pointer, LOCK_EX); 
	if ($lock) {
		fwrite($file_pointer, ""); 
		flock($file_pointer, LOCK_UN); 
	}
	fclose($file_pointer); 
}

?>
