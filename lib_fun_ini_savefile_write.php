<?php
// /var/www/html/petty_new_site_4/inifile_web_v2/lib_fun_ini.php ; From this project.
//#2010_09_11_20:53:06 add by greshem
// /****************************************************************************
// * Description: 获取所有的sect 并返回一个数组。 
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
// * Description: 把数组转换成 select 里面的  <option> </option> , 和上边的函数组合使用。 
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
// * Description: 获取INI文件里面所有的KEY  返回一个数组.	
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
// * Description: 获取INI文件里面的所有的 值项。 	
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
// * Description: 打印到 string 中去， 用来输出到文本.ini文件。
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
// * Description  获取 一个section 下所有的  keys. 	
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
// * Description: 产品介绍的文本的渲染	
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
// * Description: ini 打印到 select 的 options  是一个string. 	
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
// * Description; ini 打印到 select 的 options 	高级一点 有 <optgroug> 
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
// * Description: 打印到table	, 仅仅是显示 没有编辑功能。 
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
//$in 是类似于 1.jpg,2.jpg,3.jpg,4.jpg 这样的字符串 把他弄成 <img src=a.jpg> 的样子。 
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
		$ret.="\t<a href=product_new_ini_add.php?sect=".$sect."&key=".$key."&jpg=".$jpg."> 加到最新产品</a><br>\n";
		$ret.="\t<a href=ckedit_html.php?sect=".$sect."&key=".$key."&jpg=".$jpg."> 编辑</a><br>\n";
		$ret.="\t<a href=jpg_del_from_ini.php?sect=".$sect."&key=".$key."&jpg=".$jpg."> 删除</a>\n";
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
//打印 	ini 结构到 table 样式的 , 里面还有打印删除的 等 操作。 
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


