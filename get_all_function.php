<?php
  // the php mirror 
  $php_host = "http://us2.php.net/";

  // the number of cols in our table
  $num_cols = 3;

  $ar = get_defined_functions();
  $int_funct = $ar[internal];
  sort($int_funct);
  $count = count($int_funct);
?>
<html>
 <head>
  <title>
   Available PHP Functions
  </title>
 </head>
 <body>
  <p>
   <?php print $count; ?> functions    
   available on 
   <?php 
     print $_SERVER[SERVER_NAME]; 
     ?>
  (<a href="<?php print $php_host;?>" 
   target="phpwin">php</a>
   version 
   <?php print phpversion(); ?>)
  </p>
  <table align="center" border="2">
   <tr>  
<?php
  for($i=0;$i<$count;$i++) {
   $doc = $php_host 
     . "manual/en/function."
     . strtr($int_funct[$i], "_", "-") 
     . ".php";
   print "    <td><a href=\"" . $doc 
     . "\" target=\"phpwin\">" 
     . $int_funct[$i] 
     . "</a></td>\n";
   if(($i > 1) 
     && (($i+$num_cols)%$num_cols==($num_cols-1)))  
     print "  </tr>\n  <tr>\n";
   }
  for($i=($num_cols-($count%$num_cols));$i>0;$i--)  
   print "    <td>&nbsp;</td>\n";
?>
  </table>
 </body>
</html> 