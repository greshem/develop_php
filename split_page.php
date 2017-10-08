<html>
<body>
<?php 
	$seg=10;
	if(isset($_GET['page']))
	{
		$page=$_GET['page'];
	}
	else
	{
		$page=0;
	}
	$array=range(1,100);
	$show_start=$page*$seg;
	$show_end=$show_start+$seg;	

	$show_array=array_slice($array, $show_start, $seg);	
	print_r($show_array);

	$count=count($array)/10;	
 ?>
<form action="split_page.php" method=get> 
<select name="page" >
<?php 
	for($i=0;$i<=$count; $i++)
	{
		if($i==$_GET['page'])
		{
			echo "<option selected=true value=".$i.">".$i."</option> \n";
		}
		else
		{
			echo "<option value=".$i.">".$i."</option> \n";
		}
	}
 ?>
<input type=submit name=submit value=submit >  
</select> 
</form>

</body>
</html>
