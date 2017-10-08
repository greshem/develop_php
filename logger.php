<?
function logger_empty($str)
{
}
function logger_old($str)
{
	file_put_contents("all.log", $str,  FILE_APPEND);
}
function logger($str)
{
	file_put_contents("all.log", $str,  FILE_APPEND);
}

?>

