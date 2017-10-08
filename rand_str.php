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

echo randArticle(100);
?>

