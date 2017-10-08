<?php 
$arr = array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>array(3=>"3333", 4=>"4444")
);
echo json_encode($arr)."\n";


#由于json只接受utf-8编码的字符，所以json_encode()的参数必须是utf-8编码，否则会得到空字符或者null。当中文使用GB2312编码，或者外文使用ISO-8859-1编码的时候，这一点要特别注意。

#中括号, 数组.
$arr = Array('one', 'two', 'three');
echo json_encode($arr)."\n";


#解码.
$json = '{"foo": 12345}';
$obj = json_decode($json);
print $obj->{'foo'}; // 12345


#强制为关联数组
#如果想要强制生成PHP关联数组，json_decode()需要加一个参数true：
$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
var_dump(json_decode($json),true);

 ?>
