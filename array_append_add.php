<?php
    $a=range(1,100);
    array_push($a, 111);
    #$a=array_push($a, 3333);
    var_dump($a);

    $b=range(100,200);
    array_merge($a, $b);
    
?>
