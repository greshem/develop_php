<?php if (!(@include 'Console/Color.php')) echo 'skip Console_Color not installed'; ?>

<?php

// if (file_exists(dirname(__FILE__) . '/../Table.php')) {
//     require_once dirname(__FILE__) . '/../Table.php';
// } else {
//     require_once 'Console/Table.php';
// }
require_once 'Console/Table.php';
require_once 'Console/Color.php';

function file_2_array()
{

	$ret=array();
	$b=file_get_contents("/etc/passwd");
	$lines=split("\n", $tmp);
	foreach ($array as $line)
	{
		$array=preg_split("/:/", $line);
	}
}

	$ret=array();
	$tmp=file_get_contents("/etc/passwd");
	$lines=split("\n", $tmp);

$table = new Console_Table(CONSOLE_TABLE_ALIGN_LEFT, CONSOLE_TABLE_BORDER_ASCII, 1, null, true);
$table->setHeaders(array('foo', 'bar', "three","four", "five","six", "seven"));
foreach ($lines as $line)
{
	$array=preg_split("/:/", $line);
$table->addRow($array);

}

// $table->addRow(array('baz', Console_Color::convert("%b here i am %n"),  'three'));
// $table->addRow(array('baz1', Console_Color::convert("%b this is the %n"), 'three'));
// $table->addRow(array('baz341', Console_Color::convert("%b testg %n"), 'threee333'));
// 
echo $table->getTable();

?>

