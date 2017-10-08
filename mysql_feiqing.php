#!/usr/bin/php
//$argv[1]
<?php
include("/var/www/html/11698666/include/config.inc.php");
include('/var/www/html/11698666/include/db_run_time_start.inc.php');
include("/var/www/html/11698666/include/functions.lib.php");
include("/var/www/html/11698666/include/ad.inc.php");
$gDb = new Db;
$connected = $gDb->DbConnect($lvc_db_host, $lvc_db_user, $lvc_db_password, $lvc_db_database);
$query="SELECT count(*) from $argv[1]";
$gDb->DbQuery($query);
if($gDb->DbNumRows())
{
	if($gDb->DbNextRow())
	{
		$record=$gDb->Row;
		if ($record[0]>0)
		{
		echo "have $record[0] records\n";	
		}
	}
}
$query = "SELECT * FROM Ability_table ";
$gDb -> DbQuery($query);
	if($gDb -> DbNumRows()){
				echo "$argv[1]\t"."$argv[2]\n";
               while($gDb -> DbNextRow()){
				$record = $gDb -> Row;
				echo $record["$argv[1]"]."---";
				echo $record["$argv[2]"]."\n";
						   }
				     }
?>
