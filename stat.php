
<table >
<?php 
	
	echo "<tr><td>name\t</td><td>	size\t</td> 	\t	<td>mtime</td> \n";
	foreach (glob("/etc/*") as $line)
	{
		$stat=stat($line);
		echo $line ,"->", $stat["size"],"\t", strftime("%Y_%m_%d_%T", $stat["mtime"]),"\t","\n"; 
	}
?>

</table>
