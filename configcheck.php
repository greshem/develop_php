#!/usr/bin/php -q
<?

echo "Checking PHP Configuration\n";

echo "checking PHP version...";
if (version_compare("4.3.0", phpversion()) == 1) {
    echo "failed\n";
    echo "ERROR: Version must be 4.3.0 or higher\n";
    //exit(1);
}
echo "ok\n";

echo "checking for mcrypt...";
if (! extension_loaded('mcrypt')) {
    echo "failed\n";
    echo "ERROR: PHP mcrypt extension is required.  See the README\n";
 //   //exit(1);
}
echo "ok\n";

echo "checking for mhash...";
if (! extension_loaded('mhash')) {
    echo "failed\n";
    echo "ERROR: PHP mhash extension is required.  See the README\n";
    ////exit(1);
}
echo "ok\n";

echo "checking for posix extension...";
if (! extension_loaded('posix')) {
    echo "failed\n";
    echo "ERROR: PHP POSIX extension is required.  See the README\n";
    ////exit(1);
}
echo "ok\n";

echo "checking for mysql...";
if (! extension_loaded('mysql')) {
    echo "failed\n";
    echo "ERROR: PHP MySQL extension is required.  See the README\n";
    //exit(1);
}
echo "ok\n";

echo "checking for sockets...";
if (! extension_loaded('sockets')) {
    echo "warning\n";
    echo "WARNING: Mangler can make use of PHP sockets to improve performance.  See the README\n";
    //exit(1);
}
echo "ok\n";

echo "checking for PEAR...";
@include 'PEAR.php';
if (! class_exists('pear')) {
    echo "failed\n";
    echo "ERROR: PEAR is required. See the README\n";
    //exit(1);
}
echo "ok\n";

echo "checking for PEAR DB...";
@include 'DB.php';
if (! class_exists('db')) {
    echo "failed\n";
    echo "ERROR: PEAR is required. See the README\n";
    //exit(1);
}
echo "ok\n";

echo "checking for PEAR Net_DNS...";
@include 'Net/DNS.php';
if (! class_exists('net_dns')) {
    echo "failed\n";
    echo "ERROR: PEAR Net_DNS module is required. See the README\n";
    //exit(1);
}
echo "ok\n";

echo "checking for value of register_argc_argv...";
$iniset = ini_get_all();
if ($iniset['register_argc_argv']['local_value'] != 1) {
    echo "failed\n";
    echo "ERROR: INI setting register_argc_argv must be enabled. See the README\n";
    //exit(1);
}
echo "ok\n";

echo "including 'mangler/mangler.inc'...";
@include 'mangler/mangler.inc';
if (! defined('MANGLER_BASEDIR')) {
    echo "failed\n";
    echo "ERROR: Is the mangler include dir in your include path. See the README\n";
    //exit(1);
}
echo "ok\n";

echo "attempting database connection...";
$dbh = DB::connect(DSN);
if (DB::isError($dbh)) {
    echo "failed\n\n";
    echo "Used DSN: " . DSN . "\n";
    echo "ERROR: DB module responded:\n" . $dbh->getUserInfo() . "\n";
    echo "\n";
    echo "- Is MySQL running?\n\n";
    echo "- Did you create the Mangler database?\n\n";
    echo "- Maybe your MySQL socket is in the wrong place?  Use the --with-mysql-sock PHP\n";
    echo "configure option or edit your php.ini mysql.default_socket setting\n\n";
    //exit(1);
}
echo "connected\n";


?>
