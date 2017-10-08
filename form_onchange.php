<html>
<body>
<form action="form_onchange.php" method="get">
<?php 
if(isset($_POST['id']))
{
	echo "id=".$_POST['id']."<br>\n";
}
 ?>
<select name="id"  onchange="this.form.submit()" > 
<?php 
	for($i=0; $i<=10;$i++)
	{
		echo "<option value=".$i.">".$i."</option> \n";
	}
?>

</select> 
</body>
</html>
