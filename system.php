<?php 
 Exec(escapeshellcmd("ifconfig -a"),$result);
 print_r($result);

?>
