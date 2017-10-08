function popedom_check($popedom_id,$popedom_date)//权限读取
{
	if(!in_array($popedom_id, $popedom_date))
	{

		echo "<script language='javascript'>";

		echo "	alert ('您没有相关权限！');";

		echo "	this.location.href='/index.php';";

		echo "</script>";

	}

}
