<?

// 2011_03_23_23:55:40   ������   add by greshem
// usr/share/php Ҳ�� Ĭ�� php ��include ��������·��. 
if(! include_once("adodb/adodb.inc.php"))
{
	echo "#include adodb ʧ�� \n";
	die(" yum install adodb \n");
}
$db = ADONewConnection("mysql");
$db->Connect("localhost", "root", "qianqian", "pommo") or die("connect error");
#echo "<p><b>DBServer: $_POST[dbserver]</b></p>";
$result = $db->Execute("SELECT email FROM pommo_subscribers ");
if (!is_object($result)) 
{
	$e = ADODB_Pear_Error();
	echo '<p><b>'.htmlspecialchars($e->message).'</b></p>';
} 
else 
{
	while (!$result->EOF) 
	{
		for ($i = 0, $max = $result->FieldCount(); $i < $max; $i++) 
		{
			echo htmlspecialchars($result->fields[$i])." \n";;
			$result->MoveNext();
		}
	}
}

?>
