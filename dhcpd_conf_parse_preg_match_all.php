<?php  
#########################################################################
class node 
{
	var $mac;								// mac 地址
	var $active;						// 记录是否有效
	
	var $deny;							// 是否禁止
	var $fixedip;						// 是否固定IP地址
	var $ipaddr;						// IP 地址
	
	var $subnet;						// 子网段
	
	var $terminal_default;	// 是否使用默认终端配置
	var $say;								// 提示信息
	var $timeout;						// 超时
	var $default;						// 默认启动选项
	var $allowchoose;				// 是否允许选择启动选项
	var $labels;						// 可选择的启动选项
	
	var $right_default;			// 是否使用默认权限
	var $rights;						// 权限
	
	var $filename;					// 配置文件名，IP地址16进制大写
}


?>

<?php 
#########################################################################
function dec_to_hex($dec) {
	if (! $dec) return '0';
	switch($dec) {
		case 0: return '0';
		case 1: return '1';
		case 2: return '2';
		case 3: return '3';
		case 4: return '4';
		case 5: return '5';
		case 6: return '6';
		case 7: return '7';
		case 8: return '8';
		case 9: return '9';
		case 10: return 'A';
		case 11: return 'B';
		case 12: return 'C';
		case 13: return 'D';
		case 14: return 'E';
		case 15: return 'F';
	}
}

#########################################################################
function ipaddr_to_filename($ipaddr)
{
	$filename = '';
	
	$buffer = preg_split('/\./',$ipaddr);
	if (! $buffer) return '';
	
	foreach($buffer as $key => $value) {
		$filename = $filename . dec_to_hex((int)($value / 16)) . dec_to_hex($value % 16);
	}
	
	return $filename;
}

//########################################################################
#处理 下面方式的字符串, 用个preg_match_all 的方式匹配得来的.  
# host node3 {
#     hardware ethernet 48:5b:39:cb:7c:ce;
#     fixed-address 192.168.1.81;
# 	filename "aoe.0";
# 	option root-path "aoe:e1.1";
# }
function deal_with_one_host($buffer)
{
	$node = new node;

	if (substr($buffer, 0, 1) == "#") 
	{
		$node->active = false;
	} else {
		$node->active = true;
	}

	preg_match('/hardware\s+ethernet\s+(\S+)\s*;/', $buffer, $param);
	$node->mac = $param[1];

	if (preg_match('/deny\s+bootp\s*;/', $buffer, $param)) 
	{
		$node->deny = true;

		$node->fixedip = false;
		$node->terminal_default = true;
		$node->labels = ',';
		$node->right_default = true;
		$node->allowchoose = false;
		$node->rights = ',';
	} else 
	{
		$node->deny = false;
		$node->fixedip = true;
		preg_match('/fixed-address\s+(\S+)\s*;/', $buffer, $param);
		$node->ipaddr = $param[1];
		$node->filename = ipaddr_to_filename($node->ipaddr);

		$node->labels = ',';
		$node->right_default = true;
		$node->rights = ',';
	}

	return $node;
	// 取其他属性，判断 subnet, 暂缓
	#echo "<p>所存的key值是：".$node->mac."</p>";	
}






function parse_dhcpd_conf()
{
	$buffer = file_get_contents("/etc/dhcpd.conf");
	if (! $buffer) 
	{
		die("dhcpd.conf not exists \n");
		return;
	}

	if (! preg_match_all("/(host\s+\S+\s*\{\s*\n(([^\{]|[\n])*)\s*\}\s*)|(#\s*host\s+\S+\s*\{\s*\n(([^\{]|[\n])*)#\s*\}\s*)/",
     $buffer,$match)) 
	{
    // 没有匹配到记录，新的记录保存在文件末尾
    	$fileconfig->prefix = $buffer;
  	} 
	else
	{
	  // 匹配前后缀
	  $strsearch = $match[0][0];
	  $index = strpos($buffer,$strsearch);
	  if ($index) {
	    $fileconfig->prefix = substr($buffer, 0, $index);
	  }
	  
	  $strsearch = $match[0][count($match[0]) - 1];
	  $index = strpos($buffer,$strsearch);
	  if ($index) {
	  	if ( $index + strlen($strsearch) - strlen($buffer) > 0) {
	    	$fileconfig->suffix = substr($buffer, $index + strlen($strsearch) - strlen($buffer));
	    }
	  }
	
	#开始处理每个.	
	  for ($i = 0; $i < count($match[0]); $i++)
	  {
	 	$buffer = $match[0][$i];
		$node=deal_with_one_host($buffer);
	  	$fileconfig->nodes[$node->mac] = $node;
	  	$fileconfig->originmac[$node->mac] = $node->ipaddr;
	  }
	}//endif preg_match_all 

	return $fileconfig;
}

print_r(parse_dhcpd_conf());


 ?>

