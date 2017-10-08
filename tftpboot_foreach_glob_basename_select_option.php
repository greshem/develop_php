<?
foreach (glob("/tftpboot/pxelinux.cfg/*") as $line)
{
	if(preg_match("/^..-..-..-..-..-..-..$/", basename($line)))
	{
		echo $line,"->", basename($line),"\n";
	}
}
?>
