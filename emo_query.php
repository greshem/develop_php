<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>


<script language="javascript"> 
    function check_add_quiz()
    {   
        if (quiz.user.value=="")
        {
                alert("请输入用户名 ");
                quiz.user.focus();
            return false;
        }
        return true;
    }   
    function  check_add_quiz_no()
    {
        if (quiz_no.user.value=="")
        {
                alert("请输入用户名 ");
                quiz_no.user.focus();
            return false;
        }

    }
</script>



<body>

<?php

session_start();

if ( isset($_POST['user'])) 
{ 
        $_SESSION['user']=$_POST['user'];
}

if (! isset($_SESSION['user']) ) 
{
    $_SESSION['user']="nobody";
}
else
{

    if ( isset($_POST['user'])) 
    { 
        $_SESSION['user']=$_POST['user'];
    }
}


?>

<?php 

	function logger($str)
	{
		file_put_contents("emo_query.log", $str,  FILE_APPEND);
	}
    function   get_word($offset)
    {
        $offset=$offset-1;
        $tmp=file_get_contents("verb.txt");
        $arr=split("\n", $tmp);
        #$offset= rand(0,count($arr)); 
        return $arr[$offset];
    }
    
	
    #var_dump($_POST);
    $verb_prev=$_POST["action"];
    if(isset($_GET["offset"])) 
    {
        $_SESSION["offset"]=$_GET['offset'];
    }
    else
    {
        if( ! isset($_POST['submit']) ) 
        {
            $_SESSION["offset"]=1;
        }
    }
    $offset= $_SESSION["offset"];
    #var_dump($offset);
    $verb=get_word($offset);

    #print "上一个动词:   $verb_prev <br>";
    print "当前动词:     $verb <br>";
    print '<pre>';

    #echo json_encode($_POST);
    #暂时为硬编码. json_encode unicode 编码 可读性不好. 
    $log_str.="q1:".$_POST['q1'];
    $log_str.="; q1s:".$_POST['q1s'];
    $log_str.="; q1o:".$_POST['q1o'];

    $log_str.="; q2:".$_POST['q2'];
    $log_str.="; q2s:".$_POST['q2s'];
    $log_str.="; q2o:".$_POST['q2o'];

    $log_str.="; q3:".$_POST['q3'];
    $log_str.="; q3s:".$_POST['q3s'];
    $log_str.="; q3o:".$_POST['q3o'];

    $log_str.="; q4:".$_POST['q4'];
    $log_str.="; q4s:".$_POST['q4s'];
    $log_str.="; q4o:".$_POST['q4o'];

    $log_str.="; q5:".$_POST['q5'];
    $log_str.="; q5s:".$_POST['q5s'];
    $log_str.="; q5o:".$_POST['q5o'];

    $log_str.="; q6:".$_POST['q6'];
    $log_str.="; q6s:".$_POST['q6s'];
    $log_str.="; q6o:".$_POST['q6o'];

    $log_str.="; q7:".$_POST['q7'];
    $log_str.="; q7s:".$_POST['q7s'];
    $log_str.="; q7o:".$_POST['q7o'];

    $log_str.="; q8:".$_POST['q8'];
    $log_str.="; q8s:".$_POST['q8s'];
    $log_str.="; q8o:".$_POST['q8o'];

    $log_str.="; q9:".$_POST['q9'];
    $log_str.="; q9s:".$_POST['q9s'];
    $log_str.="; q9o:".$_POST['q9o'];

    $log_str.="; q10:".$_POST['q10'];
    $log_str.="; q10s:".$_POST['q10s'];
    $log_str.="; q10o:".$_POST['q10o'];
    
    $log_str.="; q11:".$_POST['q11'];
    $log_str.="; q11s:".$_POST['q11s'];
    $log_str.="; q11o:".$_POST['q11o'];
    
    $log_str.="; q12:".$_POST['q12'];
    $log_str.="; q12s:".$_POST['q12s'];
    $log_str.="; q12o:".$_POST['q12o'];
    $log_str.="; username:".$_SESSION["user"];
    $log_str.="; offset:".($offset-1);
    $log_str.="; $verb_prev \n";

    if( $_POST['submit'] )
    {
        logger($log_str);
    }
    print '</pre>';

function echo_common($name,$username)
{
    echo <<<EOF
<table border="0" width="1400"   style="font-size:10px" >
<tr>
  <td><input type="radio" name="$name" value="Joy">内心喜悦</td>
  <td><input type="radio" name="$name" value="Happyfor">为之欣喜</td>
  <td><input type="radio" name="$name" value="Hope">期待</td>
  <td><input type="radio" name="$name" value="Satisfaction">自我满足</td>
  <td><input type="radio" name="$name" value="Relief">解脱</td>
  <td><input type="radio" name="$name" value="Suprise">惊讶</td>

  <td><input type="radio" name="$name" value="Admiration">钦佩</td>
  <td><input type="radio" name="$name" value="Pride">自豪</td>
  <td><input type="radio" name="$name" value="Gratification">为之满意</td>
  <td><input type="radio" name="$name" value="Gratitude">感激</td>
  <td><input type="radio" name="$name" value="Gloating">幸灾乐祸</td>
  <td><input type="radio" name="$name" value="Sympathy">同情</td>
  <td><input type="radio" name="$name" value="Anxiety">焦虑</td>
</tr>


<tr>
  <td><input type="radio" name="$name" value="Distress">悲苦</td>
  <td><input type="radio" name="$name" value="Contempt">鄙视</td>
  <td><input type="radio" name="$name" value="Pity">可惜</td>
  <td><input type="radio" name="$name" value="Resentment">怨恨</td>
  <td><input type="radio" name="$name" value="Fear">恐惧（即将到来）</td>
  <td><input type="radio" name="$name" value="Fearsconfirmed">害怕（已经发生）</td>
  <td><input type="radio" name="$name" value="Disappointment">失望</td>
  <td><input type="radio" name="$name" value="Shame">羞耻</td>
  <td><input type="radio" name="$name" value="Reproach">责备</td>
  <td><input type="radio" name="$name" value="Remorse">懊悔</td>
  <td><input type="radio" name="$name" value="Anger">愤怒</td>
  <td><input type="radio" name="$name" value="NJ">皆有可能，无法判断</td>
  <td><input type="radio" name="$name" value="NA">此题无效，无情感</td>
</tr>

EOF;

}
function echo_template_a1($name, $username )
{
    echo_common($name );
    echo <<<EOF
<tr>
  <td colspan="5"><input type="radio" name="${name}s" value="sense">情感与我对主语的喜爱程度相关度高</td>
  <td colspan="6"><input type="radio" name="${name}o" value="sense">情感与我对宾语的讨厌程度相关度高</td>
</tr>
</table>
EOF;
}

function echo_template_a2($name, $username )
{
    echo_common($name);
    echo <<<EOF

<tr>
  <td colspan="5"><input type="radio" name="q2s" value="sense">情感与我对主语的讨厌程度相关度高</td>
  <td colspan="6"><input type="radio" name="q2o" value="sense">情感与我对宾语的喜爱程度相关度高</td>
</tr>

</table>
EOF;
}

function echo_template_a3($name, $username )
{
    echo_common($name);
    echo <<<EOF

<tr>
  <td colspan="5"><input type="radio" name="q3o" value="sense">情感与我对宾语的喜爱程度相关度高</td>
</tr>


</table>
EOF;
}

function echo_template_a4($name, $username )
{
    echo_common($name);
    echo <<<EOF
<tr>
  <td colspan="5"><input type="radio" name="q4o" value="sense">情感与我对宾语的讨厌程度相关度高</td>
</tr>

</table>
EOF;
}


function echo_template_a5($name, $username )
{
    echo_common($name);
    echo <<<EOF

<tr>
  <td colspan="5"><input type="radio" name="q5s" value="sense">情感与我对主语的喜爱程度相关度高</td>
</tr>

</table>
EOF;
}


function echo_template_a6($name, $username )
{
    echo_common($name);
    echo <<<EOF
<tr>
  <td colspan="5"><input type="radio" name="q6s" value="sense">情感与我对主语的讨厌程度相关度高</td>
</tr>

</table>
EOF;
}


function echo_template_a7($name, $username )
{
    echo_common($name);
    echo <<<EOF
<tr>
  <td colspan="5"><input type="radio" name="q7s" value="sense">情感与我对主语的喜爱程度相关度高</td>
  <td colspan="5"><input type="radio" name="q7o" value="sense">情感与我对宾语的喜爱程度相关度高</td>
</tr>

</table>
EOF;
}


function echo_template_a8($name, $username )
{
    echo_common($name);
    echo <<<EOF
<tr>
  <td colspan="5"><input type="radio" name="q8s" value="sense">情感与我对主语的讨厌程度相关度高</td>
  <td colspan="5"><input type="radio" name="q8o" value="sense">情感与我对宾语的讨厌程度相关度高</td>
</tr>


</table>
EOF;
}


function echo_template_a9($name, $username )
{
    echo_common($name);
    echo <<<EOF
</table>
EOF;
}

function echo_template10($name)
{
    echo_common($name);
    echo <<<EOF
</table>

EOF;

}

function echo_template11($name)
{

    echo_common($name);
    echo <<<EOF
<tr>
  <td colspan="11"><input type="radio" name="${name}s" value="sense">情感与我对主语的喜爱程度相关度高</td>
</tr>
</table>

EOF;

}


function echo_template12($name)
{
    echo_common($name);

echo <<<EOF
<tr>
  <td colspan="10"><input type="radio" name="${name}s" value="sense">情感与我对主语的讨厌程度相关度高</td>
</tr>
</table>

EOF;

}

?>

<h3>谓词情感标注: <?php echo  $verb ;?>
	<select data-placeholder="Select ..." id="select" onchange="change();">
			<option value=""></option>
			<option value="0">此谓语通常不包含宾语</option>
			<option value="1">此谓语通常包含宾语</option>
	</select>

    <?php  $next=$_SESSION['offset'];
        $next=$next+1;
    ?>
	<a href="emo_query.php?offset=<?php echo $next;?> ">   下一个 </a>
</h3>


<form name="quiz" id='has_obj' style="display: none;" action="emo_query.php?offset=<?php echo $next;?>"  method="post"   onSubmit="return check_add_quiz()"  >

<table> 
<tr>
<td>用户名:</td> <td><input name="user" type="text" maxlength="15" value="<?php  echo  $_SESSION['user'] ?> "   style="width"></td>
</tr>
</table>


1. 我喜爱的 <?php echo  $verb ;?> 我讨厌的
    <?php echo_template_a1("q1"); ?> 
<p>

2. 我讨厌的 <?php echo  $verb ;?> 我喜爱的
    <?php echo_template_a2("q2"); ?> 
<p>


3. 我 <?php echo  $verb ;?> 我喜爱的
    <?php echo_template_a3("q3"); ?> 
<p>


4. 我 <?php echo  $verb ;?> 我讨厌的

    <?php echo_template_a4("q4"); ?> 
<p>

5. 我喜欢的 <?php echo  $verb ;?> 我
    <?php echo_template_a5("q5"); ?> 
<p>

6. 我讨厌的 <?php echo  $verb ;?> 我

    <?php echo_template_a6("q6"); ?> 
<p>

7. 我喜欢的 <?php echo  $verb ;?> 我喜欢的
    <?php echo_template_a7("q7"); ?> 
<p>

8. 我讨厌的 <?php echo  $verb ;?> 我讨厌的

    <?php echo_template_a8("q8"); ?> 
<p>


9. 我 <?php echo  $verb ;?> 我
    <?php echo_template_a9("q9"); ?> 
<p>
    <input type="hidden" name="action" value="<?php echo  $verb ?>">
    <input type="submit" name="submit" value="submit">
</form>

<form name="quiz_no" id='has_no_obj' style="display: none;" action="emo_query.php?offset=<?php echo $next;?>"  method="post"  onSubmit="return check_add_quiz_no()" >



<table> 
<tr>
<td>用户名:</td> <td><input name="user" type="text" maxlength="15" value="<?php  echo  $_SESSION['user'] ?> "   style="width"></td>
</tr>
</table>


1. 我 <?php echo  $verb ;?>
    <?php echo_template10("q10"); ?> 
<p>

2. 我喜欢的 <?php echo  $verb ;?>
    <?php echo_template11("q11"); ?> 
<p>

3. 我讨厌的 <?php echo  $verb ;?> 

    <?php echo_template12("q12"); ?> 
<p>

  <input type="hidden" name="action" value="<?php echo  $verb ?>">
  <input type="submit" name="submit" value="submit">
</form>
<script>
	function change()
	{
		if(document.getElementById("select").value == "1"){
				document.getElementById("has_obj").style.display = "block";
				document.getElementById("has_no_obj").style.display = "none";
		}else{
				document.getElementById("has_obj").style.display = "none";
				document.getElementById("has_no_obj").style.display = "block";
		}
	}
</script>
</body>
</html>


