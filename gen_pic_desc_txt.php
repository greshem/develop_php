#!/usr/bin/php
<?php
	foreach (glob("*.jpg") as $file)
	{
		$txt=preg_replace("/(.*)\.jpg/", "\$1.txt", $file);
		$content= preg_replace("/(.*)\.jpg/", "\$1 desc.ETC...\n", $file);

		#echo $txt."\
		file_put_contents($txt, $content);
	}
?>
