<?

// 2011_03_23_22:07:25   ������   add by greshem
//���� pear  �Ĵ��� ��pear ���ڲ�Ҳ��� ����һ����. 
include("Net/Curl.php");
$a=new Net_Curl('http://www.baidu.com');
$result=$a->execute();
if( ! is_object($result))
{
	echo "curl ��ȡʧ��\n";
}
else
{
	echo "����һ���࣬ �ܹ��ǳɹ���\n";
}
if(! PEAR::isError($result))
{
	echo $result;
}
?>
