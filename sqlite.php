
// 2012_09_13_20:44:53   星期四   add by greshem
本教程将向你介绍SQLite API所支持的重要方法，提供一个能够用在你开发中的简单脚本模板，从而告诉你如何使用PHP与SQLite数据库进行交互操作。本文假设你已经安装好了 Apache和PHP。
        你的系统上并不是一定非要安装可交互的SQLite程序；但是为了能够简化创建本教程所需要的一系列初始表格，你应该下载和安装这个程序。然后，为你的SQL查询创建一个示例表格，方法是创建一个空白的文本文件，将该文件名作为下列命令（列表A）的参数在交互命令提示符下执行二进制程序：
sqlite> CREATE TABLE users (id INTEGER PRIMARY KEY, username TEXT, country TEXT);
sqlite> INSERT INTO users VALUES (1, john, IN);
sqlite> INSERT INTO users VALUES (2, joe, UK);
sqlite> INSERT INTO users VALUES (3, diana, US);

一旦表格创建好了，下面就是使用PHP的SQLite方法建立一个脚本模板。
<?php 
// set access parameters
$db = "users.db";
// open database file
// make sure script has read/write permissions!
$conn = sqlite_open($db) or die ("ERROR: Cannot open database");
// create and execute INSERT query
$sql = "INSERT INTO users (id, username, country) VALUES (5, pierre, FR)";
sqlite_query($conn, $sql) or die("Error in query execution: " .　sqlite_error_string(sqlite_last_error($conn)));
// create and execute SELECT query
$sql = "SELECT username, country FROM users";
$result = sqlite_query($conn, $sql) or die("Error in query execution: " . sqlite_error_string(sqlite_last_error($conn)));
// check for returned rows
// print if available
if (sqlite_num_rows($result) > 0) 
{
while($row = sqlite_fetch_array($result)) 
{
echo $row[0] . " (" . $row[1] . ") ";
}
}
// close database file
sqlite_close($conn);
?>

在使用PHP的SQLite扩展执行SQL查询的时候，要按照下列四个简单步骤进行：
1.调用sqlite_open()函数来初始化数据库句柄。数据库的路径和文件名（要记住，SQLite是基于文件的，而不是像MySQL那样基于服务器）被作为自变量传递给函数。

2.创建SQL查询字符串，用sqlite_query()函数执行它。这些方法的结果对象会依据查询的类型以及它是否成功而有所不同。成功的 SELECT查询会返回一个结果对象；成功的INSERT／UPDATE／DELETE查询会返回一个资源标识符；不成功的查询会返回“伪”。 sqlite_error_string()和sqlite_last_error()方法能够被用来捕捉错误并显示相应的错误信息。

3.对于SELECT查询，结果对象可以被进一步处理，以便从中提取数据。当sqlite_fetch_array()函数用在循环里的时候会把每条记录作为PHP的数组取回。你可以通过调用数组合适的键来访问每条记录的各个字段。

4.调用sqlite_close()函数可以结束会话。
PHP 5.x的一个创新之举是加入了SQLite数据库引擎。SQLite是一个基于文件的、功能齐全的可移植数据库引擎，它能够被用来进行绝大多数SQL操作而不会加重客户端－服务器通信的负载。PHP

5.x里的这个SQLite API在默认情况下会被激活，这也意味着你可以立即就使用SQLite。
希望这个脚本模块能够在你下一次坐下来用PHP编写SQLite连接／交互例程的时候为你节省一些时间。编程愉快！ 
