<script language=javascript>
function RestartDHCP()
{
	var xmlhttp ;
	try
	{
		xmlhttp = new XMLHttpRequest() ;
	}
	catch(e)
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP") ;
	}
	xmlhttp.onreadystatechange=function(){
		if( 4==xmlhttp.readyState){
			if( 200 == xmlhttp.status)
			{
				var strRl = xmlhttp.responseText ;
				alert(strRl);
			}//if
		}//function
	}//xmlhttp.onreadystatechange
	xmlhttp.open("get" , "restartdhcp.php", true ) ;
	xmlhttp.send() ;
}
</script>

