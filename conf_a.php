<?php require_once('inc/declare.inc') ?>
<?php
session_start();
if (! isset($_SESSION['LOGIN']) || $_SESSION['LOGIN'] != 'OK') 
{
	header('Location:./index.php');
	exit;
}

// 设置常量
define('DHCPD_PATH','/etc/dhcpd.conf');
define('DHCPD_PATH_DEFAULT','./file/dhcpd.conf');

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

$errmsg = '';
$config = null;

// 检查文件
function file_check()
{
  // 检查配置文件是否存在，如果不存在复制缺省的配置文件
  if (! file_exists(DHCPD_PATH)) {
    if (! copy(DHCPD_PATH_DEFAULT,DHCPD_PATH)) {
      $errmsg = '配置文件不存在，无法复制默认配置文件';
    }
  }
}

// 载入文件
function file_load()
{
  $fileconfig = new dhcp_config;

  // 打开配置文件，载入记录
  $buffer = qlReadFileString(DHCPD_PATH);
  if (! $buffer) {
      return;
  }

  if (! preg_match_all("/subnet\s+(\S+)\s+netmask\s+(\S+)\s+\{\s*\n(([^\{]|[\n])*)\s*\}\s*/",
     $buffer,$match)) {
    // 没有匹配到记录，新的记录保存在文件末尾
    $config->prefix = $buffer;
  } else {
	  // 匹配前后缀
	  $strsearch = $match[0][0];
	  $index = strpos($buffer,$strsearch);
	  if ($index) {
	  	//echo 'first start :' . $index . '<br>';
	    $fileconfig->prefix = substr($buffer, 0, $index);
	  	//echo '<pre>' . $fileconfig->prefix . '</pre>';
	  }
	  
	  $strsearch = $match[0][count($match[0]) - 1];
	  $index = strpos($buffer,$strsearch);
	  if ($index) {
		  //echo 'last start :' . $index . '<br>';
		  if ($index + strlen($strsearch) - strlen($buffer) < 0) {
	    	$fileconfig->suffix = substr($buffer, $index + strlen($strsearch) - strlen($buffer));
	  	}
	  	//echo '<pre>' . $fileconfig->suffix . '</pre>';
	  }
		
	  for ($i = 0; $i < count($match[0]); $i++)
	  {
	  	$key = $match[1][$i];
	  	$value = new subnet_record;
	    $value->subnet = $match[1][$i];
	    $value->mask = $match[2][$i];
	
	    // 获取range
	    $buffer = $match[3][$i];
	    if (preg_match_all("/range\s+dynamic-bootp\s+(\S+)\s+(\S+)\s*;/", $buffer, $param)) {
	      for ($j = 0; $j < count($param[0]) ; $j++) {
	        $value->range[] = array(0 => $param[1][$j], 1 => $param[2][$j]);
	      }
	    }
	
	    // 获取其它配置
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

function file_write($fileconfig)
{
	$fp = fopen(DHCPD_PATH,"w");
	if (! $fp) return "打开文件失败";
	
	$buffer = $fileconfig->prefix;
	if ($fileconfig->allow_unknown) {
		$buffer = preg_replace('/deny\s+unknown-clients/', 'allow unknown-clients', $buffer);
		if (! preg_match('/allow\s+unknown-clients/',$buffer,$match)) {
			$buffer = "allow unknown-clients;\n" . $buffer;
		}
	} else {
		$buffer = preg_replace('/allow\s+unknown-clients/', 'deny unknown-clients', $buffer);
		if (! preg_match('/deny\s+unknown-clients/',$buffer,$match)) {
			$buffer = "deny unknown-clients;\n" . $buffer;
		}
	}
	
	fwrite($fp, $buffer);
	
	if ($fileconfig->subnets) {
		foreach($fileconfig->subnets as $key => $value) {
			fwrite($fp, 'subnet ' . $value->subnet . ' netmask ' . $value->mask . " {\n");

			fwrite($fp, "    default-lease-time 16000;\n");
			fwrite($fp, "    max-lease-time 32000;\n");
			
			if ($value->broadcast_address) {
				fwrite($fp, '    option broadcast-address ' . $value->broadcast_address . ";\n");
			}
			if ($value->domain_name) {
				fwrite($fp, '    option domain-name "' . $value->domain_name . "\";\n");
			}
			if ($value->routers) {
				fwrite($fp, '    option routers ' . $value->routers . ";\n");
			}
			if ($value->dns) {
				fwrite($fp, '    option domain-name-servers ' . $value->dns . ";\n");
			}
			if ($value->next_server) {
				fwrite($fp, '    next-server ' . $value->next_server . ";\n");
			}
			if ($value->filename) {
				fwrite($fp, '    filename "' . $value->filename . "\";\n");
			}

			if ($value->range) {
				foreach($value->range as $range_record) {
					fwrite($fp, '    range dynamic-bootp '
						. $range_record[0] . ' ' . $range_record[1] . ";\n");
				}
			}
			
			fwrite($fp, '    filename "pxelinux.0";' . "\n");
			fwrite($fp, "}\n");
		}
	}
	
	fwrite($fp, $fileconfig->suffix);
	fclose($fp);
	
	return '文件保存成功';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
  <title>DHCP配置</title>
  <link href="./main.css" type="text/css" rel="stylesheet" />
  <script language="javascript" src="./jslib.js"></script>
</head>
<body>

<?php
$alert = '';
$mode = 'MAIN';
$subnet = null;
$range = null;

$command = get_command();
$parameter = get_parameter();
$viewindex = 0;
$msg = '';

// 载入配置
if (get_command()) 
{
	$config = $_SESSION['DHCPD'];
	$config->allow_unknown = (get_request('station') == "on");
} else {
	file_check();
	$config = file_load();
	$_SESSION['DHCPD'] = $config;
}

if ($command == 'SAVE_FILE') 
{
	$alert = file_write($config);
} elseif 
($command == 'NEW_SUBNET' || $command == 'EDIT_SUBNET') 
{
	// 新建/编辑网段设定
	$mode = 'SUBNET';
	$subnet = $parameter;
	
	// 载入配置记录
	if ($subnet) {
		$subnet_record = $config->subnets[$subnet];
	} else {
		$subnet_record = new subnet_record;
	}
} elseif ($command == 'SAVE_SUBNET') {
	// 保存网段设定, 恢复记录
	$subnet_record = new subnet_record;
	$subnet_record->subnet = get_request("subnet");
	$subnet_record->mask = get_request("mask");
	$subnet_record->dns = get_request("dns");
	$subnet_record->broadcast_address = get_request("broadcast_address");
	$subnet_record->domain_name = get_request("domain_name");
	$subnet_record->routers = get_request("routers");
	$subnet_record->next_server = get_request("next_server");

	// 检查名称是否重复
	foreach($config->subnets as $key => $value)
	{
		if ($key == $parameter) continue;
		if ($key == $subnet_record->subnet)
		{
			$alert = '服务网段重复 !';
			break;
		}
	}
	
	if ($alert) {
		$mode = 'SUBNET';
		$subnet = $parameter;
	} else {
		// 保存，返回主列表
		if ($parameter) {
			$subnet_record->range = $config->subnets[$parameter]->range;
			if ($subnet_record->subnet != $parameter) {
				unset($config->subnets[$parameter]);
			}
		}
		$config->subnets[$subnet_record->subnet] = $subnet_record;
		
		$mode = 'MAIN';
		$subnet = '';		
	}
} elseif ($command == 'NEW_RANGE') {
	$mode = 'RANGE';
	$subnet = $parameter;
	$subnetrange = $parameter;
	$range_record = array(0 => '', 1 => '');
} elseif ($command == 'EDIT_RANGE') {
	$match = preg_split("/,/", $parameter);
	$subnet = $match[0];
	$range = $match[1];
	$subnetrange = $parameter;

	$mode = 'RANGE';
	$range_record = $config->subnets[$subnet]->range[$range];
} elseif ($command == 'SAVE_RANGE') {
	// 生成记录
	$range_record = array( 0 => get_request('start_address'), 1 => get_request('end_address'));
	
	// 分解参数
	if (strstr($parameter,',')) {
		$match = preg_split("/,/", $parameter);
		$subnet = $match[0];
		$range = $match[1];
	} else {
		$subnet = $parameter;
	}
	$subnetrange = $parameter;

	// 设置值
	if (isset($range)) {
		$config->subnets[$subnet]->range[$range] = $range_record;
	} else {
		$config->subnets[$subnet]->range[] = $range_record;
	}
	
	$mode = 'MAIN';
} elseif ($command == 'DELETE_SUBNET') {
	unset($config->subnets[$parameter]);
} elseif ($command == 'DELETE_RANGE') {
	$match = preg_split("/,/", $parameter);
	$subnet = $match[0];
	unset($config->subnets[$subnet]->range[$match[1]]);
} elseif ($command == 'VIEW_SUBNET') {
	$subnet = $parameter;
}

$_SESSION['DHCPD'] = $config;
?>

<form name="form1" method="post" action="conf_a.php">
<?php require('inc/pagehead.inc') ?>

<script language=javascript>
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
<table cellpadding=0 cellspacing=0 border=0 width=600>
	<tr valign=bottom>
		<td><h2>DHCP配置</h2></td>
		<td align=right>
			<input type="checkbox" name="station" <?php echo ( $config->allow_unknown ? 'checked' : '') ; ?> /> 允许工作站自动加入
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type=button value="保 存" onclick="PostBack('SAVE_FILE','');" class="STD_BUTTON">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type=button value="重启服务" onclick="RestartDHCP();" class="STD_BUTTON">
		</td>
	</tr>
</table>

<?php
if ($mode == 'RANGE') {
	// 显示编辑记录
?>

<script language=javascript>
function save_range(subnet)
{
	if (document.all["start_address"].value == "") {
		alert("请输入起始地址");
		return;
	}
	if (document.all["end_address"].value == "") {
		alert("请输入结束地址");
		return;
	}
	PostBack('SAVE_RANGE',subnet);
}
</script>

<table cellspacing=1 cellpadding=0 border=0>
	<tr><td colspan=2><b>地址池设定 - <?php echo ($range ? '修改' : '新建' ); ?><b></td></tr>
  <tr>
  	<td width=100>起始地址</td>
  	<td width=270><input type='text' name='start_address' value='<?php echo str_replace("'", "''", $range_record[0]); ?>' style='width:240px'></td>
  </tr>
  <tr>
  	<td width=100>结束地址</td>
  	<td width=270><input type='text' name='end_address' value='<?php echo str_replace("'", "''", $range_record[1]); ?>' style='width:240px'></td>
  </tr>
  <tr><td colspan=2 align=right>
  	<input type=button value="保 存" onclick="save_range('<?php echo str_replace("'", "''", $subnetrange); ?>');" class="STD_BUTTON" />
  	&nbsp;&nbsp;&nbsp;&nbsp;
  	&nbsp;&nbsp;&nbsp;&nbsp;
  	<input type=button value="返 回" onclick="PostBack('VIEW_SUBNET','<?php echo str_replace("'", "''", $subnet); ?>');" class="STD_BUTTON" />
  </td><tr>
</table>

<?php
} else if ($mode == 'SUBNET') {
// 新建/编辑地址池
?>
<script language=javascript>
function save_subnet(subnet)
{
	if (document.all["subnet"].value == "") {
		alert("请输入服务网段");
		return;
	}
	if (document.all["mask"].value == "") {
		alert("请输入子网掩码");
		return;
	}
	if (document.all["routers"].value == "") {
		alert("请输入客户端网关地址");
		return;
	}
	if (document.all["next_server"].value == "") {
		alert("请输入启动服务器");
		return;
	}
	PostBack('SAVE_SUBNET',subnet);
}
</script>

<table cellspacing=1 cellpadding=0 border=0>
	<tr><td colspan=4><b>网段设定 - <?php echo ($subnet ? '修改' : '新建' ); ?><b></td></tr>
  <tr>
  	<td width=100>服务网段</td>
  	<td width=270><input type='text' name='subnet' value='<?php echo str_replace("'", "''", $subnet_record->subnet); ?>' style='width:240px'></td>
  	<td width=100>DNS 地址</td>
  	<td width=270><input type='text' name='dns' value='<?php echo str_replace("'", "''", $subnet_record->dns); ?>' style='width:240px'></td>
  </tr>
  <tr>
  	<td width=100>子网掩码</td>
  	<td width=270><input type='text' name='mask' value='<?php echo str_replace("'", "''", $subnet_record->mask); ?>' style='width:240px'></td>
  	<td width=100>域 名</td>
  	<td width=270><input type='text' name='domain_name' value='<?php echo str_replace("'", "''", $subnet_record->domain_name); ?>' style='width:240px'></td>
  </tr>
  <tr>
  	<td width=100>客户端网关地址</td>
  	<td width=270><input type='text' name='routers' value='<?php echo str_replace("'", "''", $subnet_record->routers); ?>' style='width:240px'></td>
  	<td width=100>广播地址</td>
  	<td width=270><input type='text' name='broadcast_address' value='<?php echo str_replace("'", "''", $subnet_record->broadcast_address); ?>' style='width:240px'></td>
  </tr>
  <tr>
  	<td width=100>启动服务器</td>
  	<td width=270><input type='text' name='next_server' value='<?php echo str_replace("'", "''", $subnet_record->next_server); ?>' style='width:240px'></td>
  	<td width=100>&nbsp;</td>
  	<td width=270>&nbsp;</td>
  </tr>
  <tr><td colspan=4 align=right>
  	<input type=button value="保 存" onclick="save_subnet('<?php echo str_replace("'", "''", $subnet); ?>');" class="STD_BUTTON" />
  	&nbsp;&nbsp;&nbsp;&nbsp;
  	&nbsp;&nbsp;&nbsp;&nbsp;
  	<input type=button value="返 回" onclick="PostBack('VIEW_SUBNET','');" class="STD_BUTTON" />
  </td><tr>
</table>

<?php
} else {
// 显示主列表记录
?>

<script language=javascript>
function delete_subnet(subnet)
{
	if (! confirm("确定要删除记录吗 ?")) return;
	PostBack('DELETE_SUBNET',subnet);
}

function delete_range(subnetrange)
{
	if (! confirm("确定要删除记录吗 ?")) return;
	PostBack('DELETE_RANGE',subnetrange);
}
</script>

<table cellspacing=0 cellpadding=0 border=0>
	<tr valign=top><td width=300>
		<table cellspacing=2 cellpadding=0 border=0 width=310>
			<tr><td colspan=2>
				<?php
				  // 生成 subnet 列表
					if (isset($config->subnets) && count($config->subnets) > 0) {
						echo "<table cellpadding=0 cellspacing=0 style='font-size:10pt;' border=1>\n";
						echo "<tr bgcolor=gray><td align=center colspan=4 color=white>服务网段</td></tr>\n";
						foreach ($config->subnets as $key => $value)
						{
							if ($subnet == $key) {
								echo "<tr bgcolor=silver><td width=150>" . $value->subnet . "</td>";
							} else {
								echo "<tr><td width=150>" . $value->subnet . "</td>";
							}
							echo "<td width=40 align=center><a href='javascript:PostBack(\"EDIT_SUBNET\",\"" 
								. $key . "\");'>编辑</a></td>";
							echo "<td width=40 align=center><a href='javascript:delete_subnet(\"" 
								. $key . "\");'>删除</a></td>";
							echo "<td width=60 align=center><a href='javascript:PostBack(\"VIEW_SUBNET\",\"" 
								. $key . "\");'>地址池</a></td>";
							echo "</tr>\n";
						}
						echo "</table>";
						$msg = '共 ' . count($config->subnets) . ' 数据记录';
					} else {
						$msg = '没有数据记录';
					}
				?>
			</td><tr>
			<tr><td>
				<?php echo $msg; ?>
			</td><td align=right>
				<input type=button value='新 建' onclick='PostBack("NEW_SUBNET","")' class="STD_BUTTON">
			</td><tr>
		</table>
  </td><td style='padding: 0px 0px 0px 20px;'>
  	<?php
  	// 生成 range 列表
  	if ($subnet) {
  		echo "<table cellspacing=2 cellpadding=0 border=0 width=320>\n";
  		echo "<tr><td colspan=2>\n";
  		
		  // 生成 range 列表
			if (isset($config->subnets[$subnet]->range) && count($config->subnets[$subnet]->range) > 0) {
				echo "<table cellpadding=0 cellspacing=0 style='font-size:10pt;' border=1>\n";
				echo "<tr bgcolor=silver align=center><td width=120>起始地址</td>"
					. "<td width=120>结束地址</td>\n"
					. "<td colspan=2>&nbsp;</td></tr>\n";
					
				foreach ($config->subnets[$subnet]->range as $key => $value)
				{
					echo "<tr><td>" . $value[0] . "</td>";
					echo "<td>" . $value[1] . "</td>";
					echo "<td width=40 align=center><a href='javascript:PostBack(\"EDIT_RANGE\",\"" 
						. $subnet . "," . $key
						. "\");'>编辑</a></td>";
					echo "<td width=40 align=center><a href='javascript:delete_range(\"" 
						. $subnet . "," . $key
						. "\");'>删除</a></td>";
					echo "</tr>\n";
				}
				echo "</table>";
				$msg = '共 ' . count($config->subnets[$subnet]->range) . ' 数据记录';
			} else {
				$msg = '没有数据记录';
			}
  		
  		echo "</td><tr>\n";
  		echo "<tr><td>" . $msg . "</td>\n";
  		echo "<td align=right><input type=button value='新 建' onclick='PostBack(\"NEW_RANGE\",\""
  			. $subnet . "\")' class=\"STD_BUTTON\"></td><tr>\n";
  		echo "</table>";
  	}
  	?>
  </td></tr>
</table>

<?php
}
?>

<?php require('inc/pagetail.inc') ?>

</form>
</body>
</html>
