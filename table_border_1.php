<html>	
<style type="text/css"> 
<!--
/*
	###########################################################	
	#2010_08_04_19:37:58 add by qzj
	�������Ҫ�� ������ÿ��td  �ı������ܵ�table ����ɫ��ͬ�� 
	Ȼ�� cellspaceing �մ�����ɫ�ͳ����ˡ� 
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
