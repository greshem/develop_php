<?
$var=$_GET["var"];
//echo $var;
ob_start();
if(preg_match("/global/",$var))
{
	echo '$GLOBALS';
	echo '<br>';
	print_r($GLOBALS);
}
elseif(preg_match("/file/",$var))
{
	echo '$_FILES';
	echo '<br>';
		print_r(  $_FILES);
}
elseif(preg_match("/cookie/", $var))
{
	echo '$_COOKIE';
	echo '<br>';
	print_r(  $_COOKIE);
}
elseif(preg_match("/get/", $var))
{
	echo '$_GET';
	echo '<br>';
	print_r(   $_GET   );
}
elseif(preg_match("/post/", $var))
{
	echo '$_POST';
	echo '<br>';
	print_r(  $_POST );
}
elseif(preg_match( "/server/", $var))
{
	echo '_SERVER';
	echo '<br>';
	print_r($_SERVER);

}

ob_end_flush();
$str=ob_get_contents();
echo "<hr>";
echo nl2br($str);
//print_r(   $_SERVER);
//print_r(  $argc );
//print_r(    $argv  );
?>
<html>
<body>
<form action=<?echo $_SERVER[PHP_SELF]?> method='GET'>
<select name="var" >
<option value="cookie">cookie</option>
<option value="global">global</option>
<option value="file">files</option>
<option value="get">get</option>
<option value="post">post</option>
<option value="server">server</option>
 </select>
 <input type="submit" name="Submit" value="submit" />

</form>
</form
</body>
</html>
