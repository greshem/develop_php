<?
require_once ("Image/Color.php");

$color=new Image_Color();

        $color->setColors('#ffffff', '#000000');
        $result = $color->getRange();
		print_r($result);

        $color->setColors('#ffffff', '#000000');
        $result = $color->getRange(5);
		print_r($result);

        $result = Image_Color::color2RGB('#00ff00');
		print_r($result);

		$result=Image_Color::hsv2rgb(1, 128, 128);
		
		print_r($result);

		echo "#".Image_Color::rgb2hex($result);

?>
