<html>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />

<body>
<?php  
$inurl=$_SERVER['HTTP_REFERER'];  
echo "referer=".$inurl."<br>\n";
if( ! $inurl)
{
	echo "<a href=".$inurl."> ERROR111 </a>\n";
}
elseif( preg_match("/rich/", $inurl) )
{
	echo "Ok";
}
else
{
	echo "refer 错误 不包含, rich 字符串\n";
}
?> 
</body>

</html>
