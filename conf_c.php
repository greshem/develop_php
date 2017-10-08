<?php require_once('inc/declare.inc') ?>
<?php
session_start();
if (! isset($_SESSION['LOGIN']) || $_SESSION['LOGIN'] != 'OK') {
	header('Location:./index.php');
	exit;
}

define('DHCPD_PATH','/etc/dhcpd.conf');						// dhcpd.conf �ļ�·��
define('LABEL_PATH','/tftpboot/pxelinux.cfg/default');					// default �ļ�·��
define('LEASE_PATH','/var/lib/dhcp/dhcpd.leases');		// dhcp release �ļ�·��
define('RIGHT_PATH','./target/right.conf');							// Ȩ�޶��������ļ�·��
define('USER_PATH','/opt/qianlong/right/userinfotable.dat');				// �û�Ȩ�������ļ�·��
define('TERMINAL_PATH','/tftpboot/pxelinux.cfg/');				// �û�Ȩ�������ļ�·��

$right_config = null;
$subnet_config = null;
$label_config = null;
$config = null;

class right {
	var $id;
	var $name;
}

// �����û�Ȩ������, ���� right ����
function load_right()
{
	$rightconfig = null;
	
	$fp = fopen(RIGHT_PATH ,"r");
	if (! $fp) return $rightconfig;
	
	while (! feof($fp)) {
		$buffer = fgets($fp);
		if (preg_match('/^(\d+)\s+(\S+)\s*\n?$/', $buffer, $match)) {
			$rightconfig[$match[1]] = new right;
			$rightconfig[$match[1]]->id = $match[1];
			$rightconfig[$match[1]]->name = $match[2];
		}
	}
	
	fclose($fp);
	return $rightconfig;
}

class subnet_record {
   var $subnet;
   var $mask;

   var $dns;	
   var $broadcast_address;
   var $domain_name;
   var $routers;
   var $next_server;
   var $filename;

   var $range;
}

class dhcp_config {
  var $prefix;
  var $suffix;
  
  var $allow_unknown;
  
  var $subnets;
}

// ���� dhcp �� subnet ���ã����� dhcp_config
function load_dhcp_subnet()
{
  $fileconfig = new dhcp_config;

  // �������ļ��������¼
  $buffer = qlReadFileString(DHCPD_PATH);
  if (! $buffer) {
      return;
  }

  if (! preg_match_all("/subnet\s+(\S+)\s+netmask\s+(\S+)\s+\{\s*\n(([^\{]|[\n])*)\s*\}\s*/",
     $buffer,$match)) {
    // û��ƥ�䵽��¼���µļ�¼�������ļ�ĩβ
    $config->prefix = $buffer;
  } else {
	  // ƥ��ǰ��׺
	  $strsearch = $match[0][0];
	  $index = strpos($buffer,$strsearch);
	  if ($index) {
	    $fileconfig->prefix = substr($buffer, 0, $index);
	  }
	  
	  $strsearch = $match[0][count($match[0]) - 1];
	  $index = strpos($buffer,$strsearch);
	  if ($index) {
	  	if ($index + strlen($strsearch) - strlen($buffer) < 0) {
	    	$fileconfig->suffix = substr($buffer, $index + strlen($strsearch) - strlen($buffer));
	    }
	  }
		
	  for ($i = 0; $i < count($match[0]); $i++)
	  {
	  	$key = $match[1][$i];
	  	$value = new subnet_record;
	    $value->subnet = $match[1][$i];
	    $value->mask = $match[2][$i];
	
	    // ��ȡrange
	    $buffer = $match[3][$i];
	    if (preg_match_all("/range\s+dynamic-bootp\s+(\S+)\s+(\S+)\s*;/", $buffer, $param)) {
	      for ($j = 0; $j < count($param[0]) ; $j++) {
	        $value->range[] = array(0 => $param[1][$j], 1 => $param[2][$j]);
	      }
	    }
	
	    // ��ȡ��������
	    if (preg_match("/option\s+broadcast-address\s+(\S+)\s*\;/", $buffer, $param)) {
	      $value->broadcast_address = $param[1];
	    }
	    if (preg_match("/option\s+domain-name\s+\"(\S+)\"\s*;/", $buffer, $param)) {
	      $value->domain_name = $param[1];
	    }
	    if (preg_match("/option\s+routers\s+(\S+)\s*;/", $buffer, $param)) {
	      $value->routers = $param[1];
	    }
	    if (preg_match("/option\s+domain-name-servers\s+(\S+)\s*;/", $buffer, $param)) {
	      $value->dns = $param[1];
	    }
	    if (preg_match("/next-server\s+(\S+)\s*;/", $buffer, $param)) {
	      $value->next_server = $param[1];
	    }
	    $value->filename = 'pxelinux.0';
	    
	    $fileconfig->subnets[$key] = $value;
	  }
	}

  if (preg_match("/allow\s+unknown-clients\s*;/", $fileconfig->prefix, $match))
  {
  	$fileconfig->allow_unknown = true;
  }

  return $fileconfig;
}

class terminal {
	var $active;
	var $name;
	
	var $boottype;					// nfs, image
	var $kernel;

	// ���� boottype = image ʱʹ��
	var $image;
	
	// ���� boottype = nfs ʱʹ��
	var $nfs;
	var $ram;

	var $displaymode;
	var $debug;
}

class label_config {
  var $prefix;
  var $suffix;
  
  var $say;
  var $timeout;
  var $default;
  var $allowchoose;
  
  var $terminals;
}

// ���� terminal ���ã����� label_config
function load_terminal($filename)
{
  $terminalconfig = new label_config;

  // �������ļ��������¼
  $buffer = qlReadFileString($filename);
  if (! $buffer) {
      return;
  }

  if (! preg_match_all('/(label\s+\d+\s+.*\n\s*kernel\s+.*\n\s*append\s+.*\n\s*IPAPPEND\s+1)'
  			.'|(#label\s+\d+\s+.*\n#\s*kernel\s+.*\n#\s*append\s+.*\n#\s*IPAPPEND\s+1)'
  			.'|(label\s+\d+\s+.*\n\s*kernel\s+.*\n\s*append\s+.*)'
  			.'|(#label\s+\d+\s+.*\n#\s*kernel\s+.*\n#\s*append\s+.*)/',
     $buffer,$match)) {
    // û��ƥ�䵽��¼���µļ�¼�������ļ�ĩβ
    //echo 'no match';
    $config->prefix = $buffer;
  } else {
	  // ƥ��ǰ׺
	  $strsearch = $match[0][0];
	  $index = strpos($buffer,$strsearch);
	  if ($index) {
	    $terminalconfig->prefix = substr($buffer, 0, $index);
	  }
	  
	  // ƥ���׺
	  $strsearch = $match[0][count($match[0]) - 1];
	  $index = strpos($buffer,$strsearch);
	  if ($index) {
	    $terminalconfig->suffix = substr($buffer, $index + strlen($strsearch) - strlen($buffer));
	  }
		
    for ($i = 0; $i < count($match[0]); $i++) {
    	$terminal_record = new terminal;
    	//echo $i . "<br>\n";
    	
    	// ��ȡ����
			$strsearch = $match[1][$i];
			if (! $strsearch) $strsearch = $match[2][$i];
			if (! $strsearch) $strsearch = $match[3][$i];
			if (! $strsearch) $strsearch = $match[4][$i];
			
			//echo '<pre>' . $strsearch . '</pre>';
			
			// ���� active ���
			if (substr($strsearch, 0, 1) == "#") {
				$terminal_record->active = false;
				//echo "not active<br>\n";
			} else {
				$terminal_record->active = true;
				//echo "active<br>\n";
			}

			// ��ȡ name
			preg_match('/label\s+\d+\s+(\S+)/',$strsearch, $submatch);
			$terminal_record->name = $submatch[1];
			//echo 'name ' . $submatch[1] . "<br>\n";
			
			// ȷ��kernel
			preg_match('/kernel\s+(\S+)/',$strsearch, $submatch);
			$terminal_record->kernel = $submatch[1];
			//echo 'kernel ' . $submatch[1] . "<br>\n";
			
			// ȷ�� nfs / image
			if (preg_match('/root=\/dev\/nfs/', $strsearch, $submatch)) {
				// nfs
				$terminal_record->boottype = 'NFS';
				//echo 'NFS<br>';
				preg_match('/nfsroot=\S+:\/(\S+)/',$strsearch, $submatch);
				$terminal_record->nfs = $submatch[1];
				//echo 'nfs path : ' . $submatch[1] . "<br>\n";
			} else {
				// image
				$terminal_record->boottype = 'IMAGE';
				//echo 'IMAGE<br>';
				preg_match('/initrd=(\S+)/',$strsearch, $submatch);
				$terminal_record->image = $submatch[1];
				//echo 'image file : ' . $submatch[1] . "<br>\n";
			}
			
			// ram
			if (preg_match('/ramdisk_size=(\d+)\s+/', $strsearch, $submatch))
			{
				$terminal_record->ram = $submatch[1];
				//echo 'ram=' . $submatch[1] . "<br>\n";
			}
	
			// displaymode
			if (preg_match('/video=intelfb/', $strsearch, $submatch))
			{
				$terminal_record->displaymode = 'INTELFB';
				//echo 'video=' . $submatch[1] . "<br>\n";
			}
			if (preg_match('/vga=0x301/', $strsearch, $submatch))
			{
				$terminal_record->displaymode = 'VESA';
				//echo 'video=' . $submatch[1] . "<br>\n";
			}
			
			// debug
			if (preg_match('/debug/', $strsearch, $submatch))
			{
				$terminal_record->debug = true;
			} else {
				$terminal_record->debug = false;
			}

			$terminalconfig->terminals[$terminal_record->name] = $terminal_record;
		}
  }
  
	// ƥ��ǰ׺����
	$strsearch = $terminalconfig->prefix;
	if (preg_match('/say\s+(.*)\s*\n/', $strsearch, $submatch)) {
		$terminalconfig->say = $submatch[1];
	}
	if (preg_match('/timeout\s+(\S+)/', $strsearch, $submatch)) {
		$terminalconfig->timeout = $submatch[1];
	}
	if (preg_match('/default\s+(\S+)/', $strsearch, $submatch)) {
		if ($terminalconfig->terminals && count($terminalconfig->terminals) > 0) {
			$index = 1;
			foreach ($terminalconfig->terminals as $key => $value) {
				if ($index == $submatch[1]) {
					$terminalconfig->default = $key;
					break;
				}
				$index++;
			}
		}
	}
	if (preg_match('/prompt\s+(\d)/',$strsearch, $submatch)) {
		$terminalconfig->allowchoose = $submatch[1] != 0;
	} else {
		$terminalconfig->allowchoose = false;
	}		

  return $terminalconfig;
}

class node {
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

class node_config {
  var $prefix;
  var $suffix;
  
  var $nodes;							// dhcpd.conf node �б�
  var $leases;						// dpchd.lease �� lease �б�
  
  var $right_prefix;			// Ȩ���ļ�ǰ׺
  var $right_suffix;			// Ȩ���ļ���׺
  var $defaultrights;			// Ĭ��Ȩ��
  var $unknownrights;			// �޷�ʶ���Ȩ��
  
  var $originmac;					// ԭʼmac��¼
}

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

function load_file($rights, $subnets, $terminals)
{
  $fileconfig = new node_config;

  // �������ļ��������¼
  $buffer = qlReadFileString(DHCPD_PATH);
  if (! $buffer) {
      return;
  }

  if (! preg_match_all("/(host\s+\S+\s*\{\s*\n(([^\{]|[\n])*)\s*\}\s*)|(#\s*host\s+\S+\s*\{\s*\n(([^\{]|[\n])*)#\s*\}\s*)/",
     $buffer,$match)) {
    // û��ƥ�䵽��¼���µļ�¼�������ļ�ĩβ
    $fileconfig->prefix = $buffer;
  } else {
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
		
	  for ($i = 0; $i < count($match[0]); $i++)
	  {
	  	$buffer = $match[0][$i];
	  	$node = new node;

			if (substr($buffer, 0, 1) == "#") {
				$node->active = false;
			} else {
				$node->active = true;
			}
	  	
	  	preg_match('/hardware\s+ethernet\s+(\S+)\s*;/', $buffer, $param);
	  	$node->mac = $param[1];
	  	
	  	if (preg_match('/deny\s+bootp\s*;/', $buffer, $param)) {
	  		$node->deny = true;

				$node->fixedip = false;
				$node->terminal_default = true;
		  	$node->labels = ',';
		  	$node->right_default = true;
  			$node->allowchoose = false;
		  	$node->rights = ',';
	  	} else {
	  		$node->deny = false;
	  		$node->fixedip = true;
		  	preg_match('/fixed-address\s+(\S+)\s*;/', $buffer, $param);
		  	$node->ipaddr = $param[1];
		  	$node->filename = ipaddr_to_filename($node->ipaddr);
		  	
		  	$node->labels = ',';
		  	$node->right_default = true;
		  	$node->rights = ',';

		  	// ������������
	  		if (file_exists(TERMINAL_PATH . $node->filename)) {
	  			$node->terminal_default = false;
	  			$node_config = load_terminal(TERMINAL_PATH . $node->filename);
	  			
	  			$node->say = $node_config->say;
	  			$node->timeout = $node_config->timeout;
	  			$node->default = $node_config->default;
	  			$node->allowchoose = $node_config->allowchoose;
	  			
	  			if (isset($node_config->terminals)) {
	  				foreach($node_config->terminals as $key => $value) {
	  					if (isset($terminals[$key])) {
	  						$node->labels = $node->labels . $key . ',';
	  					}
	  				}
	  			}
	  		} else {
	  			$node->terminal_default = true;
	  		}
	  	}
	  	
	  	// ȡ�������ԣ��ж� subnet, �ݻ�
	  	
	  	
	  	$fileconfig->nodes[$node->mac] = $node;
	  	$fileconfig->originmac[$node->mac] = $node->ipaddr;
	  }
	}

	// ���� release ��¼
  $buffer = qlReadFileString(LEASE_PATH);
  if (preg_match_all("/lease\s+(\S+)\s+\{\s*\n(([^\{]|[\n])*)\s*\}\s*/",
     $buffer,$match)) {
	  for ($i = 0; $i < count($match[0]); $i++)
	  {
	  	$node = new node;
	  	$node->ipaddr = $match[1][$i];
	  	$node->filename = ipaddr_to_filename($node->ipaddr);
	  	
	  	$buffer = $match[0][$i];
	  	preg_match('/hardware\s+ethernet\s+(\S+)\s*;/', $buffer, $param);
	  	$node->mac = $param[1];
	  	
	  	if (isset($node->mac) && $node->mac != '') {
	  		$fileconfig->leases[$node->mac] = $node;
	  	}
	  }
  }

	// ɨ��Ȩ�޼�¼
	$buffer = qlReadFileString(USER_PATH);
	//echo '<pre>' . $buffer . '</pre>';
	if (! preg_match_all("/\n\s*((?!;)\S+)\s*\:.*/",
     $buffer,$match)) {
  	$fileconfig->right_prefix = $buffer;
  	
  	if (isset($fileconfig->nodes)) {
  		foreach($fileconfig->nodes as $key => $value) {
  			$fileconfig->nodes[$key]->right_default = true;
  		}
  	}
  	//echo 'no match';
  } else {
	  // ƥ��ǰ��׺
	  $strsearch = $match[0][0];
	  $index = strpos($buffer,$strsearch);
	  if ($index) {
	    $fileconfig->right_prefix = substr($buffer, 0, $index);
	  }
	  
	  $strsearch = $match[0][count($match[0]) - 1];
	  $index = strpos($buffer,$strsearch);
	  if ($index) {
	  	if ($index + strlen($strsearch) - strlen($buffer) > 0) {
	    	$fileconfig->right_suffix = substr($buffer, $index + strlen($strsearch) - strlen($buffer));
	    }
	  }
		
		//echo 'prefix';
		//echo '<pre>' . $fileconfig->right_prefix . '</pre>';
		//echo 'suffix';
		//echo '<pre>' . $fileconfig->right_suffix . '</pre>';
	  for ($i = 0; $i < count($match[0]); $i++)
	  {
	  	$buffer = $match[0][$i];
	  	preg_match('/\s*(\S+)\s*:(.*)/',$buffer, $submatch);
	  	
	  	// ����Ȩ�޼�¼
	  	$username = $submatch[1];
	  	$originright = $submatch[2];
	  	$userright = ',';
	  	$submatch = preg_split('/,/', $submatch[2]);
	  	for ($j = 0; $j < count($submatch); $j++) {
	  		if (isset($rights[trim($submatch[$j])])) {
	  			$userright = $userright . trim($submatch[$j]) . ',';
	  		}
	  	}
	  	
	  	//echo $username . ' : ' . $userright .' ; ' ;
	  	if ($username == '[default]') {
	  		$fileconfig->defaultrights = $userright;
	  	} else {
	  		$notfind = true;
	  		if (isset($fileconfig->nodes) && count($fileconfig->nodes) > 0) {
		  		foreach($fileconfig->nodes as $key => $value) {
		  			if ($fileconfig->nodes[$key]->deny) continue;
		  			if (! $fileconfig->nodes[$key]->fixedip) continue;
		  			
		  			if ($username == $key) {
		  				$fileconfig->nodes[$key]->right_default = false;
		  				$fileconfig->nodes[$key]->rights = $userright;
		  				$notfind = false;
		  				break;
		  			}
		  		}
	  		}
	  		
	  		if ($notfind) {
	  			//echo $username . ' -> ' . $userright . '<br>';
	  			$fileconfig->unknownrights[$username] = $originright;
	  		}
	  	}
	  }
  }
	
	//echo count($fileconfig->unknownrights);
  return $fileconfig;
}

function file_write($fileconfig, $rights, $subnets, $terminals)
{
	$localhost = 'localhost';
	if (isset($subnets) && count($subnets) > 0) {
		foreach($subnets as $key => $value) {
			$localhost = $value->next_server;
		}
	}
	
	// ���ԭ���������ļ�
	if (isset($fileconfig->originmac)) {
		foreach($fileconfig->originmac as $key => $value) {
			if (isset($value) && $value != '') {
				if (file_exists(TERMINAL_PATH . ipaddr_to_filename($value))) {
					unlink(TERMINAL_PATH . ipaddr_to_filename($value));
				}
				if (file_exists(TERMINAL_PATH . ipaddr_to_filename($value) . '.list')) {
					unlink(TERMINAL_PATH . ipaddr_to_filename($value) . '.list');
				}
			}
		}
	}

	$fp = fopen(DHCPD_PATH,"w");
	fwrite($fp, $fileconfig->prefix);
	
	if (isset($fileconfig->nodes)) {
		$mainindex = 0;
		foreach($fileconfig->nodes as $key => $value) {
			$tag = ($value->active ? '' : '#');

			if ($value->deny) {
				$mainindex++;
				fwrite($fp, $tag . 'host node' . $mainindex . " {\n");
				fwrite($fp, $tag . '    hardware ethernet ' . $value->mac . ";\n");
				fwrite($fp, $tag . "    deny bootp;\n");
				fwrite($fp, $tag . "    deny booting;\n");
				fwrite($fp, $tag . "}\n");
				continue;
			}

			if (! $value->fixedip) {
				$mainindex++;
				fwrite($fp, $tag . 'host node' . $mainindex . " {\n");
				fwrite($fp, $tag . '    hardware ethernet ' . $value->mac . ";\n");
				fwrite($fp, $tag . "    allow bootp;\n");
				fwrite($fp, $tag . "    allow booting;\n");
				fwrite($fp, $tag . "}\n");
				continue;
			}

			$mainindex++;
			fwrite($fp, $tag . 'host node' . $mainindex . " {\n");
			fwrite($fp, $tag . '    hardware ethernet ' . $value->mac . ";\n");
			fwrite($fp, $tag . '    fixed-address ' . $value->ipaddr . ";\n");
			
			if ($value->subnet) {
				if (isset($subnets)) {
					foreach($subnets as $subkey => $subvalue) {
						if ($subkey == $value->subnet) {
							if ($subvalue->broadcast_address) {
								fwrite($fp, $tag . '    option broadcast-address ' . $subvalue->broadcast_address . ";\n");
							}
							if ($subvalue->domain_name) {
								fwrite($fp, $tag . '    option domain-name "' . $subvalue->domain_name . "\";\n");
							}
							if ($subvalue->routers) {
								fwrite($fp, $tag . '    option routers ' . $subvalue->routers . ";\n");
							}
							if ($subvalue->dns) {
								fwrite($fp, $tag . '    option domain-name-servers ' . $subvalue->dns . ";\n");
							}
							if ($subvalue->next_server) {
								fwrite($fp, $tag . '    next-server ' . $subvalue->next_server . ";\n");
							}
							if ($subvalue->filename) {
								fwrite($fp, $tag . '    filename "' . $subvalue->filename . "\";\n");
							}
						}
					}
				}
			}
			fwrite($fp, $tag . "}\n");

			if ($value->active && ! $value->terminal_default) {
					// ����������Ϣ, д�� �����ļ�
					$subfp = fopen(TERMINAL_PATH . ipaddr_to_filename($value->ipaddr), "w");
					
					fwrite($subfp, 'say ' . $value->say . "\n");
					fwrite($subfp, 'timeout ' . $value->timeout . "\n");
	
					$index = 1;
					foreach($terminals as $subkey => $subvalue) {
						if (! $value->allowchoose || strpos(',' . $value->labels, ',' . $subkey . ',')) {
							if ($value->default == $subkey) {
								fwrite($subfp, 'default ' . $index . "\n");
								break;
							}
							$index++;
						}
					}
	
					if ($value->allowchoose) {
						fwrite($subfp, "prompt 1\n");
						fwrite($subfp, 'display pxelinux.cfg/' . ipaddr_to_filename($value->ipaddr) . ".list\n");
					} else {
						fwrite($subfp, "prompt 0\n");
					}
	
					$index = 1;
					foreach($terminals as $subkey => $subvalue) {
						if (! $value->allowchoose || strpos(',' . $value->labels, ',' . $subkey . ',')) {
							fwrite($subfp, 'label ' . $index . ' ' . $subvalue->name . "\n");
							fwrite($subfp, '  kernel ' . $subvalue->kernel . "\n");
				
							$line = '';
							switch($subvalue->boottype) {
								case 'NFS':
								  $line = '  append root=/dev/nfs nfsroot=' . $localhost . ':/' . $subvalue->nfs
								  		. ' ip=dhcp init=/bin/sh';
									break;
								case 'IMAGE':
								  $line = '  append initrd=' . $subvalue->image 
								  		. ' ramdisk_size=' . $subvalue->ram
								  		. ' root=/dev/ram0 init=/bin/sh';
									break;
							}
							switch($subvalue->displaymode) {
								case "VESA":
									$line = $line . ' vga=0x301';
									break;
								case "INTELFB":
									$line = $line . ' video=intelfb:mode=640x480-4';
									break;
							}
							if ($subvalue->debug) {
								$line = $line . ' debug';
							}
							fwrite($subfp, $line . "\n");
				
							
							if ($subvalue->boottype == 'IMAGE') {
								fwrite($subfp, "  IPAPPEND 1\n");
							}
							$index++;
						}
					}
	
					fclose($subfp);
					
					if (! $value->allowchoose) continue;
					
					$subfp = fopen(TERMINAL_PATH . ipaddr_to_filename($value->ipaddr) . '.list', "w");
					fwrite($subfp, "Choose one of the following Linux Image\n");
					fwrite($subfp, "------------------------------------------------------------\n");
					$index = 1;
					foreach($terminals as $subkey => $subvalue) {
						if (! $value->allowchoose || strpos(',' . $value->labels, ',' . $subkey . ',')) {
							fwrite($subfp, $index . ') ' . $subkey . "\n");
							$index++;
						}
					}
					fwrite($subfp, "------------------------------------------------------------\n");
					fclose($subfp);
			}
		}
	}

	fwrite($fp, $fileconfig->suffix);
	fclose($fp);
	
	// дȨ���ļ�
	$fp = fopen(USER_PATH,"w");
	fwrite($fp, $fileconfig->right_prefix);
	if ($fileconfig->defaultrights == ',') {
		fwrite($fp, "\n[default]:");
	} else {
		//echo $fileconfig->defaultrights;
		fwrite($fp, "\n[default]:" . substr($fileconfig->defaultrights, 1, strlen($fileconfig->defaultrights) - 2));
	}
	if (isset($fileconfig->nodes)) {
		foreach($fileconfig->nodes as $key => $value) {
			if ($value->deny) continue;
			if (! $value->fixedip) continue;
			if ($value->right_default) continue;
			
			if ($value->rights == ',') {
				fwrite($fp, "\n" . $value->mac . ":");
			} else {
				fwrite($fp, "\n" . $value->mac . ':' . substr($value->rights, 1, strlen($value->rights) - 2));
			}
		}
	}
	if (isset($fileconfig->unknownrights)) {
		foreach($fileconfig->unknownrights as $unknownkey => $unknownvalue) {
			$notfind = true;
			foreach($fileconfig->nodes as $key => $value) {
				if ($key == $unknownkey) {
					$notfind = false;
					break;
				}
			}
			
			if ($notfind) {
				fwrite($fp, "\n" . $unknownkey . ':' . $unknownvalue);
			}
		}
	}
	
	fwrite($fp, $fileconfig->right_suffix);
	fclose($fp);

	return '�ļ�����ɹ�';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
  <title>����վ����</title>
  <link href="./main.css" type="text/css" rel="stylesheet" />
  <script language="javascript" src="./jslib.js"></script>
</head>
<body>

<?php
$alert = '';
$mode = 'MAIN';
$node = '';
$node_record = null;

$command = get_command();
$parameter = get_parameter();

$right_config = null;
$subnet_config = null;
$label_config = null;
$config = null;

if (get_command()) {
  $right_config = $_SESSION['RIGHT'];
  $subnet_config = $_SESSION['SUBNET'];
  $label_config = $_SESSION['TERMINAL'];
  $config = $_SESSION['NODE'];
} else {
	$right_config = load_right();
	$subnet_config = load_dhcp_subnet();
	$label_config = load_terminal(LABEL_PATH);
	$config = load_file($right_config, $subnet_config->subnets, $label_config->terminals);
	
  $_SESSION['RIGHT'] = $right_config;
  $_SESSION['SUBNET'] = $subnet_config;
  $_SESSION['TERMINAL'] = $label_config;
  $_SESSION['NODE'] = $config;
}

// ��ȡĬ��Ȩ��
if ($command == 'DISABLE_NODE' || $command == 'ENABLE_NODE'
	|| $command == 'SAVE_FILE' || $command == 'DELETE_NODE'
	|| $command == 'EDIT_NODE' || $command == 'NEW_NODE') {
	$defaultrights = ',';
	if ($right_config) {
		foreach($right_config as $key => $value) {
			if (get_request('right_' . $key) == 'on') {
				$defaultrights = $defaultrights . $key . ',';
			}
		}
		
		$config->defaultrights = $defaultrights;
	}
	//echo $defaultrights;
}

if ($command == 'SAVE_FILE') {
	$alert = file_write($config, $right_config, $subnet_config->subnets, $label_config->terminals);
} elseif ($command == 'DISABLE_NODE') {
	$config->nodes[$parameter]->active = false;
} elseif ($command == 'ENABLE_NODE') {
	$config->nodes[$parameter]->active = true;
} elseif ($command == 'DELETE_NODE') {
	unset($config->nodes[$parameter]);
	$config->deletemac[$parameter] = '';
} elseif ($command == 'NEW_NODE') {
	$mode = 'NODE';
	$node = '';

	$node_record = new node;
	$node_record->mac = '';
	$node_record->ipaddr = '';
	$node_record->fixedip = true;
	$node_record->active = true;
	$node_record->deny = false;
	$node_record->terminal_default = true;
	$node_record->allowchoose = false;
	$node_record->labels = ',';
	$node_record->right_default = true;
 	$node_record->rights = ',';
} elseif ($command == 'EDIT_NODE') {
	$mode = 'NODE';
	$node = $parameter;
	
	if (isset($config->nodes[$node])) {
		$node_record = $config->nodes[$node];
	} else {
		$node_record = new node;
		$node_record->mac = $config->leases[$node]->mac;
		$node_record->ipaddr = $config->leases[$node]->ipaddr;
		$node_record->fixedip = true;
		$node_record->active = true;
		$node_record->deny = false;
		$node_record->terminal_default = true;
		$node_record->allowchoose = false;
	 	$node_record->labels = ',';
		$node_record->right_default = true;
	 	$node_record->rights = ',';
	}
} elseif ($command == 'SAVE_NODE') {
	$node_record = new node;
	if ($parameter == '')
	{
		$node_record->mac = get_request('mac');
	} else {
		$node_record->mac = $parameter;
	}
	$node_record->deny = get_request('deny') != 'on';
	if ($node_record->deny) {
		$node_record->fixedip = false;
		$node_record->terminal_default = true;
  	$node_record->labels = ',';
  	$node_record->right_default = true;
		$node_record->allowchoose = false;
  	$node_record->rights = ',';
	} else {
		$node_record->fixedip = get_request('fixedip') == 'on';
		if ($node_record->fixedip) {
	  	$node_record->ipaddr = get_request('ipaddr');
	  	$node_record->subnet = get_request('subnet');
	
	  	$node_record->terminal_default = get_request('default_terminal') == 'on';
	  	if (! $node_record->terminal_default) {
		  	$node_record->say = get_request('say');
		  	$node_record->timeout = get_request('timeout');
		  	$node_record->default = get_request('default');

		  	$node_record->allowchoose = get_request('allowchoose') == 'on';
		  	$node_record->labels = ',';
		  	if ($node_record->allowchoose) {
		  		if (isset($label_config->terminals)) {
		  			foreach($label_config->terminals as $key => $value) {
		  				if (get_request('terminal_' . $key) == 'on') {
						  	$node_record->labels = $node_record->labels . $key . ',';
		  				}
		  			}
		  		}
		  	}
	  	}
	  	
	  	$node_record->right_default = get_request('defaultright') == 'on';
	  	$node_record->rights = ',';
	  	if (! $node_record->right_default) {
	  		if (isset($right_config)) {
	  			foreach($right_config as $key => $value) {
	  				if (get_request('right_' . $key) == 'on') {
					  	$node_record->rights = $node_record->rights . $key . ',';
	  				}
	  			}
	  		}
	  	}
		} else {
	  	$node_record->terminal_default = true;
	  	$node_record->labels = ',';
	  	$node_record->right_default = true;
	  	$node_record->rights = ',';
		}
	}

	if (isset($config->nodes[$node_record->mac])) {
		$node_record->active = $config->nodes[$node_record->mac]->active;
	} else {
		$node_record->active = true;
	}
	$config->nodes[$node_record->mac] = $node_record;	
}

$_SESSION['NODE'] = $config;
?>

<script language="javascript">
function TestPing(strIp , strLbId)
{
	
	var xmlhttp ;
	var objDisp = document.getElementById(strLbId) ;
	if( objDisp  != null )
		objDisp.innerText = "���ڻ�ȡ..." ;
	try
	{
		xmlhttp = new XMLHttpRequest() ;
	}
	catch(e)
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP") ;
	}
	xmlhttp.onreadystatechange=function(){
		if( 4==xmlhttp.readyState){
			if( 200 == xmlhttp.status)
			{
				var strRl = xmlhttp.responseText ;
				if( objDisp  != null )
				{
					if( strRl == "---" )
					{
						objDisp.innerText = strRl ;
					}
					else
					{
						objDisp.innerText = strRl + "ms" ;
					}
				}
			}//if
		}//function
	}//xmlhttp.onreadystatechange
	xmlhttp.open("get" , "qlPing.php?ip="+strIp , true ) ;
	xmlhttp.send() ;
}

function RestartDHCP()
{
	var xmlhttp ;
	try
	{
		xmlhttp = new XMLHttpRequest() ;
	}
	catch(e)
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP") ;
	}
	xmlhttp.onreadystatechange=function(){
		if( 4==xmlhttp.readyState){
			if( 200 == xmlhttp.status)
			{
				var strRl = xmlhttp.responseText ;
				alert(strRl);
			}//if
		}//function
	}//xmlhttp.onreadystatechange
	xmlhttp.open("get" , "restartdhcp.php", true ) ;
	xmlhttp.send() ;
}
</script>

<form name="form1" method="post" action="conf_c.php">
<?php require('inc/pagehead.inc') ?>

<h2>����վ����</h2>

<?php
if ($mode == 'MAIN') {
	// ��ʾ���б�
?>
<script language=javascript>
function delete_node(node)
{
	if (! confirm("ȷ��Ҫɾ����¼�� ?")) return;
	PostBack('DELETE_NODE',node);
}

function new_node()
{
	PostBack('NEW_NODE','');
}
</script>

<table cellpadding=1 cellspacing=1 border=0 bgcolor=silver>
	<tr>
		<td align=center bgcolor=white width=180>������ַ</td>
		<td align=center bgcolor=white width=180>ʹ�õ�ַ</td>
		<td align=center bgcolor=white width=50>����</td>
		<td align=center bgcolor=white width=120>״̬</td>
		<td colspan=3 bgcolor=white>&nbsp;</td>
	</tr>
	<?php
	$index = 1;
	$script = '';
	
	if (isset($config->nodes) && count($config->nodes) > 0) {
		foreach($config->nodes as $key => $value) {
			echo '<tr><td align=center bgcolor=white>' . $value->mac . '</td>';
			echo '<td align=center bgcolor=white>' . $value->ipaddr . '</td>';
			echo '<td align=center bgcolor=white>' . ($value->active ? '��Ч' : '����') . '</td>';
			echo '<td align=center bgcolor=white><div id=ping_' . $index . '>--</div></td>';
			
			echo "<td width=40 align=center bgcolor=white><a href='javascript:PostBack(\"EDIT_NODE\",\"" 
				. $key . "\");'>�༭</a></td>";
			echo "<td width=40 align=center bgcolor=white><a href='javascript:delete_node(\"" 
				. $key . "\");'>ɾ��</a></td>";
			if ($value->active) {
				echo "<td width=40 align=center bgcolor=white><a href='javascript:PostBack(\"DISABLE_NODE\",\"" 
					. $key . "\");'>����</a></td>";
			} else {
				echo "<td width=40 align=center bgcolor=white><a href='javascript:PostBack(\"ENABLE_NODE\",\"" 
					. $key . "\");'>����</a></td>";
			}
			echo "</tr>\n";

			$script = $script . "TestPing('" . $value->ipaddr . "','ping_" . $index . "');\n";
			$index++;
		}
	}

	if (isset($config->leases) && count($config->leases) > 0) {
		foreach($config->leases as $key => $value) {
			if (isset($config->nodes[$key])) continue;

			echo '<tr><td align=center bgcolor=white>' . $value->mac . '</td>';
			echo '<td align=center bgcolor=white>' . $value->ipaddr . '</td>';
			echo '<td align=center bgcolor=white>��̬</td>';
			echo '<td align=center bgcolor=white><div id=ping_' . $index . '>--</div></td>';
			
			echo "<td width=40 align=center bgcolor=white><a href='javascript:PostBack(\"EDIT_NODE\",\"" 
				. $key . "\");'>�༭</a></td>";
			echo "<td width=40 align=center bgcolor=white>&nbsp;</td>";
			echo "<td width=40 align=center bgcolor=white>&nbsp;</td>";

			$script = $script . "TestPing('" . $value->ipaddr . "','ping_" . $index . "');\n";
			$index++;
		}
	}
	
	?>
</table>
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type=button value="�� ��" onclick="new_node();" class="STD_BUTTON" />
<br>
<br>
<table  cellpadding=1 cellspacing=1 border=0>
	<tr valign=top><td width=120>
		Ĭ���û�Ȩ��
	</td><td>
		<?php
		if (isset($right_config)) {
			foreach($right_config as $key => $value) {
				echo '<input type="checkbox" name="right_' . $key . '"';
				if (strpos(',' . $config->defaultrights, ',' . $key . ',')) {
					echo ' checked';
				}
				echo ' />&nbsp;&nbsp;' . $value->name . "<br>\n";
			}
		}
		?>
	</td></tr>
</table>

<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type=button value="�����ļ�" onclick="PostBack('SAVE_FILE','');" class="STD_BUTTON" />

<script language=javascript>
<?php
echo $script;
?>
</script>
<?php
} else {
	// ��ʾ��¼
?>

<script language=javascript>
function check_status()
{
	if (! (document.all["deny"].checked && document.all["fixedip"].checked)) {
		document.all["fixedip"].disabled = ! document.all["deny"].checked;
		document.all["default_terminal"].disabled = true;
		document.all["ipaddr"].disabled = true;
		document.all["subnet"].disabled = true;
		document.all["say"].disabled = true;
		document.all["timeout"].disabled = true;
		document.all["default"].disabled = true;
		document.all["allowchoose"].disabled = true;
		document.all["defaultright"].disabled = true;

		for (var i=0; i < document.form1.elements.length; i++) {
			if (document.form1.elements[i].type == 'checkbox') {
				if (document.form1.elements[i].name.substr(0, 2) == 'ri') {
					document.form1.elements[i].disabled = true;
				}
				if (document.form1.elements[i].name.substr(0, 2) == 'te') {
					document.form1.elements[i].disabled = true;
				}
			}
		}
	} else {
		document.all["fixedip"].disabled = false;
		document.all["ipaddr"].disabled = false;
		document.all["subnet"].disabled = false;

		document.all["default_terminal"].disabled = false;
		if (document.all["default_terminal"].checked) {
			document.all["say"].disabled = true;
			document.all["timeout"].disabled = true;
			document.all["default"].disabled = true;
			document.all["allowchoose"].disabled = true;
			
			for (var i=0; i < document.form1.elements.length; i++) {
				if (document.form1.elements[i].type == 'checkbox') {
					if (document.form1.elements[i].name.substr(0, 2) == 'te') {
						document.form1.elements[i].disabled = true;
					}
				}
			}
		} else {
			document.all["say"].disabled = false;
			document.all["timeout"].disabled = false;
			document.all["default"].disabled = false;
			document.all["allowchoose"].disabled = false;

			for (var i=0; i < document.form1.elements.length; i++) {
				if (document.form1.elements[i].type == 'checkbox') {
					if (document.form1.elements[i].name.substr(0, 2) == 'te') {
						document.form1.elements[i].disabled = ! document.all["allowchoose"].checked;
					}
				}
			}
		}

		document.all["defaultright"].disabled = false;
		for (var i=0; i < document.form1.elements.length; i++) {
			if (document.form1.elements[i].type == 'checkbox') {
				if (document.form1.elements[i].name.substr(0, 2) == 'ri') {
					document.form1.elements[i].disabled = document.all["defaultright"].checked;
				}
			}
		}
	}
}

function save_node(node)
{
	var status = false;
	
	if (node == "")
	{
		if (document.all["mac"].value == "") {
			alert("������MAC��ַ");
			return;
		}
	}

	if (document.all["deny"].checked && document.all["fixedip"].checked) {
		if (document.all["ipaddr"].value == "") {
			alert("������IP��ַ");
			return;
		}
		if (document.all["subnet"].value == "") {
			alert("��ѡ�������趨");
			return;
		}
		
		if (! document.all["default_terminal"].checked) {
			if (document.all["say"].value == "") {
				alert("������������ʾ");
				return;
			}
			if (document.all["timeout"].value == "") {
				alert("��������ʾʱ��");
				return;
			}
			if (document.all["default"].value == "") {
				alert("��ѡ��Ĭ��ϵͳ");
				return;
			}
			if (document.all["allowchoose"].checked) {
				status = false;
				for (var i=0; i < document.form1.elements.length; i++) {
					if (document.form1.elements[i].type == 'checkbox') {
						if (document.form1.elements[i].name.substr(0, 2) == 'te') {
							status = status || document.form1.elements[i].checked;
						}
					}
				}
				if (! status) {
					alert("��ѡ������ϵͳ");
					return;
				}
			}
		}

		if (! document.all["defaultright"].checked) {
			status = false;
			for (var i=0; i < document.form1.elements.length; i++) {
				if (document.form1.elements[i].type == 'checkbox') {
					if (document.form1.elements[i].name.substr(0, 2) == 'ri') {
						status = status || document.form1.elements[i].checked;
					}
				}
			}
			if (! status) {
				alert("��ѡ��Ȩ��");
				return;
			}
		}
	}
	
	PostBack('SAVE_NODE',node);
}
</script>
<table cellpadding=0 cellspacing=1 border=0>
	<tr>
		<td width=100>MAC��ַ</td>
		<td width=270>
			<?php 
				if ($parameter == '') {
					echo "<input type=text name=mac style='width:240px;'";
					echo " value='" . str_replace("'", "''", $node_record->mac) . "'";
					echo ' />';
				} else {
					echo $node_record->mac;
				}
			?>
		</td>
		<td colspan=2><input type=checkbox onclick='check_status();' 
			name=deny <?php echo ($node_record->deny ? '' : 'checked'); ?> />������վ����</td>
	</tr>
	<tr>
		<td width=100><input type=checkbox onclick='check_status();' 
			name=fixedip <?php echo ($node_record->fixedip ? 'checked' : ''); ?> />ʹ�ù̶�IP</td>
		<td width=270><input type=text name=ipaddr style='width:240px;' 
					value='<?php echo str_replace("'", "''", $node_record->ipaddr); ?>'/></td>
		<td width=100>�����趨</td>
		<td width=270>
			<select name=subnet style='width:240px;'>
				<option value=''>[��ѡ��...]</option>
				<?php
				if (isset($subnet_config->subnets) && count($subnet_config->subnets) > 0) {
					foreach($subnet_config->subnets as $key => $value) {
						echo "<option value='" . str_replace("'", "''", $value->subnet) . "' ";
						if ($key == $node_record->subnet) echo 'selected';
						echo ">" . $value->subnet. "</option>\n";
					}
				}
				?>
			</select>
		</td>
	</tr>
	<tr><td colspan=4>&nbsp;</td></tr>
	<tr><td colspan=4>
		<input type=checkbox onclick='check_status();' 
			name=default_terminal <?php echo ($node_record->terminal_default ? 'checked' : ''); ?> />ʹ��Ĭ���ն�ϵͳ
	</td></tr>
	<tr>
		<td>������ʾ</td>
		<td><input type='text' name="say" style='width:240px;'
					value='<?php echo str_replace("'", "''", $node_record->say); ?>' /></td>
		<td colspan=2>&nbsp;</td>
	</tr>
	<tr>
		<td>��ʾʱ��</td>
		<td><input type='text' name="timeout" style='width:240px;'
					value='<?php echo str_replace("'", "''", $node_record->timeout); ?>' /></td>
	<td colspan=2>&nbsp;</td>
	</tr>
	<tr>
		<td>Ĭ��ϵͳ</td>
		<td width=270>
			<select name=default style='width:240px;'>
				<option value=''>[��ѡ��...]</option>
				<?php
				if (isset($label_config->terminals) && count($label_config->terminals) > 0) {
					foreach($label_config->terminals as $key => $value) {
						echo "<option value='" . str_replace("'", "''", $value->name) . "' ";
						if ($node_record->default == $key) echo 'selected';
						echo ">" . $value->name . "</option>\n";
					}
				}
				?>
			</select>
		</td>
		<td colspan=2>&nbsp;</td>
	</tr>
	<tr><td colspan=4>&nbsp;</td></tr>
	<tr><td colspan=4>
		<input type=checkbox onclick='check_status();' name=allowchoose 
			<?php echo ($node_record->allowchoose ? 'checked' : ''); ?> />����ѡ���ն˲���ϵͳ
	</td></tr>
	<tr valign=top><td colspan=4 style='padding: 0px 0px 0px 60px;'>
		<?php
		if (isset($label_config->terminals)) {
			foreach($label_config->terminals as $key => $value) {
				echo '<input type="checkbox" name="terminal_' . $key . '"';
				if (strpos(',' . $node_record->labels, ',' . $key . ',')) {
					echo ' checked';
				}
				echo ' />&nbsp;&nbsp;' . $value->name . "<br>\n";
			}
		}
		?>
	</td></tr>
	<tr><td colspan=4>&nbsp;</td></tr>
	<tr><td colspan=4>
		<input type=checkbox onclick='check_status();' name=defaultright
			<?php echo ($node_record->right_default ? 'checked' : ''); ?> />ʹ��Ĭ��Ȩ��
	</td></tr>
	<tr valign=top><td colspan=4 style='padding: 0px 0px 0px 60px;'>
		<?php
		if (isset($right_config)) {
			foreach($right_config as $key => $value) {
				echo '<input type="checkbox" name="right_' . $key . '"';
				if (strpos(',' . $node_record->rights, ',' . $key . ',')) {
					echo ' checked';
				}
				echo ' />&nbsp;&nbsp;' . $value->name . "<br>\n";
			}
		}
		?>
	</td></tr>
	<tr><td colspan=4 align=right>
  	<input type=button value="�� ��" onclick="save_node('<?php echo str_replace("'", "''", $node); ?>');" class="STD_BUTTON" />
  	&nbsp;&nbsp;&nbsp;&nbsp;
  	&nbsp;&nbsp;&nbsp;&nbsp;
  	<input type=button value="�� ��" onclick="PostBack('MAIN','');" class="STD_BUTTON" />
	</td></tr>
</table>

<script language=javascript>
check_status();
</script>
<?php
}
?>

<?php require('inc/pagetail.inc') ?>
</form>
</body>
</html>
