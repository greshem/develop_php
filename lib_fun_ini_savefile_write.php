<?php
// /var/www/html/petty_new_site_4/inifile_web_v2/lib_fun_ini.php ; From this project.
//#2010_09_11_20:53:06 add by greshem
// /****************************************************************************
// * Description: ��ȡ���е�sect ������һ�����顣 
// * @param 	
// * @return 	
// * *************************************************************************/
if(! function_exists('get_ini_file_sections'))
{
	function get_ini_file_sections($ini)
	{
		if(! is_array($ini))
		{
			die(" para1 must b array ");
		}
		//$ret=array();
		foreach (array_unique(array_keys($ini)) as $sect)
		{
			#print "[$sect]\n";
			array_push($ret,  $sect);
		}
		return $ret;
	}

}
// /****************************************************************************
// * Description: ������ת���� select �����  <option> </option> , ���ϱߵĺ������ʹ�á� 
// *
// * @param 	
// * @return 	
// * *************************************************************************/
	function array_to_select_option_str($in)
	{
		$ret;
		foreach ($in as $key => $value)
		{
			$ret.="<option value=".$key.">".$key."</option>\n";
		}
	}
// /****************************************************************************
// * Description: ��ȡINI�ļ��������е�KEY  ����һ������.	
// * @param 	
// * @return 	
// * *************************************************************************/
	function get_ini_file_keys($ini)
	{
		if(! is_array($ini) )
		{
			die(" input must be array\n");
		}
		$ret=array();
		foreach ($ini as $key => $item)
		{
			if(is_array($item))
			{
				foreach ($item as $key2=> $value2)
				{
					array_push($ret, $key2);
				}
			}	
		}
		return  array_unique($ret) ;
	}
	
// /****************************************************************************
// * Description: ��ȡINI�ļ���������е� ֵ� 	
// * @param 	
// * @return 	
// * *************************************************************************/
	function get_ini_file_values($ini)
	{
		if(! is_array($ini) )
		{
			print(" input must be array\n");
			return null;
		}
		$ret=array();
		foreach ($ini as $key => $item)
		{
			if(is_array($item))
			{
				foreach ($item as $key2=> $value2)
				{
					array_push($ret, $value2);
				}
			}	
		}
		return  array_unique($ret) ;
	}

	function get_ini_file_value($ini, $sect, $key)
	{
		if(! is_array($ini) || ! is_string($sect) || ! is_string($key))
		{
			print(" get_ini_file_value (a,b ,c) a is array; b,c is string");
		}
		return $ini[$sect][$key];
	}
// ****************************************************************************
// * Description: ��ӡ�� string ��ȥ�� ����������ı�.ini�ļ���
// * @param 	
// * @return 	
// * *************************************************************************/
if(! function_exists('print_ini_array_to_str'))
{
	function print_ini_array_to_str($ini)
	{
		//$sects= array_keys($ini);
		if(! is_array($ini))
		{
			die("para 1 mest be a array");
		}
		$str="";	
		foreach ( $ini as $key=> $item)
		{
			if(is_array($item))
			{
		//		print "[$key]\n";
				$str.="[$key]\n";

				foreach ($item as $key2 => $value2)
				{
		//			print "\t".$key2."=".$value2."\n";
					$str.= "\t".$key2."=".$value2."\n";

				}
			}
			else
			{
		//		print $key."=".$item."\n";
				$str.=$key."=".$item."\n";
			}
		}
		return $str;
	}

}

// /****************************************************************************
// * Description  ��ȡ һ��section �����е�  keys. 	
// * @param 	
// * @return 	
// * *************************************************************************/
if( ! function_exists('get_ini_file_one_section_keys'))
{
	function get_ini_file_one_section_keys($file, $sect )
	{
		$ret=array();
		if( !(is_string($file) && is_string($sect)) )
		{
			die("all para must be strings");
		}
		$array=parse_ini_file("../product.ini", 1);
		
		if(!isset($array[$sect]))
		{
			return $ret;
		}
		
	//	if(!isset(array_keys($array[$sect])))
	//	{
	//		return $ret;
	//	}
		foreach (array_unique(array_keys($array[$sect])) as $iniKey)
		{
			#print "[$sect]\n";
			array_push($ret,  $iniKey);
		}
		return $ret;
	}
}
// /****************************************************************************
// * Description: ��Ʒ���ܵ��ı�����Ⱦ	
// * @param 	
// * @return 	
// * *************************************************************************/
if(! function_exists("renderTxtInfo"))
{
		function renderTxtInfo($file)
		{
			if(is_string($file))
			{
				die("usage: para 1 must be a string");
			}
			$a=file_get_contents($file);
			$lines=split("\n", $a);
			$i=0;
			foreach ($lines as $line)
			{
				if($i==0)
				{
					$tmp=preg_replace("/(.+)$/", "<h2>\$1</h2>", $line );
				}
				else
				{
					$tmp=preg_replace("/(.+$)/", "<h3>\$1</h3>", $line );
				}

				echo $tmp."\n";
				$i++;
			}
		}

}
// /****************************************************************************
// * Description: ini ��ӡ�� select �� options  ��һ��string. 	
// * @param 	
// * @return 	
// * *************************************************************************/
	function print_ini_section_to_option_str($ini)
	{
		if( ! is_array($ini))
		{
			die(" input must be array ");
		}	
		$str="";
		foreach (array_unique(array_keys($array)) as $sect)
		{
			#print "[$sect]\n";
			#array_push($ret,  $sect);
			$str.= "\t<option value=".$sect.">".$sect."</option>\n";
		}
		return $str;

	}

// /****************************************************************************
// * Description; ini ��ӡ�� select �� options 	�߼�һ�� �� <optgroug> 
// * @param 	
// * @return 	
// * *************************************************************************/
function print_ini_array_to_select_opt_str($ini)
{
	//$sects= array_keys($ini);
	//$str="<select >\n ";	
	if(! is_array($ini))
	{
		die("para must be array");
	}
	$str="";
	foreach ( $ini as $key=> $item)
	{
		if(is_array($item))
		{
	//		print "[$key]\n";
			$str.="<optgroup label=".$key.">\n";

			foreach ($item as $key2 => $value2)
			{
	//			print "\t".$key2."=".$value2."\n";
				$str.= "\t<option value=".$key2.">".$key2."</option>\n";

			}
			$str.="</optgroup>\n";
		}
		else
		{
	//		print $key."=".$item."\n";
			$str.=$key."=".$item."\n";
		}
	}
	//$str.="</select>\n";
	return $str;
}

	//
// /****************************************************************************
// * Description: ��ӡ��table	, ��������ʾ û�б༭���ܡ� 
// * @param 	
// * @return 	
// * *************************************************************************/
function print_ini_array_to_table($ini)
{
	//$sects= array_keys($ini);
	//$str="<select >\n ";	
	$str="<table border=0> \n";
	foreach ( $ini as $key=> $item)
	{
		if(is_array($item))
		{
	//		print "[$key]\n";

			$count=count($item);
			$count++;
			$str.="\t<tr><td rowspan=".$count."><strong>".$key."</strong></td><td></td><td></td></tr>\n";
			foreach ($item as $key2 => $value2)
			{
	//			print "\t".$key2."=".$value2."\n";
				$str.= "\t\t<tr><td> ".$key2."</td><td>".$value2."</td></tr>\n";

			}
			//$str.="</tr>\n";
		}
		else
		{
	//		print $key."=".$item."\n";
	//	$str.=$key."=".$item."\n";
		}
	}
	$str.="</table>\n";
	//$str.="</select>\n";
	return $str;
}

//########################################################################
//$in �������� 1.jpg,2.jpg,3.jpg,4.jpg �������ַ��� ����Ū�� <img src=a.jpg> �����ӡ� 
//function expand_ini_value_2_html_imgs( $sect, $key, $in)
function gen_html_tables_imgs_from_ini_values( $sect, $key, $in)

{
	$ret="";
	$arr=split("," , $in);
	$arr=array_filter($arr);
	
	$count=0;
	$ret="<table border=1px >\n";
	foreach($arr as $jpg)
	{
		$path=strtolower("../photos/".$sect."/".$key."/".$jpg);
		
		if(! file_exists($path))
		{
			$path="noexists/".$path;
		}
		if($count%4==0)
		{
			$ret.="<tr>\n";	
		}
		$ret.="<td>\n";
		$ret.="\t<img  width=80 height=60 style=\"border:0 none;padding:0;\" src=".$path.">\n";
		$ret.="\t<a href=product_new_ini_add.php?sect=".$sect."&key=".$key."&jpg=".$jpg."> �ӵ����²�Ʒ</a><br>\n";
		$ret.="\t<a href=ckedit_html.php?sect=".$sect."&key=".$key."&jpg=".$jpg."> �༭</a><br>\n";
		$ret.="\t<a href=jpg_del_from_ini.php?sect=".$sect."&key=".$key."&jpg=".$jpg."> ɾ��</a>\n";
		$ret.="</td> \n";
		if($count%4==3)
		{
			$ret.="</tr>\n";
		}
		$count++;
	}
	$ret.="</table>\n";
	return $ret;
}

//########################################################################
//��ӡ 	ini �ṹ�� table ��ʽ�� , ���滹�д�ӡɾ���� �� ������ 
//          +------+---------------------------
//          |sect1 |--------------------------|     
//          +------+--------------------------| 
//          |      +--------------------------|
//          |sect2 +--------------------------|
//          |      +--------------------------|-
//          +------+--------------------------+

function print_ini_array_to_table_decoration($ini)
{
	//$sects= array_keys($ini);
	//$str="<select >\n ";	
	$str="<table border=1> \n";
	foreach ( $ini as $key=> $item)
	{
		if(is_array($item))
		{
			$count=count($item);
			$count++;
			$str.="\t<tr><td rowspan=".$count."><strong><a href=del_one_sect.php?sect=".$key."> ".$key."<a></strong></td><td></td><td></td><td></td></tr>\n";
			foreach ($item as $key2 => $value2)
			{
				$str.= "\t\t<tr><td> ".$key2."<a href=del_one_sect.php?sect=".$key."&key=".$key2.">  del  </a></td><td>".expand_ini_value($key, $key2, $value2)."</td><td>".$value2."</td></tr>\n";
			}
		}
		else
		{
			//	$str.=$key."=".$item."\n";
		}
	}
	$str.="</table>\n";
	return $str;
}

?>

<?php 
//echo gen_html_tables_imgs_from_ini_values( "aaa", "bbb", "1.jpg, 2.jpg,3.jpg,4.jpg");
?>


