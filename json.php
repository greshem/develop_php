<?php 
$arr = array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>array(3=>"3333", 4=>"4444")
);
echo json_encode($arr)."\n";


#����jsonֻ����utf-8������ַ�������json_encode()�Ĳ���������utf-8���룬�����õ����ַ�����null��������ʹ��GB2312���룬��������ʹ��ISO-8859-1�����ʱ����һ��Ҫ�ر�ע�⡣

#������, ����.
$arr = Array('one', 'two', 'three');
echo json_encode($arr)."\n";


#����.
$json = '{"foo": 12345}';
$obj = json_decode($json);
print $obj->{'foo'}; // 12345


#ǿ��Ϊ��������
#�����Ҫǿ������PHP�������飬json_decode()��Ҫ��һ������true��
$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
var_dump(json_decode($json),true);

 ?>
