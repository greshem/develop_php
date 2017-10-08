<?
	//来自 /root/html_content_create/ 里面。 注重的是排版。 
	//#2010_08_21_20:25:36 add by qzj
?>
<table cellpadding="1" cellspacing="1" bordercolor="#3366FF" bgcolor="#000000" >
	<?php
		$all=glob("*");
		//if(count($all) > 40)
		//#2010_08_17_20:57:09 add by qzj
		//80个元素的时候， 整个列表就会显的很长。 
		foreach (glob("*") as $item)
		{
			//echo $item."\n";
			echo "\t\t<tr><td style=\"background:#cccccc\">".$item."</td></tr>\n";
		//	$count++;
		}
	?>
	</table>
