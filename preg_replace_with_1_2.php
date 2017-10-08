<?php
	$line="aa bb cc dd ee ff";

	$line2=preg_replace("/(\S+)(.*)/", "<a href=rebuild_url.php?url=$1 > $1</a>  $2", $line) ;
	echo $line2;
?>   
