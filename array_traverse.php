<?php
function gb2312ToUtf8(&$input)
{    
	if (!is_array($input)) 
	{
		$input = iconv('GB2312', 'UTF-8', $input);
	} else 
	{
		foreach ($input as $k=>$v) 
		{
			gb2312ToUtf8(&$input["$k"]);
		}
	}
}

function utf8ToGb2312(&$input)
{    
	if (!is_array($input)) 
	{
		$input = iconv("UTF-8", 'GB2312',  $input);
	} else 
	{
		foreach ($input as $k=>$v) 
		{
			utf8ToGb2312(&$input["$k"]);
		}
	}
}

$a = array('aa', 'bb');
$b = array($a, 'cc');
gb2312ToUtf8(&$b);
print_r($b);
?>

