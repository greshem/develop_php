<html>
<body>
<table>
<tr><td>

<?php
$f=&$HTTP_POST_FILES['userfile'];
//print_r($f);
$dest_dir='uploads';//设定上传目录

$dest=$dest_dir.'/'.date("ymd")."_".$f['name'];//设置文件名为日期加上文件名避免重复

$r=move_uploaded_file($f['tmp_name'],$dest);

chmod($dest, 0755);//设定上传的文件的属性
echo $_FILES['userfile']['error'];
?>
</td></td>
</table>
</html>
