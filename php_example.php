<?php
include ("/var/www/html/inc/func.inc");
//$a=passthru($argv[1]);
echo $a."-----------";

$a="inc_html";
$match="";
$value="";
$a = preg_replace('/inc/', 'inc____________', $a);
echo "after replace\n";
echo $a."\n";
if ( preg_match('/inc/',$a)) {
	echo "success\n";		
		}
////////////////////////////////////////////
preg_match_all("|<[^>]+>(.*)</[^>]+>|U", "<div align=left>a test</div>", $out, PREG_PATTERN_ORDER);

print_r($out);
//print $out[0][0].", ".$out[0][1]."\n";
//print $out[1][0].", ".$out[1][1]."\n";
/////////////////
$a="qian,wen,wen,test,liu,xin";
$match=preg_split("/,/", $a);
sort($match);
print_r($match);
//没有初始化的时候会产生错误
foreach ($match as $value) {
    echo "Value: $value\n";
} 
for ($i=1;$i<100;$i++)
{
 echo rand()."\n";
}
///////////////do while
do {
    if ($i < 5) {
        print "i is not big enough";
        break;
    }
    $i *= $factor;
    if ($i < $minimum_limit) {
        break;
    }
    print "i is ok";

    // ...process i...

} while(0);
/////////////////////////////
while ($i <= 10):
    print $i;
    $i++;
endwhile;
///////////
while($i<=10)
{
 print $i;
  $i++;
}
/////////////////////////////////
$fruits = array (
    "fruits"  => array ("a"=>"orange", "b"=>"banana", "c"=>"apple"),
    "numbers" => array (1, 2, 3, 4, 5, 6),
    "holes"   => array ("first", 5 => "second", "third")
);
print_r($fruits);
/////////////////////////////////////
$array = array( 1, 1, 1, 1,  1, "qianqian"=>1,  4=>1, 19, 3=>13);
print_r($array);
#############################
while (list ($key, $val) = each ($array)) {
    echo "$key = $val\n";
}
###################################
?>
