<html>	
<style type="text/css"> 
<!--
/*
	###########################################################	
	#2010_08_04_19:37:58 add by qzj
	这里很重要， 这里让每个td  的背景和总的table 的颜色不同， 
	然后 cellspaceing 空处的颜色就出来了。 
*/
td {background-color:#cccccc;}
-->
</style>
<table cellpadding="1" cellspacing="1" bordercolor="#3366FF" bgcolor="#000000"
	<?php
		foreach (glob("*") as $item)
		{
			echo $item."\n";
			echo "\t\t<tr><td>".$item."</td></tr>\n";
				
		}
	?>
	</table>
</html>
