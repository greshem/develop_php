<?php  
#########################################################################
class node 
{
	var $mac;								// mac ��ַ
	var $active;						// ��¼�Ƿ���Ч
	
	var $deny;							// �Ƿ��ֹ
	var $fixedip;						// �Ƿ�̶�IP��ַ
	var $ipaddr;						// IP ��ַ
	
	var $subnet;						// ������
	
	var $terminal_default;	// �Ƿ�ʹ��Ĭ���ն�����
	var $say;								// ��ʾ��Ϣ
	var $timeout;						// ��ʱ
	var $default;						// Ĭ������ѡ��
	var $allowchoose;				// �Ƿ�����ѡ������ѡ��
	var $labels;						// ��ѡ�������ѡ��
	
	var $right_default;			// �Ƿ�ʹ��Ĭ��Ȩ��
	var $rights;						// Ȩ��
	
	var $filename;					// �����ļ�����IP��ַ16���ƴ�д
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
#���� ���淽ʽ���ַ���, �ø�preg_match_all �ķ�ʽƥ�������.  
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
	// ȡ�������ԣ��ж� subnet, �ݻ�
	#echo "<p>�����keyֵ�ǣ�".$node->mac."</p>";	
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
    // û��ƥ�䵽��¼���µļ�¼�������ļ�ĩβ
    	$fileconfig->prefix = $buffer;
  	} 
	else
	{
	  // ƥ��ǰ��׺
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
	
	#��ʼ����ÿ��.	
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

