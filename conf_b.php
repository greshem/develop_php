<?php require_once('inc/declare.inc') ?>
<?php
session_start();
if (! isset($_SESSION['LOGIN']) || $_SESSION['LOGIN'] != 'OK') {
	header('Location:./index.php');
	exit;
}

// ���ó���
define('DHCPD_PATH','/etc/dhcpd.conf');						// dhcpd.conf �ļ�·��
define('LABEL_PATH','/tftpboot/pxelinux.cfg/default');
define('LABEL_MENU_PATH','./target/menu.conf');
define('LABEL_PATH_DEFAULT','./file/default.conf');

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

class terminal_config {
  var $prefix;
  var $suffix;
  
  var $say;
  var $timeout;
  var $default;
  var $allowchoose;
  
  var $terminals;
}

$config = null;					// terminal ����

// ����ļ�
function file_check()
{
  // ��������ļ��Ƿ���ڣ���������ڸ���ȱʡ�������ļ�
  if (! file_exists(LABEL_PATH)) {
    if (! copy(LABEL_PATH_DEFAULT,LABEL_PATH)) {
      $errmsg = '�����ļ������ڣ��޷�����Ĭ�������ļ�';
    }
  }
}

function file_load()
{
  $terminalconfig = new terminal_config;

  // �������ļ��������¼
  $buffer = qlReadFileString(LABEL_PATH);
  if (! $buffer) {
      return;
  }

  if (! preg_match_all('/(label\s+\d+\s+.*\n\s*kernel\s+.*\n\s*append\s+.*\n\s*IPAPPEND\s+1)'
  			.'|(#label\s+\d+\s+.*\n#\s*kernel\s+.*\n#\s*append\s+.*\n#\s*IPAPPEND\s+1)'
  			.'|(label\s+\d+\s+.*\n\s*kernel\s+.*\n\s*append\s+.*)'
  			.'|(#label\s+\d+\s+.*\n#\s*kernel\s+.*\n#\s*append\s+.*)/',
     $buffer,$match)) {
    // û��ƥ�䵽��¼���µļ�¼�������ļ�ĩβ
    // echo 'no match';
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
	  	if ($index + strlen($strsearch) - strlen($buffer) < 0) {
	    	$terminalconfig->suffix = substr($buffer, $index + strlen($strsearch) - strlen($buffer));
	    }
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

function file_write($terminalconfig)
{
	$localhost = 'localhost';
	$dhcpconfig = load_dhcp_subnet();
	if (isset($dhcpconfig->subnets) && count($dhcpconfig->subnets) > 0) {
		foreach($dhcpconfig->subnets as $key => $value) {
			$localhost = $value->next_server;
			break;
		}
	}

	$fp = fopen(LABEL_PATH,"w");
	if (! $fp) return "���ļ�ʧ��";
	
	$buffer = $terminalconfig->prefix;
	
	if ($terminalconfig->allowchoose) {
		$buffer = preg_replace('/#display\s+\S+/', 'display pxelinux.cfg/list', $buffer);
		if (! preg_match('/display\s+\S+/', $buffer, $match)) {
			$buffer = "display pxelinux.cfg/list\n" . $buffer;
		}
		$buffer = preg_replace('/prompt\s+\d+/', 'prompt 1', $buffer);
		if (! preg_match('/prompt\s+\d+/', $buffer, $match)) {
			$buffer = "prompt 1\n" . $buffer;
		}
		
		// ���� menu �ļ�
		$menufp = fopen(LABEL_MENU_PATH,"w");
		fwrite($menufp, "Choose one of the following Linux Image\n");
		fwrite($menufp, "------------------------------------------------------------\n");
		if ($terminalconfig->terminals && count($terminalconfig->terminals) > 0) {
			$index = 1;
			foreach($terminalconfig->terminals as $key => $value) {
				fwrite($menufp, $index . ') ' . $key . "\n");
				$index++;
			}
		}
		fwrite($menufp, "------------------------------------------------------------\n");
		fclose($menufp);
	} else {
		$buffer = preg_replace('/prompt\s+\d+/', 'prompt 0', $buffer);
		if (! preg_match('/prompt\s+\d+/', $buffer, $match)) {
			$buffer = "prompt 0\n" . $buffer;
		}
		if (! preg_match('/#display\s+\S+/', $buffer, $match)) {
			$buffer = preg_replace('/display\s+\S+/', '#display pxelinux.cfg/list', $buffer);
		}
	}

	// ���� timeout
	$buffer = preg_replace('/timeout\s+.*\n/', 'timeout ' . $terminalconfig->timeout . "\n", $buffer);
	if (! preg_match('/timeout\s+.*\n/', $buffer, $match)) {
		$buffer = 'timeout ' . $terminalconfig->timeout . "\n" . $buffer;
	}
	
	// ���� say
	$buffer = preg_replace('/say\s+.*\n/', 'say ' . $terminalconfig->say . "\n", $buffer);
	if (! preg_match('/say\s+.*\n/', $buffer, $match)) {
		$buffer = 'say ' . $terminalconfig->say . "\n" . $buffer;
	}
	
	// ���� default
	if ($terminalconfig->terminals && count($terminalconfig->terminals) > 0) {
		$index = 1;
		foreach($terminalconfig->terminals as $key => $value) {
			if ($key == $terminalconfig->default) {
				$buffer = preg_replace('/default\s+\S+/', 'default ' . $index, $buffer);
				if (! preg_match('/default\s+(\S+)/',$buffer,$match)) {
					$buffer = 'default ' + $index . "\n" . $buffer;
				}
				break;
			}
			$index++;
		}
	}
	
	fwrite($fp, $buffer);
	
	if ($terminalconfig->terminals) {
		$index = 1;
		foreach($terminalconfig->terminals as $key => $value) {
			$tag = $value->active ? '' : '#';

			fwrite($fp, $tag . 'label ' . $index . ' ' . $value->name . "\n");
			fwrite($fp, $tag . '  kernel ' . $value->kernel . "\n");

			$line = '';
			switch($value->boottype) {
				case 'NFS':
				  $line = '  append root=/dev/nfs nfsroot=' . $localhost . ':/' . $value->nfs
				  		. ' ip=dhcp init=/bin/sh';
					break;
				case 'IMAGE':
				  $line = '  append initrd=' . $value->image 
				  		. ' ramdisk_size=' . $value->ram
				  		. ' root=/dev/ram0 init=/bin/sh';
					break;
			}
			switch($value->displaymode) {
				case "VESA":
					$line = $line . ' vga=0x301';
					break;
				case "INTELFB":
					$line = $line . ' video=intelfb:mode=640x480-4';
					break;
			}
			if ($value->debug) {
				$line = $line . ' debug';
			}
			fwrite($fp, $tag . $line . "\n");

			
			if ($value->boottype == 'IMAGE') {
				fwrite($fp, $tag . "  IPAPPEND 1\n");
			}
			$index++;
		}
	}
	
	fwrite($fp, $terminalconfig->suffix);
	fclose($fp);
	
	return '�ļ�����ɹ�';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
  <title>��������</title>
  <link href="./main.css" type="text/css" rel="stylesheet" />
  <script language="javascript" src="./jslib.js"></script>
</head>
<body>

<?php
$alert = '';
$mode = 'MAIN';
$terminal = null;
$loadmainparam = true;

$command = get_command();
$parameter = get_parameter();
$viewindex = 0;


// ��������
if (get_command()) {
  $config = $_SESSION['TERMINAL'];
} else {
  file_check();
  $config = file_load();
  $_SESSION['TERMINAL'] = $config;
}

if ($command == 'SAVE_FILE' || $command == 'DISABLE_LABEL'
		|| $command == 'ENABLE_LABEL' || $command == 'DELETE_LABEL'
		|| $command == 'NEW_LABEL' || $command == 'EDIT_LABEL') {
 	$config->say = get_request('say');
 	$config->timeout = get_request('timeout');
 	$config->default = get_request('default');
 	$config->allowchoose = (get_request('allowchoose') == "on");
}

// ����ָ��
if ($command == 'SAVE_FILE') {
	$alert = file_write($config);
} elseif ($command == 'NEW_LABEL' || $command == 'EDIT_LABEL') {
	// �½�/�༭�����趨
	$mode = 'LABEL';
	$terminal = $parameter;
	
	// �������ü�¼
	if ($terminal) {
		$terminal_record = $config->terminals[$parameter];
	} else {
		$terminal_record = new terminal;
	}
} elseif ($command == 'SAVE_LABEL') {
	// �����趨
	$terminal = $parameter;
	$terminal_record = new terminal;
	$terminal_record->name = get_request("name");
	$terminal_record->debug = get_request("debug") == 'on';
	$terminal_record->kernel = get_request("kernel");
	$terminal_record->boottype = get_request("boottype");
	if ($terminal_record->boottype == 'NFS') {
		$terminal_record->nfs = get_request("nfs");
	} elseif ($terminal_record->boottype == 'IMAGE') {
		$terminal_record->image = get_request("image");
		$terminal_record->ram = get_request("ram");
	}
	$terminal_record->displaymode = get_request("displaymode");
	
	if ($terminal) {
		$terminal_record->active = $config->terminals[$terminal]->active;
	} else {
		$terminal_record->active = true;
	}

	// ��������Ƿ��ظ�
	if ($config->terminals && count($config->terminals) > 0) {
		foreach($config->terminals as $key => $value) {
			if ($key == $terminal) continue;
			if ($key == $terminal_record->name) {
				$alert = '�����ظ�';
				break;
			}
		}
	}

	if ($alert) {
		$mode = 'LABEL';
		$terminal = $parameter;
	} else {
		// ���棬�������б�
		if ($terminal) {
			if ($terminal_record->name != $terminal) {
				unset($config->terminals[$parameter]);
				if ($config->default == $terminal) {
					$config->default = $terminal_record->name;
				}
			}
		}
		$config->terminals[$terminal_record->name] = $terminal_record;
		
		$mode = 'MAIN';
		$terminal = '';	
	}
} elseif ($command == 'DISABLE_LABEL') {
	$config->terminals[$parameter]->active = false;
} elseif ($command == 'ENABLE_LABEL') {
	$config->terminals[$parameter]->active = true;
} elseif ($command == 'DELETE_LABEL') {
	unset($config->terminals[$parameter]);
}

$_SESSION['TERMINAL'] = $config;
?>

<form name="form1" method="post" action="conf_b.php">
<?php require('inc/pagehead.inc') ?>

<h2>��������</h2>

<?php
if ($mode == 'LABEL') {
	// ��ʾ��¼
?>

<script language=javascript>
function check_boottype()
{
	document.all["image"].disabled = document.all["boottype"].value == 'NFS';
	document.all["ram"].disabled = document.all["boottype"].value == 'NFS';
	document.all["nfs"].disabled = document.all["boottype"].value == 'IMAGE';
}

function save_label(label)
{
	if (document.all["name"].value == "") {
		alert("������ϵͳ����");
		return;
	}
	if (document.all["boottype"].value == "") {
		alert("��������������");
		return;
	}
	if (document.all["kernel"].value == "") {
		alert("��ѡ��Linux�ں�");
		return;
	}
	if (! document.all["nfs"].disabled) {
		if (document.all["nfs"].value == "") {
			alert("������NFS����λ��");
			return;
		}
	}
	if (! document.all["image"].disabled) {
		if (document.all["image"].value == "") {
			alert("��ѡ��Linux����");
			return;
		}
	}
	if (! document.all["ram"].disabled) {
		if (document.all["ram"].value == "") {
			alert("�������ڴ�������");
			return;
		}
	}
	if (document.all["displaymode"].value == "") {
		alert("��ѡ����ʾģʽ");
		return;
	}
	
	PostBack('SAVE_LABEL',label);
}
</script>

<table cellspacing=1 cellpadding=0 border=0>
	<tr><td colspan=4><b>�����趨 - <?php echo ($terminal ? '�޸�' : '�½�' ); ?><b></td></tr>
  <tr>
  	<td width=100>ϵͳ����</td>
  	<td width=270><input type='text' name='name' value='<?php echo str_replace("'", "''", $terminal_record->name); ?>' style='width:240px'></td>
  	<td colspan=2><input type='checkbox' name='debug' <?php echo ($terminal_record->debug ? 'checked' : '')?> />�ն˵���ģʽ</td>
  </tr>
  <tr>
  	<td width=100>��������</td>
  	<td width=270>
  		<select name='boottype' onclick='javascript:check_boottype();' style='width:240px'>
  			<option value='NFS' <?php echo ( $terminal_record->boottype == 'NFS' ? 'selected' : '') ?>>NFS</option>
  			<option value='IMAGE' <?php echo ( $terminal_record->boottype == 'IMAGE' ? 'selected' : '') ?>>����</option>
  		</select>
  	</td>
  	<td width=100>Linux�ں�</td>
  	<td width=270>
  		<select name='kernel' style='width:240px'>
  			<option value='temp_kernel' <?php echo ( $terminal_record->kernel == 'temp_kernel' ? 'selected' : '') ?>>Ĭ���ں�</option>
  		</select>
  	</td>
  </tr>
  <tr>
  	<td width=100>NFS����λ��</td>
  	<td width=270><input type='text' name='nfs' value='<?php echo str_replace("'", "''", $terminal_record->nfs); ?>' style='width:240px'></td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  <tr>
  	<td width=100>Linux����</td>
  	<td width=270>
  		<select name='image' style='width:240px'>
  			<option value='nx_nodisk' <?php echo ( $terminal_record->image == 'nx_nodisk' ? 'selected' : '') ?>>nx_nodisk</option>
  		</select>
  	</td>
  	<td width=100>�ڴ�������</td>
  	<td width=270><input type='text' name='ram' value='<?php echo str_replace("'", "''", $terminal_record->ram); ?>' style='width:240px'></td>
  </tr>
  <tr>
  	<td width=100>��ʾģʽ</td>
  	<td width=270>
  		<select name='displaymode' style='width:240px'>
  			<option value='VESA' <?php echo ( $terminal_record->displaymode == 'VESA' ? 'selected' : '') ?>>Vesa</option>
  			<option value='INTELFB' <?php echo ( $terminal_record->displaymode == 'INTELFB' ? 'selected' : '') ?>>Intelfb</option>
  		</select>
  	</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr><td colspan=4 align=right>
  	<input type=button value="�� ��" onclick="save_label('<?php echo str_replace("'", "''", $terminal); ?>');" class="STD_BUTTON" />
  	&nbsp;&nbsp;&nbsp;&nbsp;
  	&nbsp;&nbsp;&nbsp;&nbsp;
  	<input type=button value="�� ��" onclick="PostBack('MAIN','');" class="STD_BUTTON" />
  </td><tr>
</table>

<script language=javascript>
check_boottype();
</script>

<?php
} else {
	// ��ʾ��¼�б�
?>

<script language=javascript>
function delete_label(label)
{
	if (! confirm("ȷ��Ҫɾ����¼�� ?")) return;
	PostBack('DELETE_LABEL',label);
}
</script>

<table cellpadding=1 cellspacing=1 border=0 width=480>
	<tr><td colspan=2>
		<table cellspacing=0 cellpadding=0 border=0>
			<tr>
				<td width=80>������ʾ</td>
				<td><input type='text' name="say" style='width:180px;'
							value='<?php echo str_replace("'", "''", $config->say); ?>' /></td>
			</tr>
			<tr>
				<td width=80>��ʾʱ��</td>
				<td><input type='text' name="timeout" style='width:180px;'
							value='<?php echo str_replace("'", "''", $config->timeout); ?>' /></td>
			</tr>
			<tr>
				<td width=80>Ĭ��ϵͳ</td>
				<td>
					<select name="default" style='width:180px;'>
						<?php
							if ($config->terminals && count($config->terminals) > 0) {
								foreach($config->terminals as $key => $value)
								{
										echo '<option' . ($key == $config->default ? ' selected' : '') . '>' . $key .'</option>';
								}
							}
						?>
					</select>
				</td>
			</tr>
			<tr><td colspan=2 style='padding: 0px 0px 0px 40px;'>
				<input type='checkbox' name='allowchoose' <?php echo ($config->allowchoose ? 'checked' : '')?> /> ����ѡ���ն˲���ϵͳ
			</td></tr>
		</table>
	</td></tr>
	<tr><td colspan=2>
			<table cellpadding=1 cellspacing=1 border = 0 bgcolor=silver>
				<tr>
					<td align=center bgcolor=white width=150>����</td>
					<td align=center bgcolor=white width=80>��������</td>
					<td align=center bgcolor=white width=60>״̬</td>
					<td colspan=3 bgcolor=white>&nbsp;</td>
				</tr>
				<?php
					if ($config->terminals && count($config->terminals) > 0) {
						foreach($config->terminals as $key => $value) {
							echo '<tr><td align=center bgcolor=white>' . $value->name . '</td>';
							echo '<td align=center bgcolor=white>' . $value->boottype . '</td>';
							echo '<td align=center bgcolor=white>' . ($value->active ? '����' : '����') . '</td>';
							
							echo "<td width=40 align=center bgcolor=white><a href='javascript:PostBack(\"EDIT_LABEL\",\"" 
								. $key . "\");'>�༭</a></td>";
							echo "<td width=40 align=center bgcolor=white><a href='javascript:delete_label(\"" 
								. $key . "\");'>ɾ��</a></td>";
							if ($value->active) {
								echo "<td width=40 align=center bgcolor=white><a href='javascript:PostBack(\"DISABLE_LABEL\",\"" 
									. $key . "\");'>����</a></td>";
							} else {
								echo "<td width=40 align=center bgcolor=white><a href='javascript:PostBack(\"ENABLE_LABEL\",\"" 
									. $key . "\");'>����</a></td>";
							}
							echo "</tr>\n";
							$msg = '�� ' . count($config->terminals) . ' ���ݼ�¼';
						}
					} else {
						$msg = 'û�����ݼ�¼';
					}
				?>
			</table>
	</td></tr>
	<tr><td>
		<?php echo $msg; ?>
	</td><td align=right>
		<input type=button value='�� ��' onclick='PostBack("NEW_LABEL","")' class="STD_BUTTON">
		&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type=button value='�����ļ�' onclick='PostBack("SAVE_FILE","")' class="STD_BUTTON">
	</td><tr>
</table>

<?php
}
?>

<?php require('inc/pagetail.inc') ?>
</form>
</body>
</html>
