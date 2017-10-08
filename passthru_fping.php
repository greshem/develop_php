<?
$a=passthru("fping -c 1 -g 192.168.3.1 192.168.4.23 2>/dev/null");
print_r($a);
//echo $a;
 while (list ($ip, $val) = each ($a)) {
    echo "$ip = $val\n";
}

