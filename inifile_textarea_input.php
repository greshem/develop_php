<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>textarea</title>
</head>

<? 
	if(isset($_POST['ini']))
	{
		if(	file_put_contents("../product.ini", $_POST['ini'] ))
		{
			echo "文件写入成功\n";
		}
		else
		{
			echo "吸入文件失败\n";
		}
	}
?>
<body>
<form action="inifile.php" method="post">
<textarea name="ini" cols="130" rows="40">
<?
	$file=file_get_contents("../product.ini");
	echo $file
?>
</textarea>
<input name=submit type=submit value=submit />
</form>
</body>
</html>
