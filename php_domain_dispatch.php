<?php
$domain=$_SERVER['SERVER_NAME'];
#HTTP_REFERER, ��ʱ��������á�
print_r( $_SERVER);
echo "domain ->".$domain."<br>";
if(preg_match("/sino/", $domain))
{
	echo "  we will goto sino-petty/index.php";
}
else
{
	echo "we will goto petty-china/index.php";
}
?>
