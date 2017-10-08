<?php
 mysql_connect("localhost","root","qianqian");
	$db_list=mysql_list_dbs();
 $i=0;
$cnt=mysql_num_rows($db_list);
while($i<$cnt)
{echo mysql_db_name($db_list,$i)."\n";
 $i++;
}
?>
