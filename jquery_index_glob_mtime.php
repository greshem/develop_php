<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta content="text/html; charset=gb2312" http-equiv="Content-Type">
<title>index_of_234</title>

<style type="text/css">
<!--
table {border-collapse: collapse;   border: 0px; padding: 0px;}
td, th { border: 1px solid #dddddd; }
-->
</style>

<!--
#2011_01_09_13:42:05 add by greshem
之前， 这里添加了 jquery 的按照TABLE 来查找的功能, 再添加， 根据MTIME 一个信息之内的才显示. 
--> 

<script type="text/javascript" src="js/jquery.js" language="JavaScript"></script>
    <script src="js/jquery.tablesorter-2.0.4.js" type="text/javascript"></script>
    <script src="js/jquery.quicksearch.js" type="text/javascript"></script>
 <script language="JavaScript">
<!--
    $("document").ready(function(){
    
      $("#tableOne").tablesorter({ sortList: [[0, 0]], widgets: ['zebra'] });
	
	$("#tableOne tbody tr").quicksearch({
            labelText: '查找: ',
            attached: '#tableOne',
            position: 'before',
            delay: 100,
            loaderText: 'Loading...',
            onAfter: function() {
                if ($("#tableOne tbody tr:visible").length != 0) {
                    $("#tableOne").trigger("update");
                    $("#tableOne").trigger("appendCache");
                    $("#tableOne tfoot tr").hide();
                }
                else {
                    $("#tableOne tfoot tr").show();
                }
            }
        });
 
      $("#tableTwo").tablesorter({ sortList: [[0, 0]], widgets: ['zebra'] });
	
	$("#tableTwo tbody tr").quicksearch({
            labelText: '查找: ',
            attached: '#tableTwo',
            position: 'before',
            delay: 100,
            loaderText: 'Loading...',
            onAfter: function() {
                if ($("#tableTwo tbody tr:visible").length != 0) {
                    $("#tableTwo").trigger("update");
                    $("#tableTwo").trigger("appendCache");
                    $("#tableTwo tfoot tr").hide();
                }
                else {
                    $("#tableTwo tfoot tr").show();
                }
            }
        });
 
     $("#btn1").click(function(){
        
       $("[name='checkbox']").attr("checked",'true');//靠
	   
	   var $chkarry=$('#del input[type="checkbox"]');
	   $chkarry.each(function(){$(this).attr('checked','true')});
     
     })
     $("#btn2").click(function(){
         
         $("[name='checkbox']").removeAttr("checked");//肯靠
	   var $chkarry=$('#del input[type="checkbox"]');
	   $chkarry.each(function(){$(this).removeAttr('checked')});
     
    })
    })
 //-->;
 </script>
</head>

<body>
<strong> Notiece: 最近一个星期之内的工作过的网页才会在页面上显示       </strong> 
<?
	//$tmp=file_get_contents(".config");
	// $lines=split("\n", $tmp);
	// foreach ($lines as $line)
	// {
	// 	if(preg_match("/^#/", $line))
	// 	{
	// 		continue;
	// 	}
	// 	$tmp_cfg=split("=",$line);
	// 	$kernel_config[$tmp_cfg[0]]=$tmp_cfg[1];
	// }
?>
<?
//print_r($config);
//exit(-1);
//$a=file_get_contents("net_config.txt");
//$lines=split("\n", $a);
//include("nessary_CONFIG.php");
//include("netcard_summray.php");
echo "<form method=POST action=config_nessary_net_module.php target=_blank>\n";

echo "<input name=submit type=submit  value=reset /> \n";
echo "</form>\n";
echo "<hr>\n";

echo "<form id=del method=POST  action=modify_config.php target=_blank>\n";
echo "<table id=tableOne >\n";
?>
<thead>
		<tr>            		    		    
			<th><a href="#" title="Click Header to Sort">Name</a></th>			
			<th><a href="#" title="Click Header to Sort">Summary</a></th>
		</tr>
</thead>

<?
foreach (glob("*") as $value)
{
	if( (time() - filemtime($value)) >  7*24*60*60 )
	{
		continue;
	}
	echo "<tr><td>  ";
	if(is_dir($value) )
	{
		echo" <img src=/icons/folder.gif>";	;
	}
	else if (is_file($value))
	{
		echo "<img src=/icons/text.gif > ";
	}
	 echo " <a target=_blank  href=".$value.">". $value."</a></td> </tr> \n";

}
echo "</table>\n";
echo '<input type="button" id="btn1" value="全选">';
echo '<input type="button" id="btn2" value="取消全选">'; 
echo '<input name="submit" type="submit" value="提交修改.config" />';
echo "</form>"; 
?>
</body>
</html>
