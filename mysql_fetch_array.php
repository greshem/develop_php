
<?php 
$db=mysql_connect("localhost", "root", "password") or
die("could not connect");
mysql_select_db( "qa_shadow", $db) or die("select  shadow  error \n");

$result = mysql_query("select * from  question  ");
if(! $result)
{
	die("query error \n");
}

while ($row = mysql_fetch_array($result)) 
{
	print_r($row);
}

mysql_free_result($result);
?>
