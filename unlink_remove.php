<?php
copy("/etc/passwd", "/tmp/aa");
print_r("/tmp/aa");
unlink("/tmp/aa");


?>
