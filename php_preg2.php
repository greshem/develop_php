<?php  
  $patterns   =   array("/(19|20\d{2})-(\d{1,2})-(\d{1,2})/",   "/^\s*{(\w+)}\s*=/");  
  $replace   =   array("\\3/\\4/\\1",   "$\\1   =");  
  print   preg_replace($patterns,   $replace,   "{startDate}   =   1969-6-19");  
  ?>     
