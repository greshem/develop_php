function prtErr($msg,$cmd) {

	echo("<script language='javascript'>\n");

	echo("<!--\n");

	if($msg) {

		echo("alert('$msg');\n");

	}

	echo("$cmd\n");

	echo("// -->\n");

	echo("</script>\n");

}

