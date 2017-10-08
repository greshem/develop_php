<?php
$domain=$_SERVER['SERVER_NAME'];
#HTTP_REFERER, 有时候这个有用。
#print_r( $_SERVER);
#echo "domain ->".$domain."<br>";
if(preg_match("/sino/", $domain))
{
	//echo "  we will goto sino-petty/index.php";
//	header("Location: http://www.baidu.com");
//	header("Location: sino_pet/index.php");
	echo "<script>window.location=\"sino_pet/index.php\";</script>;";
	
}
else
{
	//echo "we will goto petty-china/index.php";
	//header("Location: http://www.sohu.com");
	//header("Location: petty_china/index.php");
	echo "<script>window.location=\"petty_china/index.php\";</script>;";
}
?>
