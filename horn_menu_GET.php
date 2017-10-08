<table align=center >
  <tr>
    <td  height="25" align="right">
	<ul id="menu"  >
	<?php
	include("func.php");		
	if(isset( $_GET['sect']))
	{
		$cur=$_GET['sect'];
	}
	$sects=get_ini_file_sections("petty.ini");
	if(!isset($cur))
	{
		echo "<li > <a href=\"index.php\" >home </a> 	</li>\n";
	}
	else
	{
		echo "<li class=\"focus\" > <a href=\"index.php\" >home </a> 	</li>\n";
	}
	foreach($sects as $each)
	{
		#
		if(isset($cur) && $cur==$each)
		{
			echo "<li  class=\"focus\" > <a href=index.php?sect=".$each." >".$each." </a> 	</li>\n";
		}
		else
		{
			echo "<li > <a href=index.php?sect=".$each." >".$each." </a> 	</li>\n";
		}
	}		
	?>
	
	</ul>
	</td>
  </tr>
</table>
