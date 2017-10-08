<?php
$colors = array("love"=>'1111111', "qian"=>'222222', "like"=>'3333333333', "bbb"=>'444444444444');
$two=range(1,100);
foreach ($two as $number)
{
	echo $number."\n";
	array_push($colors,$number);
}
ksort($colors);
echo  $colors[1];
foreach ($colors as $key=>$color) {
    echo "Do you like $key =>$color\n";
}
?>
