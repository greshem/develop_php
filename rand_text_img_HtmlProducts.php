<?
function randStr($length) //生成指定为数的随机密码
{ 
//$possible = "0123456789!@#$%^&*()_+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
$possible = "0123456789abcdefghijkmnopqrstuvwxyz"; 
$str = ""; 
	while(strlen($str) < $length) 
	{ 
	$str .= substr($possible, (rand() % strlen($possible)), 1); 
	} 
return($str); 
} 

function randArticle($word)
{
	$article="";
	for($i=0;$i<$word;$i++)
	{
		$article.=randStr(rand()%10 + 1)." ";
		if(rand()%5 == 0)
		{
			$article.="\n";
		}
		
	}
	return $article;
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>new_html </title>
</head>

<body>
<?
	for($i=0;$i<8;$i++)
	{
	if($i%1==0)
	{
		echo "<div style=\"border:1px;border-style:solid;width:250;height:250;float:left;\">\n";
	}
	else
	{
	//	echo "<div style=\"border:1px;border-style:solid;width:250;height:250;float:right;\">\n";
	}
?>
<img src="gray.jpg" style="display:inline;float:left">;

	<?php 
		$text=randArticle(50);
		echo nl2br($text);
	?>
</div>
<?
	}
?>
</body>
</html>

