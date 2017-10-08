<?php  
include("Image/Color.php");
        if(isset($this))
        {   
            return $this->rgb2hex(array($r, $g, $b));
        }   
        else
        {   
            print_r( Image_Color::rgb2hex( array(255, 255, 0)));

        } 
?>
