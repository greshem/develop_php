<?php 
#array 	mysql_fetch_row 	( resource result)

$db=mysql_connect("localhost", "root", "qianqian") or
die("could not connect");
mysql_select_db( "a0619113740", $db);

#
$result = mysql_query("select * from  ss_site_infos  ");
#$result=mysql_query("select * from  ss_parameters ");
if(! $result)
{
	die("query error \n");
}


#while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
while ($row = mysql_fetch_assoc($result)) 
{
	#printf ("ID: %s  Name: %s Value: %s  \n ", $row[0], $row[1], $row[2] );  
	print_r($row);
}

mysql_free_result($result);
?>
