<?php
function unescape_unicode($str) {
  $str = rawurldecode($str);
  preg_match_all("/(?:%u.{4})|&#x.{4};|&#\d+;|.+/U",$str,$r);
  $ar = $r[0];
  foreach($ar as $k=>$v) {
    if(substr($v,0,2) == "%u")
      $ar[$k] ="&#".utf8_unicode(iconv("UCS-2","UTF-8",pack("H4",substr($v,-4)))).";";
    elseif(substr($v,0,3) == "&#x")
      $ar[$k] ="&#".utf8_unicode(iconv("UCS-2","UTF-8",pack("H4",substr($v,3,-1)))).";";
    elseif(substr($v,0,2) == "&#") {
      $ar[$k] ="&#".utf8_unicode(iconv("UCS-2","UTF-8",pack("n",substr($v,2,-1)))).";";
    }
  }
  return join("",$ar);
}

// change utf8 to unicode
function utf8_unicode($c) {
  switch(strlen($c)) {
    case 1:
	echo "len=1";
      return ord($c);
    case 2:
	echo "len=2";
      $n = (ord($c[0]) & 0x3f) << 6;
     	 $n += ord($c[1]) & 0x3f;
//	$n=$c;
      return $n;
    case 3:
	echo "len=3";
      $n = (ord($c[0]) & 0x1f) << 12;
      $n += (ord($c[1]) & 0x3f) << 6;
      $n += ord($c[2]) & 0x3f;
	//$n=ord($c);
      return $n;
    case 4:
	echo "len=4";
      $n = (ord($c[0]) & 0x0f) << 18;
      $n += (ord($c[1]) & 0x3f) << 12;
      $n += (ord($c[2]) & 0x3f) << 6;
      $n += ord($c[3]) & 0x3f;
      return $n;
  }
}

//echo unescape_unicode('%E5%9B%BE%E7%89%87%E9%A2%91%E9%81%93%E9%A6%96%E9%A1%B5');
//echo unescape_unicode('%CA%D7%D2%B3%CD%C6%BC%F6%CE%CA%B0%C9');
echo  utf8_unicode($argv[1]);
?>
