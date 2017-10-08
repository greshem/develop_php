<?
	if(is_dir( "/usr/share/php/adodb"))
	{
		include_once("/usr/share/php/adodb/adodb.inc.php");
	}
	else
	{
		die(" php-adodb no install \n 
				yum install php-adodb \n");
	}


	if(! isset($argv[1]) 	||  ! isset($argv[2]))
	{
		die("Usage:  cata   logger_text\n");
	}
	$db = ADONewConnection("mysql");
	$db->Connect("localhost", "root", "qianqian", "qianzhongjie") or die("connect error");

	$date=strftime("%Y_%m_%d_%T");
	$cata=$argv[1];
	$log=$argv[2];
	$result=$db->Execute("insert logger  (date, cata, log)  values ('".$date."','".$cata."','".$log."')"); 
	if( ! is_object($result))
	{
		$e = $db->ADODB_Pear_Error();
		echo '<p><b>'.htmlspecialchars($e->message).'</b></p>';

	}
?>
mysql_tree_depth3_table_info.pl qianzhongjie goolge_word
	
	goolge_word
		id
		date
		word
		translate_word
		search_count
