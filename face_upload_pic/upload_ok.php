<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.
$count=0;


$name= $_FILES["userfile"]['name'];

$uploadfile = "photos/".$name;
$uploadfile=strtolower($uploadfile);

var_dump($_FILES);

echo "upload file is ".$uploadfile."<br>";
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
{
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}

echo 'Here is some more debugging info:';
print_r($_FILES);

print "</pre>";
$inurl=$_SERVER['HTTP_REFERER'];

echo "<a href=".$inurl.">return </a>";

include ("show_pic.php");
?>  
