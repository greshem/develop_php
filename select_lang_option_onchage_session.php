<?php 
	$lang=array( "en"=>"English",
                 "de"=>"German",
                 "es"=>"Spanish",
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
                 "ru"=>"Russian",
                 "sv"=>"Swedish");

print_r($lang);







 ?>
<select width=100 onchange="window.open('<?php echo $_SERVER['PHP_SELF']; ?>?lang='+options[selectedIndex].value);" class="font-12" name="menu1">
<?php 
	foreach ($lang as $key=>$value)
	{
		print "<option value=".$key.">".$value."</option>\n";
	}
 ?>
	<!--  <option value="en">English</option>
	 <option value="de">German</option>
	<option value="es">Spanish</option>
	<option value="fr">French</option>
	<option value="it">Italian</option>
	<option value="pt">Portuguese</option>
	<option value="ja">Japanese</option>
	<option value="ko">Korean</option>
	<option value="ar">Arabic</option>
	<option value="bg">Bulgarian</option>
	<option value="hr">Croatian</option>
	<option value="cs">Czech</option>
	<option value="da">Danish</option>
	<option value="nl">Dutch</option>
	<option value="fi">Finnish</option>
	<option value="el">Greek</option>
	<option value="hi">Hindi</option>
	<option value="no">Norv</option>
	<option value="pl">Polish</option>
	<option value="ro">Romanian</option>
	<option value="ru">Russian</option>
	<option value="sv">Swedish</option> --> 

</select>			

