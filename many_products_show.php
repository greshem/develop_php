
<?
function show_one_pic($pic)
{ 

echo <<<EOF
<table height="100%" width="99%" cellspacing="0" cellpadding="0" border="0">
           <tbody>
			<!-- 产品 图片 --> 
			  <tr> 
                <td height="120" align="center"><table width="90%" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                    <tr>
																		<!-- 产品 图片 长度  宽度。  --> 
                      <td align="center"><a target="_blank" href="#"><img height="210" width="256" border="0" src="$pic"></a></td>
                    </tr>
                  </tbody>
                 </table>
				</td>
              </tr>
			<!--  产品规格 其他.  --> 
              <tr> 
                <td>
					<table width="95%" cellspacing="0" cellpadding="0" border="0">
                          <tbody>
							<tr valign="top"> 
							<!--  红色 箭头  --> 
                             <td width="18%" align="right"><img height="10" width="12" src="images/right_shift.jpg">&nbsp;</td>
							<!-- 带有规格号的， 产品名  --> 
                             <td><a class="link3_both3" target="_blank" href="cata_info.php?id=1369">name</a> </td>
                           </tr>
                          <tr>
							<td height="8"></td>
                          </tr>
                          <tr> 
							<!-- shift 绿色箭头 --> 
                            <td align="right"><img height="8" width="9" src="images/http_40.jpg">&nbsp;</td>
							<!-- more 的图片 --> 
                            <td><a target="_blank" href="product_info.id=1369"><img height="16" width="69" border="0" src="images/more.jpg"></a></td>
                          </tr>
                          </tbody>
					 </table>                
			    </td>
              </tr>

              <tr> 
                <td>&nbsp;</td>
              </tr>
          </tbody>
</table>

EOF;
}
?>

<html>
<body> 
<!--
20110109
用的时候， 把外面的table 全部要去掉的.
#2011_01_09_21:56:07 add by greshem, 修改成 EOF 的方式. 
-->
<table width="232" >

<tr>
	<td width=245 height=200> <?php  show_one_pic("images/product.png");?>  </td>
	<td width=245 height=200><?php  show_one_pic("images/product.png"); ?> </td> 
	<td width=245 height=200><?php  show_one_pic("images/product.png"); ?> </td> 
</tr>

<tr>
	<td width=245 height=200> <?php  show_one_pic("images/product.png");?>  </td>
	<td width=245 height=200><?php  show_one_pic("images/product.png"); ?> </td> 
	<td width=245 height=200><?php  show_one_pic("images/product.png"); ?> </td> 
</tr>

<tr>
	<td width=245 height=200> <?php  show_one_pic("images/product.png");?>  </td>
	<td width=245 height=200><?php  show_one_pic("images/product.png"); ?> </td> 
	<td width=245 height=200><?php  show_one_pic("images/product.png"); ?> </td> 
</tr>

</table>

</body>
</html>
