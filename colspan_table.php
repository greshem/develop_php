<html>	
<title> �绰��</title>
<style type="text/css"> 
<?
function get_max_row($array)
{
	$max=0;
	foreach ($array as $line)
	{
		$array=preg_split("/\s+/", $line);
		if(count($array) > $max)
		{
			$max=count($array);
		}
	}
	return $max;
}
?>
<!--
/*
	###########################################################	
	#2010_08_04_19:37:58 add by qzj
	�������Ҫ�� ������ÿ��td  �ı������ܵ�table ����ɫ��ͬ�� 
	Ȼ�� cellspaceing �մ�����ɫ�ͳ����ˡ� 
	
	###########################################################	
	#2010_08_05_11:34:14 add by qzj
	# ���ﴦ�����������, ����/etc/passwd 

	#2010_08_22_21:36:39 add by qzj
	��table ��colspan �Ϳ��������� ÿ�е�td ���ԳƵ����⡣ 
	ÿ��ͳ�Ƴ���ÿ�е� Ԫ�ظ�ʽ�� ��ȡ����. 
	
*/
td {background-color:#cccccc;}
-->
</style>

<table cellpadding="1" cellspacing="1" bordercolor="#3366FF" bgcolor="#000000"
	<?php
		$passwd=file_get_contents("./tel_address.txt");
		$lines=split("\n", $passwd);
			
		$max_row=get_max_row($lines);

		foreach ($lines as $line)
		{
			$array=preg_split("/\s+/", $line);
			$len=count($array);
			$col_span=($max_row-$len);
			echo "\t\t<tr>\n";
			echo "\t\t\t";
		
			foreach ($array as $item)
			{
				echo "<td>".$item."</td>";
			}
			if($col_span>0)
			{
				echo "<td colspan=".$col_span."> ___</td>\n";
			}	
			echo "\n";
			echo "\t\t</tr>\n";
		
				
		}
	?>
	</table>
</html>
