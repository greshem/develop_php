<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="utf-8" />
<meta name="robots" content="all" />
<meta name="author" content="Tencent-ISRD" />
<meta name="Copyright" content="Tencent" />
<title>HSL colors</title>
</head>
<body>
<div width=100 height=100 style="background-color: hsl(<?php echo $_GET['h']; ?>,<?php echo $_GET['s']; ?>%,<?php echo $_GET['v']; ?>%);color:white;">Firefox </div>
<form action="hsv.php" method=get > 
<select name="h">
<?php 
	for($i=0; $i<=360; $i+=30)
	{
		if($i==$_GET['h'])
		{
		
		echo "<option selected=true   value=".$i.">".$i."</option>\n";
		}
		else
		{
		echo "<option value=".$i.">".$i."</option>\n";
		}
	}
 ?>
</select> 

<select name="s">
<?php 
	for($i=0; $i<=100; $i+=10)
	{
		if($i==$_GET['s'])
		{
			echo "<option selected=true  value=".$i.">".$i."</option>\n";
		}
		else
		{
			echo "<option value=".$i.">".$i."</option>\n";
		}
	}
 ?>
</select> 

<select name="v">
<?php 
	for($i=0; $i<=100; $i+=10)
	{
		if($i==$_GET['v'])
		{
			echo "<option selected=true value=".$i.">".$i."</option>\n";
		}
		else	
		{
			echo "<option value=".$i.">".$i."</option>\n";
		}
	}
 ?>
</select> 

<input type="submit"  name="Submit" value="post">
<input type="submit"  name="Submit" value="post2">
<table>
    <tr> 
      <td width="26%" align="right"> 
        <input type="submit" name="Submit" value="post"> 
	</td>
      <td width="74%"> 
        <input type="reset" name="Reset" value="reset">
      </td>
    </tr>
</table>

<?php 
	$a=$_GET['h'];
	
	$b=$_GET['s'];
	$c=$_GET['v'];
	
	$a=$a*256/360;	
	echo $a."<br>";
	$b=$b*256/100;
	echo $b."<br>";
	$c=$c*256/100;
	echo $c."<br>";
	if(  ! file_exists("/usr/share/pear/Image/Color.php"))
	{	
		echo (" Image/Color.php  not exist ");
		echo " yum intall  yum -y  install php-pear-Image-Color ";
	}
	else
	{
		require_once("Image/Color.php");
		$result=Image_Color::hsv2rgb($a, $b, $c);
		$color_str="#".Image_Color::rgb2hex($result);
		echo "<div height=100 width=100 style=background:".$color_str."> ".$color_str." </div> \n";
	}
	
 ?>

</form>
</body>
</html>
 
