<?php

preg_match_all("|<[^>]+>(.*)</[^>]+>|U", "<div align=left>a test</div>", $out, PREG_PATTERN_ORDER);
print_r($out);
print $out[0][0].", ".$out[0][1]."\n";

print $out[1][0].", ".$out[1][1]."\n"

?>

//传回值为
//<b>example: </b>, <div align=left>this is a test</div>
//example: , this is a test
//PREG_SET_ORDER 的例子

<?php

preg_match_all("|<[^>]+>(.*)</[^>]+>|U", "<div align=left>a test</div>", $out, PREG_SET_ORDER);

print $out[0][0].", ".$out[0][1]."\n";

print $out[1][0].", ".$out[1][1]."\n"

?>

//传回值为
//<b>example: </b>, example:
//<div align=left>this is a test</div>, this is a test 
