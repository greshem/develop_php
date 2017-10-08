<?php 

require_once("File_Find.php");
function get_qemu_image()
{
	$find = new File_Find();
	$file=File_Find::search("img$", "/var/lib/libvirt/images/");
	$ret=array();

	foreach ($file as $filename)
	{
		$base_name=basename($filename);
		#$name=preg_replace("/\.img$/i", "", $base_name);
		
		$ret{$base_name}=$filename;
	}
	return $ret;
}

if($argv[0]=="qemu_manager.php")
{
	print_r(get_qemu_image());
}

#$action="list";
$action="create";

if($acstion=="list")
{
	foreach (get_qemu_image() as $name=>$path)
	{
		echo "$name -> $path \n";
	}
}
else if ($action=="create")
{
	foreach (get_qemu_image() as $name=>$path)
	{
		print " qemu-kvm -hda $path   -m 512  -localtime    -snapshot   -usb -usbdevice tablet  -net nic,macaddr=DC:0E:83:E2:2D:81  -net tap   -vnc 0.0.0.0:0 \n";
	}
}


 ?>
