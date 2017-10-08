<?
include("adodb_check.php");
adodb_check_install();


$db = ADONewConnection("mysql");
$db->Connect("localhost", "root", "qianqian", "pommo") or die("connect error");
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
