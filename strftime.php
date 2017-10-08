
<table >
<?php 
	#date_default_timezone_set('Asia/Chongqing');
	date_default_timezone_set('Asia/Shanghai');
	#date_default_timezone_set('Asia/Beijin');
	
	echo "<tr><td>name\t</td><td>	size\t</td> 	\t	<td>mtime</td> \n";
	foreach (glob("/etc/*") as $line)
	{
		$stat=stat($line);
		echo $line ,"->", $stat["size"],"\t", strftime("%Y_%m_%d_%T", $stat["mtime"]),"\t","\n"; 
	}
	
	##
	
	#Today
	echo strftime("%Y_%m_%d", time());
 
?>

</table>
