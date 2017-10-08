<html>	
<style type="text/css"> 
<!--
/*
	###########################################################	
	#2010_08_04_19:37:58 add by qzj
	这里很重要， 这里让每个td  的背景和总的table 的颜色不同， 
	然后 cellspaceing 空处的颜色就出来了。 
	
	###########################################################	
	#2010_08_05_11:34:14 add by qzj
	# 这里处理矩阵数据了, 先用/etc/passwd 
	
*/
td {background-color:#cccccc;}
-->
</style>

<table cellpadding="1" cellspacing="1" bordercolor="#3366FF" bgcolor="#000000"
	<?php
		$passwd=file_get_contents("/etc/passwd");
		$lines=split("\n", $passwd);
		
		foreach ($lines as $line)
		{
			//$array=preg_split("/\s+/", $line);
			$array=split(":", $line);
			echo "\t\t<tr>\n";
			echo "\t\t\t";
			foreach ($array as $item)
			{
				echo "<td>".$item."</td>";
			}
			
			echo "\n";
			echo "\t\t</tr>\n";
		
				
		}
	?>
	</table>
</html>
