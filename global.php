<?
global $count;

$count=0;
function dec($count)
{
	global $count;
	$count--;
}

function inc($count)
{
	global $count;
	$count++;
}

dec(0);
dec(0);
dec(0);
dec(0);
inc(1);
inc(1);
inc(1);
inc(1);

echo $count;
?>
