<html>	
<style type="text/css"> 
<!--
/*
	###########################################################	
	#2010_08_04_19:37:58 add by qzj
	�������Ҫ�� ������ÿ��td  �ı������ܵ�table ����ɫ��ͬ�� 
	Ȼ�� cellspaceing �մ�����ɫ�ͳ����ˡ� 
	
	###########################################################	
	#2010_08_05_11:34:14 add by qzj
	# ���ﴦ�����������, ����/etc/passwd 
	
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
