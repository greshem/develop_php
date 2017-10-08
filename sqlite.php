
// 2012_09_13_20:44:53   ������   add by greshem
���̳̽��������SQLite API��֧�ֵ���Ҫ�������ṩһ���ܹ������㿪���еļ򵥽ű�ģ�壬�Ӷ����������ʹ��PHP��SQLite���ݿ���н������������ļ������Ѿ���װ���� Apache��PHP��
        ���ϵͳ�ϲ�����һ����Ҫ��װ�ɽ�����SQLite���򣻵���Ϊ���ܹ��򻯴������̳�����Ҫ��һϵ�г�ʼ�����Ӧ�����غͰ�װ�������Ȼ��Ϊ���SQL��ѯ����һ��ʾ����񣬷����Ǵ���һ���հ׵��ı��ļ��������ļ�����Ϊ��������б�A���Ĳ����ڽ���������ʾ����ִ�ж����Ƴ���
sqlite> CREATE TABLE users (id INTEGER PRIMARY KEY, username TEXT, country TEXT);
sqlite> INSERT INTO users VALUES (1, john, IN);
sqlite> INSERT INTO users VALUES (2, joe, UK);
sqlite> INSERT INTO users VALUES (3, diana, US);

һ����񴴽����ˣ��������ʹ��PHP��SQLite��������һ���ű�ģ�塣
<?php 
// set access parameters
$db = "users.db";
// open database file
// make sure script has read/write permissions!
$conn = sqlite_open($db) or die ("ERROR: Cannot open database");
// create and execute INSERT query
$sql = "INSERT INTO users (id, username, country) VALUES (5, pierre, FR)";
sqlite_query($conn, $sql) or die("Error in query execution: " .��sqlite_error_string(sqlite_last_error($conn)));
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

��ʹ��PHP��SQLite��չִ��SQL��ѯ��ʱ��Ҫ���������ĸ��򵥲�����У�
1.����sqlite_open()��������ʼ�����ݿ��������ݿ��·�����ļ�����Ҫ��ס��SQLite�ǻ����ļ��ģ���������MySQL�������ڷ�����������Ϊ�Ա������ݸ�������

2.����SQL��ѯ�ַ�������sqlite_query()����ִ��������Щ�����Ľ����������ݲ�ѯ�������Լ����Ƿ�ɹ���������ͬ���ɹ��� SELECT��ѯ�᷵��һ��������󣻳ɹ���INSERT��UPDATE��DELETE��ѯ�᷵��һ����Դ��ʶ�������ɹ��Ĳ�ѯ�᷵�ء�α���� sqlite_error_string()��sqlite_last_error()�����ܹ���������׽������ʾ��Ӧ�Ĵ�����Ϣ��

3.����SELECT��ѯ�����������Ա���һ�������Ա������ȡ���ݡ���sqlite_fetch_array()��������ѭ�����ʱ����ÿ����¼��ΪPHP������ȡ�ء������ͨ������������ʵļ�������ÿ����¼�ĸ����ֶΡ�

4.����sqlite_close()�������Խ����Ự��
PHP 5.x��һ������֮���Ǽ�����SQLite���ݿ����档SQLite��һ�������ļ��ġ�������ȫ�Ŀ���ֲ���ݿ����棬���ܹ����������о������SQL������������ؿͻ��ˣ�������ͨ�ŵĸ��ء�PHP

5.x������SQLite API��Ĭ������»ᱻ�����Ҳ��ζ�������������ʹ��SQLite��
ϣ������ű�ģ���ܹ�������һ����������PHP��дSQLite���ӣ��������̵�ʱ��Ϊ���ʡһЩʱ�䡣�����죡 
