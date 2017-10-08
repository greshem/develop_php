
<?php 
/**
 * Remove the directory and its content (all files and subdirectories).
 * @param string $dir the directory name
 */
function rmrf($dir) 
{
    foreach (glob($dir) as $file) {
        if (is_dir($file)) {
            rmrf("$file/*");
            rmdir($file);
        } else {
            unlink($file);
        }
    }
}
?> 
