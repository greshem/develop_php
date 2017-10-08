<?


#2010_08_22_09:01:05 add by qzj
//注意还是会出现空格的， mysql 数据库里面是否为空。
if(is_dir( "/usr/share/php/adodb"))
{
	include_once("/usr/share/php/adodb/adodb.inc.php");
}
else
{
	die(" php-adodb no install \n 
			yum install php-adodb \n");
}


$db = ADONewConnection("mysql");
$db->Connect("localhost", "root", "qianqian", "huanqiuweb") or die("connect error");
$result= $db->Execute("select count(*)  from Company_table");

$count=$result->fields[0];
if(isset($count))
{
	//echo " 总数". $count."\n";
}
else
{
	die("获取count 失败， 断言失败 \n");
}

$offset=rand()%$count;
//echo "offset 为".$offset."\n";

$result=$db->Execute("select Co_address  from Company_table");


$cur=0;
if (!is_object($result)) 
{
	$e = ADODB_Pear_Error();
	echo '<p><b>'.htmlspecialchars($e->message).'</b></p>';
} 
else 
{
	while (!$result->EOF) 
	{
		$cur++;
		for ($i = 0, $max = $result->FieldCount(); $i < $max; $i++) 
		{
		//	echo 
			if(isset($result->fields[$i]) && $cur>$offset)
			{
				echo htmlspecialchars($result->fields[$i])." \n";;
				exit(0);
			}
			$result->MoveNext();
		}
	}
}


?>
