<html>
<body bgcolor=yellow>
<tr align=left bgcolor=red><td>
<?PHP
if($_GET['scan']) 
{
	echo $_GET['scan'];

}
echo $_POST['scan'];
echo $_FILE[''][''];
if ($HTTP_POST_VARS['action'] == 'submitted') 
{
	echo "success\n";
}
    print_r($HTTP_POST_VARS);
    print_r($HTTP_GET_VARS);
    print '<a href="'. $HTTP_SERVER_VARS['PHP_SELF'] ;
?>
</tr></td>
</body>
</html>
