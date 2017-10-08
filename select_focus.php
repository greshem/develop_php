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


</form>
</body>
</html>
 
