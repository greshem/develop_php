<?php
#$file = 'E:/web/install.php'; //要解密的文件

$file= "/var/www/html/pretty/web/library/acl.php";

error_reporting(E_ERROR);
header("content-Type: text/html; charset=gb2312");
set_time_limit(120);

function Read($filename)
{
        $handle = @fopen($filename,"r");
        $filecode = @fread($handle,@filesize($filename));
        @fclose($handle);
        return $filecode;
}
function weidun_decode($code)
{
        $tmp = '';$tmp1 = '';$tmp2 = '';
        $linearray = file($code);
        $keyarray = array(base64_decode('L08wTzAwMDBPMFwoJy4qJ1wpLw=='),base64_decode('L1wpLCcuKicsLw=='),base64_decode('LyxcZCpcKSwv'),base64_decode('TzBPMDAwME8wKCc='),base64_decode('QUJDREVGR0hJSktMTU5PUFFSU1RVVldYWVphYmNkZWZnaGlqa2xtbm9wcXJzdHV2d3h5ejAxMjM0NTY3ODkrLw=='));
        if(preg_match($keyarray[0],$linearray[1],$str)){$tmp = str_replace($keyarray[3],'',$str[0]);$tmp = str_replace('\')','',$tmp);$tmp = base64_decode($tmp);}
        if(preg_match($keyarray[1],$tmp,$str1)){$tmp1 = str_replace('),\'','',$str1[0]);$tmp1 = str_replace('\',','',$tmp1);}
        if(preg_match($keyarray[2],$tmp,$str2)){$tmp2 = str_replace('),','',$str2[0]);$tmp2 = str_replace(',','',$tmp2);}
        return '<?php'."\r\n".base64_decode(strtr(substr($linearray[2],$tmp2),$tmp1,$keyarray[4]))."\r\n".'?>';
}
#echo '解密前：<br /><textarea name="newcode" COLS="80" ROWS="15">'.htmlspecialchars(Read($file)).'</textarea><br /><br />';
#echo '解密后：<br /><textarea name="newcode" COLS="80" ROWS="15">'.htmlspecialchars(weidun_decode($file)).'</textarea><br />';

#  print "argv[1]=".$argv[1]."\n";

#if(!defined($argv[1]))
#{
#	echo  $argv[1]."\n";
 #   die("Usage: $argv[0]  input_file \n");

#}

$file= $argv[1];
echo "file=$file";
$content= weidun_decode($file);
$output=$file.".decode.php";
file_put_contents($output, $content);

if(file_exists($output))
{
	echo "$output OK \n";
}
else
{
	echo "$output not exists \n";
}


?>

#==========================================================================
