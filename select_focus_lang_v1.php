<?php 
	$lang=array( "en"=>"English",
                 "ru"=>"Russian",
				 "zh"=>"Chinese");
                 
	$lang_extra=array("es"=>"Spanish",
                 "de"=>"German",
                 "fr"=>"French",
                 "it"=>"Italian",
                 "pt"=>"Portugue",
                 "ja"=>"Japanese",
                 "ko"=>"Korean",
                 "ar"=>"Arabic",
                 "bg"=>"Bulgaria",
                 "hr"=>"Croatian",
                 "cs"=>"Czech",
                 "da"=>"Danish",
                 "nl"=>"Dutch",
                 "fi"=>"Finnish",
                 "el"=>"Greek",
                 "hi"=>"Hindi",
                 "no"=>"Norv",
                 "pl"=>"Polish",
                 "ro"=>"Romanian",
                 "sv"=>"Swedish");

print_r($lang);







 ?>
<select width=100 onchange="window.open('<?php echo $_SERVER['PHP_SELF']; ?>?lang='+options[selectedIndex].value);" class="font-12" name="menu1">
<?php 
	foreach ($lang as $key=>$value)
	{
		if( $key==$_GET['lang'])
		{
			print "<option selected=true  value=".$key.">".$value."</option>\n";
		}
		else
		{
			print "<option value=".$key.">".$value."</option>\n";
		}
	}
 ?>

</select>			

