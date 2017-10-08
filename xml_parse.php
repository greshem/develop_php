<?php 


$info=simplexml_load_file('/root/develop_python/diveintopython-5.4/kgp/thanks.xml');
print_r($info);
    
// $LineNum = $info->tblFlight[0]->LineNum;
// 
// echo $LineNum;
// 
// foreach ($info->LeapsoulInfo as $tblFlight)
// {
//     echo $tblFlight->LineNum."<br/>";
//     echo $tblFlight->FlightNo."<br/>";
//     echo $tblFlight->DepTime."<br/>";
//     echo $tblFlight->ArvTime."<br/>";
//     echo $tblFlight->Meal."<br/>";
//     echo $tblFlight->PlaneStyle."<br/>";
//     echo $tblFlight->HasStop."<br/>";
//     echo $tblFlight->OrgCity."<br/>";
//     echo $tblFlight->DstCity."<br/>";
// }
// 
// foreach($info->xpath('//LineNum') as $value) {  
//     echo $value.'<br />';
// }


?>
