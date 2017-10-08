<?php

//########################################################################
function adodb_check_install()
{
	if(is_dir("/var/www/html/adodb5"))
	{
		include_once '/var/www/html/adodb5/adodb-errorpear.inc.php';
		include_once '/var/www/html/adodb5/adodb.inc.php';
		include_once '/var/www/html/adodb5/tohtml.inc.php';
	}
	else
	{

		if(is_dir( "/usr/share/php/adodb"))
		{
			include_once("/usr/share/php/adodb/adodb.inc.php");
		}
		else
		{
			die(" php-adodb 没有安装. \nyum install php-adodb \n");
		}

	}
}

?>
