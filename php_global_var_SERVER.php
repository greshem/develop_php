
<?php  
	if(is_null( $_SERVER['DOCUMENT_ROOT']))
	{
		echo "is empry \n";
	}
	else
	{
		echo $_SERVER['DOCUMENT_ROOT']."\n";
	}
?>

