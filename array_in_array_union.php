function popedom_check($popedom_id,$popedom_date)//Ȩ�޶�ȡ
{
	if(!in_array($popedom_id, $popedom_date))
	{

		echo "<script language='javascript'>";

		echo "	alert ('��û�����Ȩ�ޣ�');";

		echo "	this.location.href='/index.php';";

		echo "</script>";

	}

}
