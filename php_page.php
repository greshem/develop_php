<?php 
 $hostname='localhost'; //Êı¾İ¿âÖ÷»úÃû
 $username='root'; //Êı¾İ¿âÓÃ»§Ãû
 $userpswd=''; //Êı¾İ¿âÓÃ»§ÃÜÂë
 $dbname='sql_name; //Êı¾İ±íÃû
 $table="production"; //±íÃû
 
 //Á¬½ÓÊı¾İ¿â·şÎñÆ÷
 mysql_connect($hostname,$username,$userpswd);
 //Ñ¡ÔñÊı¾İ±í
 mysql_select_db($dbname);
 
 $page_size=5; //Éè¶¨Ã¿Ò³ÏÔÊ¾µÄ¼ÇÂ¼ÌõÊı
 
 //²éÑ¯×ÜÌõÊı£¬¼ÆËã×ÜÒ³Êı
 $result=mysql_query("select count(*) from $table where 1");
 $total_message=mysql_result($result,0);
 $total_page=ceil($total_message/$page_size);
 
 
 @$page= $_GET['page'];
 //ÅĞ¶Ïµ±Ç°Ò³ºÅ
 if(!isset($page)){
  $page=1;
 }else{
  $page+=0;
  $page=floor($page);
  if($page>$total_page) $page=$total_page;
  if($page<1) $page=1;
 }
 //¼ÆËãÒª¶ÁÈ¡µÄÊ×Ìõ¼ÇÂ¼Î»ÖÃ
 $start_id=($page-1)*$page_size;
 
 //¶ÁÈ¡µ±Ç°Ò³µÄ¼ÇÂ¼
 $result=mysql_query("select * from $table where 1 limit $start_id,$page_size");
 echo "<table>";
 while($row=mysql_fetch_array($result)){
  //ÕâÀïÈ¡³öÊı¾İ¿âÄÚµÄÄÚÈİ
 echo "<tr><td>".$row['pic_name']."</td></tr>";
 }
 echo "</table>";
 $show_pages=cutpage(); //½øĞĞ·ÖÒ³
 
 //ÏÔÊ¾×îÖÕ½á¹û
 echo"<center><br><hr>$show_pages<br></center>";
 
 function cutpage(){
 global $page,$total_page;
 $prev_page=$page-1;
 $next_page=$page+1;
 if($prev_page>=1){
 $prev_page="<a href=Page.php?page=$prev_page>ÉÏÒ³</a>";
 }else{
 $prev_page="ÉÏÒ³";
 }
 
 if($next_page>$total_page){
 $next_page="ÏÂÒ³";
 }else{
 $next_page="<a href=Page.php?page=$next_page>ÏÂÒ³</a>";
 }
 
 $pageshow="µÚ $page Ò³, ¹² $total_page Ò³    ";
 $pageshow.="<a href=Page.php>Ê×Ò³</a> $prev_page $next_page <a href=Page.php?page=$total_page>Ä©Ò³</a>";
 return $pageshow;
 }
 ?>