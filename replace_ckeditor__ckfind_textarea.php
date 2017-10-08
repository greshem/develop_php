<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
 * CKFinder
 * ========
 * http://ckfinder.com
 * Copyright (C) 2007-2010, CKSource - Frederico Knabben. All rights reserved.
 *
 * The software, this file and its contents are subject to the CKFinder
 * License. Please read the license.txt file before using, installing, copying,
 * modifying or distribute this file or part of its contents. The contents of
 * this file is part of the Source Code of CKFinder.
-->
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
	<title>CKFinder - Sample - CKEditor Integration</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<link href="sample.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="./ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="./ckeditor/ckfinder/ckfinder.js"></script>
</head>

<body>
	<?php $file=file_get_contents("output.html"); 
//	echo "##### ".$file;
	?>

	<h1>
		CKFinder - Sample - CKEditor Integration
	</h1>

	<hr />
	<form  action="save.php" method='post' > 

	<textarea id="qianqian" name="qianqian" rows="10" cols="80"><?php echo htmlspecialchars($file); ?>  

    </textarea>
<script type="text/javascript">
// This is a check for the CKEditor class. If not defined, the paths must be checked.
if ( typeof CKEDITOR == 'undefined' )
{
	document.write(
		'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
		'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
		'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
		'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
		'value (line 32).' ) ;
}
else
{
	var editor = CKEDITOR.replace( 'qianqian' );
	//editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );
	//editor.setData("wenwen");

	// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
	// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
	CKFinder.setupCKEditor( editor, '/ckeditor/ckfinder' ) ;

	// It is also possible to pass an object with selected CKFinder properties as a second argument.
	// CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
}
</script>

	</p>
	<input type=submit value=submit> submit </input> 
</form>

</body>
</html>
