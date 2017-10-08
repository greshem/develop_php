<?php 
$b=array("11", "33", "44", "55");
include("HTML/Select.php");
$a=new HTML_Select;
$a->loadArray($b);
$html=$a->toHtml();
$a->display();
echo $html;
 ?>
