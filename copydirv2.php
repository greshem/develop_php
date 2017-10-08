<?php 
function copyDir($source, $destination)
{
    $result = true;

    if(! is_dir($source))
    {
        trigger_error('Invalid Parameter', E_USER_ERROR);
    }
    if(! is_dir($destination))
    {
        if(! mkdir($destination, 0700))
        {
            trigger_error('Invalid Parameter', E_USER_ERROR);
        }
    }

    $handle = opendir($source);
    while(($file = readdir($handle)) !== false)
    {
        if($file != '.' && $file != '..')
        {
            $src = $source . DIRECTORY_SEPARATOR . $file;
            $dtn = $destination . DIRECTORY_SEPARATOR . $file;
            if(is_dir($src))
            {
                copyDir($src, $dtn);
            }
            else
            {
                if(! copy($src, $dtn))
                {
                    $result = false;
                    break;
                }
            }
        }
    }
    closedir($handle);

    return $result;
}
function get_array_dir($dir)
{
	$dir=opendir($dir);
	$pic=array();
	while(false!=($file =readdir($dir)))      
	{
	#	print $file."\n";
		if(is_dir($file))
		{
		array_push($pic, $file);
		}
	}

	sort($pic);

	return $pic;
}
$tmp=get_array_dir(".");
$jpn_dir=preg_grep("/ÈÕ±¾/",$tmp); 
foreach ($jpn_dir as $value)
{
	echo $value,"\n";
	copyDir($value, "good/".$value);
}

?>
