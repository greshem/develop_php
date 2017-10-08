<?
include("File/Passwd.php");
$passwd = &File_Passwd::factory('Unix');
print_r($passwd);
//$passwd->staticAuth("Unix", 
?>

