<?php require_once('inc/declare.inc') ?>
<?php
session_start();
if (! isset($_SESSION['LOGIN']) || $_SESSION['LOGIN'] != 'OK') {
	header('Location:./index.php');
	exit;
}

define('ETH_PATH','./target/');

class net_record {
	var $id;
	
	var $device;
	var $onboot;
	
	var $bootproto;
	
	var $ipaddr;
	var $netmask;
	var $gateway;
}

$errmsg = '';
$config = null;

function file_load()
{
	$netconfig = null;
	$index = 0;
	
	
	while (true) {
		$filename = ETH_PATH . 'ifcfg-eth' . $index;
		//echo $filename . '<br>';
		if (! file_exists($filename)) break;

	  $buffer = qlReadFileString($filename);
  	if (! $buffer) break;
  	
  	$net_record = new net_record;
  	$net_record->id = $index;
  	
  	preg_match("/DEVICE=(\S+)/", $buffer, $param);
  	$net_record->device = $param[1];
  	preg_match("/ONBOOT=(\S+)/", $buffer, $param);
  	$net_record->onboot = $param[1];
  	preg_match("/BOOTPROTO=(\S+)/", $buffer, $param);
  	$net_record->bootproto = $param[1];
  	
  	if (preg_match("/IPADDR=(\S+)/", $buffer, $param)) {
			$net_record->ipaddr = $param[1];
  	}
  	if (preg_match("/NETMASK=(\S+)/", $buffer, $param)) {
			$net_record->netmask = $param[1];
  	}
  	if (preg_match("/GATEWAY=(\S+)/", $buffer, $param)) {
			$net_record->gateway = $param[1];
  	}
  	
  	$netconfig[$index] = $net_record;
  	$index++;
	}
	
	return $netconfig;
}

function file_write($netconfig)
{
	if (isset($netconfig) && count($netconfig) > 0) {
		foreach($netconfig as $key => $value) {
			$filename = ETH_PATH . 'ifcfg-eth' . $key;
			$fp = fopen($filename,"w");
			if (! $fp) return "���ļ�" . $filename . "ʧ��";
			
			// д���ļ�
			fwrite($fp, "DEVICE=" . $value->device . "\n");
			fwrite($fp, "ONBOOT=" . $value->onboot . "\n");
			fwrite($fp, "BOOTPROTO=" . $value->bootproto . "\n");
			fwrite($fp, "IPADDR=" . $value->ipaddr . "\n");
			fwrite($fp, "NETMASK=" . $value->netmask . "\n");
			fwrite($fp, "GATEWAY=" . $value->gateway . "\n");
			
			fclose($fp);
			$fp = null;
		}
	}
	
	return '����ɹ�';
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
$net_record = null;

$command = get_command();
$parameter = get_parameter();

if (get_command()) {
  $config = $_SESSION['ETH'];
} else {
  $config = file_load();
  $_SESSION['ETH'] = $config;
}

if ($command == 'RETURN') {
	// DO NOTHING
} else if ($command == 'EDIT_NET') {
	$mode = 'EDIT';
	$net_record = $config[$parameter];
} else if ($command == 'SAVE_NET') {
	$net_record = $config[$parameter];

	$net_record->onboot = get_request('onboot') == "on" ? 'yes' : 'no';
	$net_record->bootproto = get_request("bootproto");
	$net_record->ipaddr = get_request("ipaddr");
	$net_record->netmask = get_request("netmask");
	$net_record->gateway = get_request("gateway");

	$config[$parameter] = $net_record;
} else if ($command == 'SAVE') {
	$alert = file_write($config);
}

$_SESSION['ETH'] = $config;
?>

<form name="form1" method="post" action="conf_d.php">
<script language=javascript>
function save_net(id)
{
	PostBack('SAVE_NET',id);
}
</script>
<?php require('inc/pagehead.inc') ?>

<table cellpadding=0 cellspacing=0 border=0 width=600>
	<tr valign=bottom>
		<td><h2>�����趨</h2></td>
		<td align=right>
			<input type=button value="�� ��" onclick="PostBack('SAVE','');" <?php if ($mode =='EDIT') echo 'disabled=true' ?> class="STD_BUTTON">
		</td>
	</tr>
</table>

<table cellpadding=0 cellspacing=0 border=0>
	<tr valign=top><td width=200>
		<table cellpadding=1 cellspacing=1 bgcolor=silver width=140>
			<tr>
				<td bgcolor=white colspan=2 align=center>�豸</td>
			</tr>
		<?php
		if (isset($config) && count($config) > 0)
		{
			foreach($config as $key => $value)
			{
				if ($mode == 'EDIT' && $parameter == $key) {
					echo '<tr>';
					echo '<td bgcolor=#E0E0E0 align=center width=90>' . $value->device. '</td>';
					echo "<td bgcolor=#E0E0E0 align=center><a href='javascript:PostBack(\"EDIT_NET\",\"" . $key . "\")'>�༭</a></td>";
					echo "</tr>\n";
				} else {
					echo '<tr>';
					echo '<td bgcolor=white align=center width=90>' . $value->device. '</td>';
					echo "<td bgcolor=white align=center><a href='javascript:PostBack(\"EDIT_NET\",\"" . $key . "\")'>�༭</a></td>";
					echo "</tr>\n";
				}
			}
		}
		?>
		</table>
	</td><td>
		<?php
		if ($mode == 'EDIT') {
		?>
		<table cellspacing=1 cellpadding=0 border=0>
			<tr><td colspan=2><input type='checkbox' name='onboot' <?php echo ($net_record->onboot == 'yes' ? 'checked' : '')?> /> ����ʱ�����豸</td></tr>
		  <tr>
		  	<td width=100>����Э��</td>
		  	<td width=270>
		  		<select name='bootproto' style='width:240px'>
		  			<option value='none' <?php echo ( $net_record->bootproto == 'none' ? 'selected' : '') ?>>����ʱ��ʹ��Э��</option>
		  			<option value='static' <?php echo ( $net_record->bootproto == 'static' ? 'selected' : '') ?>>��̬�����ַ</option>
		  			<option value='bootp' <?php echo ( $net_record->bootproto == 'bootp' ? 'selected' : '') ?>>ʹ��BOOTPЭ��</option>
		  			<option value='dhcp' <?php echo ( $net_record->bootproto == 'dhcp' ? 'selected' : '') ?>>ʹ��DHCPЭ��</option>
		  		</select>
		  	</td>
		  </tr>
		  <tr>
		  	<td width=100>������ַ</td>
		  	<td width=270><input type='text' name='ipaddr' value='<?php echo str_replace("'", "''", $net_record->ipaddr); ?>' style='width:240px'></td>
		  <tr>
		  <tr>
		  	<td width=100>��������</td>
		  	<td width=270><input type='text' name='netmask' value='<?php echo str_replace("'", "''", $net_record->netmask); ?>' style='width:240px'></td>
		  <tr>
		  <tr>
		  	<td width=100>���ص�ַ</td>
		  	<td width=270><input type='text' name='gateway' value='<?php echo str_replace("'", "''", $net_record->gateway); ?>' style='width:240px'></td>
		  <tr>
	  	<tr><td colspan=2 align=right>
		  	<input type=button value="�� ��" onclick="save_net('<?php echo $parameter; ?>');" class="STD_BUTTON" />
		  	&nbsp;&nbsp;&nbsp;&nbsp;
		  	&nbsp;&nbsp;&nbsp;&nbsp;
		  	<input type=button value="�� ��" onclick="PostBack('RETURN','');" class="STD_BUTTON" />
	  	</td></tr>
		</table>
		<?php
		}
		?>
	</td></tr>
</table>

<?php require('inc/pagetail.inc') ?>

</form>
</body>
</html>
