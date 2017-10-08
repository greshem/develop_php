<html>
<body>
<table bgcolor=AAAAAAA>
<tr bgcolor=gray>
<td> ip  address </td>
</tr>
<?php
//exec("sudo /bin/fping -c 1 -g 192.168.3.1 192.168.4.23 2>/dev/null", $list); 
//3dd	 Exec(escapeshellcmd("$cmd"),$result);
//	Exec(escapeshellcmd("sudo service dhcpd restart"),$result);
//	$result = Exec(escapeshellcmd("sudo service dhcpd start"));
Exec(escapeshellcmd("sudo fping -c 1 -g 192.168.3.1 192.168.4.23 "), $list); 
//print_r($result);
for ($i=0;$i < count($list);$i++) {
//echo $list[$i]."__________________\n"; 
$temp=explode(':',$list[$i]);
echo " <tr><td><a href=\"query_staus.php?ip=$temp[0]&cmd=nmap\">$temp[0]</td></tr>";

}
echo "</table>"
?>
</body>
</html>

