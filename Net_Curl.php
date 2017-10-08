<?

// 2011_03_23_22:07:25   星期三   add by greshem
//基于 pear  的错误 在pear 的内部也设计 成了一个类. 
include("Net/Curl.php");
$a=new Net_Curl('http://www.baidu.com');
$result=$a->execute();
if( ! is_object($result))
{
	echo "curl 获取失败\n";
}
else
{
	echo "返回一个类， 总归是成功的\n";
}
if(! PEAR::isError($result))
{
	echo $result;
}
?>
