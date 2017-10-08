<?
class terminal {
	var $active;
	var $name;
	
	var $boottype;					// nfs, image
	var $kernel;

	// 仅当 boottype = image 时使用
	var $image;
	
	// 仅当 boottype = nfs 时使用
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
  $terminalconfig = new terminal_config;

  define('LABEL_PATH','/tftpboot/pxelinux.cfg/default');
  // 打开配置文件，载入记录
  $buffer = file_get_contents(LABEL_PATH);
  if (! $buffer) {
      return;
  }

  if (! preg_match_all('/(label\s+\d+\s+.*\n\s*kernel\s+.*\n\s*append\s+.*\n\s*IPAPPEND\s+1)'
  			.'|(#label\s+\d+\s+.*\n#\s*kernel\s+.*\n#\s*append\s+.*\n#\s*IPAPPEND\s+1)'
  			.'|(label\s+\d+\s+.*\n\s*kernel\s+.*\n\s*append\s+.*)'
  			.'|(#label\s+\d+\s+.*\n#\s*kernel\s+.*\n#\s*append\s+.*)/',
     $buffer,$match)) {
    // 没有匹配到记录，新的记录保存在文件末尾
    // echo 'no match';
    $config->prefix = $buffer;
  } else {
	  // 匹配前缀
	  $strsearch = $match[0][0];
	  $index = strpos($buffer,$strsearch);
	  if ($index) {
	    $terminalconfig->prefix = substr($buffer, 0, $index);
	  }
	  
	  // 匹配后缀
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
    	
    	// 获取配置
			$strsearch = $match[1][$i];
			if (! $strsearch) $strsearch = $match[2][$i];
			if (! $strsearch) $strsearch = $match[3][$i];
			if (! $strsearch) $strsearch = $match[4][$i];
			
			//echo '<pre>' . $strsearch . '</pre>';
			
			// 处理 active 标记
			if (substr($strsearch, 0, 1) == "#") {
				$terminal_record->active = false;
				//echo "not active<br>\n";
			} else {
				$terminal_record->active = true;
				//echo "active<br>\n";
			}

			// 获取 name
			preg_match('/label\s+\d+\s+(\S+)/',$strsearch, $submatch);
			$terminal_record->name = $submatch[1];
			//echo 'name ' . $submatch[1] . "<br>\n";
			
			// 确定kernel
			preg_match('/kernel\s+(\S+)/',$strsearch, $submatch);
			$terminal_record->kernel = $submatch[1];
			//echo 'kernel ' . $submatch[1] . "<br>\n";
			
			// 确定 nfs / image
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

print_r($terminalconfig);
?> 
