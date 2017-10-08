<?php
    include "langsettings.php";

    $text = $_REQUEST['text'];
    if ($text == "") {
        $text = "ceci n est pas un ami d apache";
    }
    if ($_REQUEST['img'] != 1) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta name="author" content="Kai Oswald Seidler">
        <link href="xampp.css" rel="stylesheet" type="text/css">
        <title><?php echo $TEXT['iart-head']; ?></title>
    </head>

    <body>
        <br><h1><?php echo $TEXT['iart-head']; ?></h1>

        <img width="520" height="320" src="<?php echo basename($_SERVER['PHP_SELF']); ?>?<?php echo htmlentities("img=1&text=".urlencode($text)); ?>" alt="">
        <p class="small"><?php echo $TEXT['iart-text1']; ?></p>
        <form name="ff" action="iart.php" method="get">
            <input type="text" name="text" value="<?php echo htmlspecialchars($text); ?>" size="30">
            <input type="submit" value="<?php echo $TEXT['iart-ok']; ?>">
        </form>
        <?php include 'showcode.php'; ?>
    </body>
</html>
<?php
        exit;
    }

    $fontfile = "./AnkeCalligraph.TTF";

    $size = 9;
    $h = 320;
    $w = 520;

    $im  =  ImageCreate($w, $h);

    $fill = ImageColorAllocate($im, 251, 121, 34);
    $light = ImageColorAllocate($im, 255, 255, 255);
    $corners = ImageColorAllocate($im, 153, 153, 102);
    $dark = ImageColorAllocate($im, 51, 51 , 0);
    $black = ImageColorAllocate($im , 0, 0 , 0);

    $colors[1] = ImageColorAllocate($im, 255, 255, 255);
    $colors[2] = ImageColorAllocate($im, 255 * 0.95, 255 * 0.95, 255 * 0.95);
    $colors[3] = ImageColorAllocate($im, 255 * 0.9, 255 * 0.9, 255 * 0.9);
    $colors[4] = ImageColorAllocate($im, 255 * 0.85, 255 * 0.85, 255 * 0.85);

    header("Content-Type: image/png");

    srand(time());

    $c = 1;
    $anz = 10;
    $step = (4 / $anz);
    for ($i = 0; $i < $anz; $i += 1) {
        $size = rand(7, 70);
        $x = rand(-390, 390);
        $y = rand(-100, 400);
        $color = $colors[$c];
        $c += $step;
        ImageTTFText($im, $size, 0, $x, $y, $color, $fontfile, $_GET['text']);
    }

    ImageLine($im, 0, 0, $w - 1, 0, $light);
    ImageLine($im, 0, 0, 0, $h - 2, $light);
    ImageLine($im, $w - 1, 0, $w-1, $h, $dark);
    ImageLine($im, 0, $h - 1, $w - 1, $h - 1, $dark);
    ImageSetPixel($im, 0 , $h - 1, $corners);
    ImageSetPixel($im, $w - 1, 0, $corners);

    ImagePNG($im);
    exit;
?>