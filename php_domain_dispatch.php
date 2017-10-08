<?php
$domain=$_SERVER['SERVER_NAME'];
#HTTP_REFERER, 有时候这个有用。
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
