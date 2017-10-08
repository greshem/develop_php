<?
function echo_tr_gray_line($num)
{
	echo "<tr height=10 bgcolor=#888888 >";
	for($i=0; $i<$num;$i++)
	{
		echo "<td></td>";
	}
	echo "</tr>\n";
}
echo_tr_gray_line(10);
?>

