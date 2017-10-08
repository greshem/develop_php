
<html>
<body>
<?
	//header("Content-type:txt");
	//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
$cmd= $HTTP_GET_VARS['cmd'];
$ip=$HTTP_GET_VARS['ip'];
	 Exec(escapeshellcmd("sudo $cmd $ip"),$result);
	echo "<table bgcolor=AAAAAA>";
	foreach ($result as $key=> $line)
	{
	 echo "<tr bgcolor=gray ><td>$key =>  $line</td>\n";
	}
	echo "</tr></table>";
	//Exec(escapeshellcmd("sudo service dhcpd restart"),$result);
//	print_r( $result);

  echo "\n";
  	
/*	$result = Exec(escapeshellcmd("sudo service dhcpd start"));
	//echo $result;
	if ($result = '[FAILED]') {
		echo 'Restarting dhcpd: ' . $result;
	} else {
		echo 'Restarting dhcpd: [  OK  ]';
	}*/
?>
</body>
</html>
