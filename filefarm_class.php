<?php

class phpFileFarm 
{

	var $title;
	var $allow_edit;
	var $show_hidden;
	var $allowed_types;
	var $size_limit;
	var $new_days;
	var $image_types;
	var $date_format;
	var $file_perms;
	var	$dir_perms;
	var $base_dir;
	var $web_dir;
	var $rel_dir;
	var $rel_path;
	var $self;

	function phpFileFarm() {

		// title of your file farm
		$this->title		= "phpFileFarm";

		// files you want to be able to edit in text mode
		// and view with (primitive) syntax highlighting
		$this->allow_edit = array(".txt",".asp",".htm",".html",".cfm",".php3",".php",".phtml",".shtml",".css",".xml",".pl");

		// whether or not to show hidden files (dot filenames)
		$this->show_hidden = FALSE;

		// display directory summaries
		$this->show_summary	= TRUE;

		// convert path names to breadcrumbs?
		$this->breadcrumbs	= TRUE;

		// mimetypes that you want to allow for uploading
		// set this to FALSE to disable file type validation
		// $this->allowed_types = array("text/plain","text/html","application/x-zip-compressed");
		$this->allowed_types = FALSE;

		// list of files/directories to specifically exclude from listing
		$this->excluded	= array(".htaccess","robots.txt","favicon.ico");

		// maximum file size allowed for uploading (in bytes)
		$this->size_limit = "100000000000";

		// number of days a file is considered NEW
		$this->new_days	= 7;

		// files that will display as images on the detail page
		$this->image_types = array(".jpg",".jpeg",".gif",".png",".ico",".bmp",".xbm");

		// how we format dates
		$this->date_format = "m/d/y h:i:s A";

		// default permissions for uploaded files (int)
		$this->file_perms = 0644;

		// default permissions for created directories (int)
		$this->dir_perms  = 0755;

		// full path to base directory (no ending slash)
		$this->base_dir	= "c:\\";

		// relative web path to base directory (no ending slash)
		$this->web_dir	= "\\";

		// username=>password array for authentication
		// set to FALSE to disable security altogether
		 $this->login_auth = FALSE;
		#$this->login_auth	= array("username"	=> "password");

        // Name of the database that's backing us
		// set to FALSE to disable database
		 $this->database = FALSE;
        //$this->database = array(
         //   'type' => 'gdbm',
          //  'file' => '.filefarm.db',
        //);

		/*== SKIN / THEME DEFINITION ========================================*/
		
		$this->siteWidth			= "100%";
		$this->bodyBgColor		= "ffffff";
		$this->bodyTextColor	= "000000";
		$this->bodyLinkColor	= "cc3333";
		$this->bodyVlinkColor	= "990000";
		$this->bodyAlinkColor	= "000000";
		$this->bodyMarginSize	= "5";
		$this->headDiv				= "";
		$this->menubarColor		= "000000";
		$this->siteNameColor	= "ffffff";
		$this->menubarDiv			= "";
		$this->bodyFgColor		= "ffffff";
		$this->formStyle			= "";
		$this->bodyFgDiv			= "000000,1";
		$this->bodyFgToRowDiv	= "000000,1";
		$this->rowColor1			= "eeeeee";
		$this->rowColor2			= "f0f0f0";
		$this->rowLinkColor		= "cc3333";
		$this->rowTextColor		= "000000";
		$this->newFileColor		= "ff0000";
		$this->rowDiv					= "000000,1";
		$this->rowToBodyFgDiv	= "000000,1";
		$this->footDiv				= "000000,1";

		/*== NO NEED TO EDIT PAST THIS POINT ================================*/

		// Set variables according to version of PHP attempt to
		// deal with `register_globals Off'
    	if (!isset($_POST)) {
                global $HTTP_POST_VARS,$POSTACTION;
                $post_vars=$HTTP_POST_VARS;
                $post_action=$POSTACTION;
    	} else {
                $post_vars=$_POST;
                if (array_key_exists("POSTACTION", $post_vars)) {
                    $post_action=$post_vars["POSTACTION"];
                } else {
                    $post_action = NULL;
                }
    	}
    	if (!isset($_GET)) {
                global $HTTP_GET_VARS;
                $get_vars=$HTTP_GET_VARS;
    	} else {
                $get_vars=$_GET;
    	}
    	if (! isset($_FILES)) {
                global $HTTP_POST_FILES;
                $post_files=$HTTP_POST_FILES;
    	} else {
                $post_files=$_FILES;
    	}
    	if (! isset($_SERVER["PHP_SELF"])) {
                global $PHP_SELF;
                $server_php_self=$PHP_SELF;
                //$server_php_self=$HTTP_SERVER_VARS["PHP_SELF"];
    	} else {
                $server_php_self=$_SERVER["PHP_SELF"];
    	}
    	if (! isset($_SERVER["PHP_AUTH_USER"])) {
                global $PHP_AUTH_USER;
                $auth_user=$PHP_AUTH_USER;
    	} else {
                $auth_user=$_SERVER["PHP_AUTH_USER"];
    	}
    	if (! isset($_SERVER["PHP_AUTH_PW"])) {
                global $PHP_AUTH_PW;
                $auth_pw=$PHP_AUTH_PW;
    	} else {
                $auth_pw=$_SERVER["PHP_AUTH_PW"];
    	}
    	$script_filename = '';
    	if (! isset($_SERVER["HTTP_USER_AGENT"])) {
                global $HTTP_USER_AGENT,$HTTP_SERVER_VARS;
                $user_agent=$HTTP_USER_AGENT;
                $script_filename=$HTTP_SERVER_VARS["SCRIPT_FILENAME"];
    	} else {
                $user_agent=$_SERVER["HTTP_USER_AGENT"];
                $script_filename=$_SERVER["SCRIPT_FILENAME"];
    	}

		$this->version	= "0.2.4";
		$this->self		= $server_php_self;
        if (array_key_exists('F', $get_vars)) {
    		$this->file			= $get_vars["F"];
        } else {
            $this->file = null;
        }

		// check for authentication first thing if enabled
		if ($this->login_auth) {
			if (!empty($auth_user) && !empty($auth_pw)) { 
				if ($this->login_auth[$auth_user] != $auth_pw) {
					$this->authenticate(); 
				}
			} else { 
				$this->authenticate(); 
			}
		}

		// check for skin.txt and load if it exists
		$this->load_skin();

		// determine working directory
		if (!array_key_exists('DIR', $post_vars)) {
            $post_vars["DIR"] = '';
        }
        if ($post_vars["DIR"]) {
			$this->rel_dir = $post_vars["DIR"];
		} elseif (array_key_exists('D', $get_vars) && $get_vars["D"]) {
    	    $this->rel_dir = urldecode($get_vars["D"]);
	    } else {
			$this->rel_dir = "";
		}

		if ($this->rel_dir=="/") {
			$this->rel_dir = "";
		}

		$this->rel_path = $this->base_dir . $this->rel_dir;

	  if (@strstr($this->rel_dir,"..")) {
			$this->Error("No up-folders allowed"); // Important
		} elseif (!is_dir($this->rel_path)) {
			$this->Error("Folder not found -->",$this->rel_dir);
		}

		switch ($post_action) {
			case "UPLOAD" :
				if (!is_writable($this->rel_path)) {
					$this->Error("Could not write to folder",$this->rel_path);
				}
				$file = $post_files['FN']['name'];
				$type = $post_files['FN']['type'];
				$size = $post_files['FN']['size'];
				$temp = $post_files['FN']['tmp_name'];

				if (is_uploaded_file($temp)) {
					if ($size <= $this->size_limit) {
						if ($this->allowed_types==FALSE || in_array($type,$this->allowed_types)) {
							$target = $this->rel_path . "/" . $file;
							if (move_uploaded_file($temp,$target)) {
								chmod($target,$this->file_perms);
								// success
							} else {
								$this->Error("Could not move uploaded file",$target);
							}
						} else {
							$this->Error("File type not allowed",$type);
						}
					} else {
						$this->Error("Max file size exceeded","$size exceeds $this->size_limit");
					}
				}
				clearstatcache() ;
			break;

			case "SAVE" :
				if (@strstr($post_vars["RELPATH"],"..")) {
					$this->Error("No up-folders allowed"); // Important
				}
				$path = $this->base_dir . $post_vars["RELPATH"];
				$writable = is_writable($path);
				$legaldir = is_writable(dirname($path));
				$exists   = (file_exists($path)) ? 1 : 0;
				// possibly check for legal extension here as well
			 	if (!($writable || (!$exists && $legaldir))) {
					$this->Error("Could not write to file",$path);
				}
				$fh = fopen($path,"w");
				fwrite($fh,stripslashes($post_vars["FILEDATA"]));
				fclose($fh);
				chmod($path,$this->file_perms);
				clearstatcache();
			break ;
	
			case "CREATE" :
				if (!is_writable($this->rel_path)) {
					$this->Error("Could not write to folder",$this->rel_path);
				}
				$file	= $post_vars["FN"];
				$path = $this->rel_path . "/" . $file;
				// check for invalid (excluded) file/dir names
				if ($file && strstr(join(" ",$this->excluded),$file)) {
					$this->Error("Could not write file",$file . " is a reserved name");
				}
				switch ($post_vars["T"]) {
					case "D" :  // create a directory
					  if (!@mkdir($path,$this->dir_perms) || empty($file)) {
					    $this->Error("Could not create folder or folder already exists",$path);
						}
				  break ;
					case "F" :  // create a new file
					  if (file_exists($path) || !is_writable(dirname($path))) {
					    $this->Error("Could not write to file or file already exists", $path) ;
						}
					  $tstr = $this->self . "?op=details&D=" . $this->rel_dir . "&F=" . $file;
					  header("Location: " . $tstr);
					  exit;
					break;
				}
			break;

			case "DELETE" :  
				if ($post_vars["CONFIRM"] != "on") break;

				$tstr  = "Attempt to delete non-existing object or ";
				$tstr .= "insufficient privileges: ";
	
				$file = $post_vars["FN"];
				if (!empty($file)) {  // delete file
				  $path =  $this->rel_path . "/" . $file;
			  	if (!@unlink($path)) {
			  	  $this->Error("Could not remove file", $tstr . $path);
						exit;
			  	}
				} else {  // delete directory
				  if (!@rmdir($this->rel_path)) {
				    $this->Error("Could not remove folder", $tstr . $this->rel_path);
				  } else {
				    $this->rel_path = dirname($this->rel_path);  // move up
						$this->rel_dir	= dirname($this->rel_dir);
				  }
				}
			break;

            case "DESCRIBE":
                // User described a file
		        $path	= $this->rel_dir . "/" .  $post_vars["FN"];;
                
                $this->setDescFile($path, $post_vars['DESCRIPTION']);
				clearstatcache();

            break;    
	
			default:
				// user hit "CANCEL" or undefined action
			break;
			}


		// redirect to directory view if posted
		if (!empty($post_action)) { 
			$tstr = $this->self . "?D=" . urlencode($this->rel_dir);
			header("location:" . $tstr);
			exit;
	 	}
	

		// determine operation if passed
        if (isset($get_vars["op"])) {
            switch ($get_vars["op"]) {
                case "details":
                    $this->DetailPage();
                exit;
                case "view":
                    $this->DisplayCode();
                exit;
                case "download":
                    $this->Download();
                exit;
            }
        }
	
		// default: display directory $rel_path
		$this->Navigate() ;	
	}


	function head($title,$text="") {
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
	<html>
	<head>
	 <title><?=$title?></title>
	 <meta name="robots" content="noindex">
	 <meta http-equiv="expires" content="0">
	 <meta http-equiv="Pragma" content="no-cache">
	 <style>
		BODY,TD,P,H1,H2,H3,H4,FORM { font-family:Helvetica,Arial,sans-serif; }
		.BLK { color:black; }
		.NEW { color:<?=$this->newFileColor?>; }
		.TOP { color:<?=$this->bodyTextColor?>; font-size:10pt; font-weight: bold;}
		.INV { color:<?=$this->siteNameColor?>; background-color:<?=$this->menubarColor?>; font-size:14pt; font-weight: bold;}
		.ROW1 { background-color:#<?=$this->rowColor1?>; color:<?=$this->rowTextColor?>;}
		.ROW2 { background-color:#<?=$this->rowColor2?>; color:<?=$this->rowTextColor?>;}
		.BAR { background-color:#<?=$this->bodyFgColor?>; }
		.BOT { color:<?=$this->bodyTextColor?>; font-size:11px; text-decoration: none;}
		PRE { color:<?=$this->rowTextColor?>; font-family:Lucida Console,Courier New,Courier,sans-serif; }
		EM { color:<?=$this->newFileColor?>; font-style:normal; }
		.REM { color:silver; }
		.XML { color:navy; background-color:yellow; }
	 </style>
	</head>
	<body 	bgcolor="#<?=$this->bodyBgColor?>" 
					link="#<?=$this->rowLinkColor?>" 
					vlink="#<?=$this->bodyVlinkColor?>" 
					alink="#<?=$this->bodyAlinkColor?>" 
					text="#<?=$this->bodyTextColor?>" 
					topmargin="<?=$this->bodyMarginSize?>"
					leftmargin="<?=$this->bodyMarginSize?>"
					marginheight="<?=$this->bodyMarginSize?>"
					marginwidth="<?=$this->bodyMarginSize?>">
	<?=$this->colorbars($this->headDiv)?>
	<table border=0 cellspacing=0 cellpadding=2 width="<?=$this->siteWidth?>">
		<tr><td class="INV"><?=$this->icon("box",$title)?> <?=$title?></td></tr>
	</table>
	<?=$this->colorbars($this->menubarDiv)?>

	<table border=0 cellspacing=0 cellpadding=2 width="<?=$this->siteWidth?>">
		<tr><td bgcolor="<?=$this->bodyFgColor?>">
	<br><p>
	<?=$text?>
	</p>
	<?
	}
	
	function foot() {
		print "</td></tr></table>\n";
		$this->colorbars($this->footDiv);
		print "<p class=\"BOT\" align=\"right\">\n";
		print $this->title . "<br><a class=\"BOT\" href=\"http://greenhell.com/filefarm\">phpFileFarm " . $this->version . "</a>\n";
		print "</p>\n";
		print "</body></html>\n";
	}
	
	
	function DetailPage() {
		
		$path  = $this->rel_path . "/" . $this->file;
		$relpath = $this->rel_dir . "/" . $this->file;

		$exists   = file_exists($path);
		$ext      = strtolower(strrchr($path,".")) ;
		$editable = ($ext=="" || strstr(join(" ",$this->allow_edit),$ext)) ;
		$writable = is_writable($path) ;
	
		if (!$editable && !$exists) {
			$this->Error("Creation unsupported for file type",$path) ;
		}
		if (!$exists && !$writeable) {
			$this->Error("Creation denied",$path) ;
		}
	
		$text  = "Use this page to view, modify or " ;
		$text .= "delete a single document on this site" ;
		$this->head("File Details", $text) ;

		?>
		<table cellpadding=2 cellspacing=1 border=0 width="100%">
		<tr><td><?=$this->colorbars($this->bodyFgToRowDiv);?></td></tr>
		<tr><td class="ROW2">
		<?

		echo "<br><h3>" . $this->rel_dir . "/" . $this->file . "</h3>";
	
		if ($exists) {  // get file info
		  $fsize = filesize($path);
		  $fmodified = date($this->date_format, filemtime($path));
		  $faccessed = date($this->date_format, fileatime($path));
			$owner = posix_getpwuid(fileowner($path));
			$group = posix_getgrgid(filegroup($path));
          echo "<form method='POST' action='" . $this->self . "'>";
		  echo "<pre>    file size: " . $this->fixsize($fsize) . " (" . $fsize . " bytes)<br>";
		  echo "last modified: <b>" . $fmodified . "</b><br>";
		  echo "last accessed: <b>" . $faccessed . "</b><br>";
		  echo "        owner: <b>" . $owner["name"] . " (" . $owner["gecos"] . ")" . "</b><br>";
		  echo "        group: <b>" . $group["name"] . "</b><br>";
		  echo "  permissions: <b>" . $this->display_perms($path) . "</b>" ;
	      
          echo "  description: ";
	      echo "<input type='HIDDEN' name='DIR' value='".$this->rel_dir."'>";
	      echo "<input type='HIDDEN' name='FN' value='".$this->file."'>";
	      echo "<input type='HIDDEN' name='POSTACTION' value='DESCRIBE'>";
          echo "<input type='text' name='DESCRIPTION' size='40' value='" .  $this->getDescFile($this->rel_dir . '/' . $this->file) . "'><input type='SUBMIT' value='Save'><br>";

		  echo "</pre></form>" ;
			clearstatcache();
		}

		?>
		</td></tr>
		<tr><td><?=$this->colorbars($this->rowToBodyFgDiv);?></td></tr>
		</table>
		<?
	
		if ($editable && ($writable || !$exists)) { 
			$fh = fopen($path,"a+");
			rewind($fh);
			$fstr = fread($fh,filesize($path));
			fclose($fh);
			$fstr = htmlspecialchars($fstr);
	?>
	
	<form action="<?=$this->self;?>" method="POST">
	<b>DOCUMENT CONTENTS</b>
	<br>
	<textarea name="FILEDATA" rows=15 cols=78 wrap=OFF><?=$fstr;?></textarea>
	<input type="HIDDEN" name="DIR" value="<?=$this->rel_dir;?>">
	<input type="HIDDEN" name="FN" value="<?=$this->file;?>">
	<input type="HIDDEN" name="POSTACTION" value="SAVE">
	<br>Save As: <input type="TEXT" size=48 maxlength=255 name="RELPATH" value="<?=$relpath;?>">
	<input type="RESET" value="Reset">
	<input type="SUBMIT" value="Save">
	</form>
	
	<?
		} elseif (strstr(join(" ",$this->image_types),$ext)) {  
		  $info  = getimagesize($this->base_dir . $relpath) ;
			$dim	= $info[0] ." x ". $info[1];
		  $tstr  = "<img src=\"". $this->web_dir . $relpath . "\" border=0 " ;
		  $tstr .= $info[3] . " alt=\"" . $this->file . " (" . $dim . ")\">" ;
		  echo $tstr;
		}
	?>
	
	<form action="<?=$this->self;?>" method="POST">
	<input type="HIDDEN" name="DIR" value="<?=$this->rel_dir;?>">
	<input type="HIDDEN" name="FN" value="<?=$this->file;?>">
	<input type="SUBMIT" name="POSTACTION" value="Cancel"><br>
	
	<?
		if ($exists && $writable) {
	?>
	
	<?=$this->colorbars($this->bodyFgDiv)?>
	<b>DELETE FILE "<?=$this->file;?>"? </b>
	<input type="CHECKBOX" name="CONFIRM">
	<input type="SUBMIT" name="POSTACTION" value="DELETE">
	
	<?
		}
		echo "</form>";
		$this->foot();
	}

	
	function DisplayCode() {
	
		$path = $this->rel_path . "/" . $this->file;
	
		if (!file_exists($path)) {
			$this->Error("File not found",$path) ;
		}
	
		$this->head("Viewing file: " . $this->rel_dir."/".$this->file,"");
	
		// show_source($path);

		$tstr = join("",file($path)) ;
		$tstr = htmlspecialchars($tstr) ;
	
		// Tabs
		$tstr = str_replace(chr(9),"   ",$tstr) ;  
	
		// ASP tags & XML/PHP tags
		$aspbeg = "<span class=\"XML\">&lt;%</span><span class=\"BLK\">" ;
		$aspend = "</span><span class=\"XML\">%&gt;</span>" ;
		$tstr = str_replace("&lt;%",$aspbeg,$tstr) ;
		$tstr = str_replace("%&gt;",$aspend,$tstr) ; 	
	
		$xmlbeg = "<span class=\"XML\">&lt;?</span><span class=\"BLK\">" ;
		$xmlend = "</span><span class=\"XML\">?&gt;</span>" ;
		$tstr = str_replace("&lt;?",$xmlbeg,$tstr) ;
		$tstr = str_replace("?&gt;",$xmlend,$tstr) ; 	
	
		// C style comment
		$tstr = str_replace("/*","<span class=\"REM\">/*",$tstr) ; 	
		$tstr = str_replace("*/","*/</span>",$tstr) ; 			
	
		// HTML comments
		$tstr = str_replace("&lt;!--","<i class=\"RED\">&lt;!--",$tstr) ;  
		$tstr = str_replace("--&gt;","--&gt;</i>",$tstr) ;  
	

		$this->colorbars($this->bodyFgToRowDiv);
		?>
		<table cellspacing=1 cellpadding=0 border=0 width="100%">
		<tr><td class="ROW2"><br>
		<?
		
		echo "<pre>" ;	
	
		$tstr = split("\n",$tstr) ;
		for ($i = 0 ; $i < sizeof($tstr) ; ++$i) {
			// add line numbers
			echo "<br><EM>" ;
			echo substr(("000" . ($i+1)), -4) . ":</EM> " ;
			$line = $tstr[$i] ;
			// C++ style comments
			$pos = strpos($line,"//") ;
			// exceptions: two slashes aren't a script comment
			if (strstr($line,"//") &&
			    ! ($pos>0 && substr($line,$pos-1,1)==":") &&
			    ! (substr($line,$pos,8) == "//--&gt;") &&
			    ! (substr($line,$pos,9) == "// --&gt;")) {
			 $beg = substr($line,0,strpos($line,"//")) ;
			 $end = strstr($line,"//") ;
			 $line = $beg."<span class=\"REM\">".$end."</span>";
			}
			// shell & asp style comments
			$first = substr(ltrim($line),0,1) ;
			if ($first == "#" || $first == "'") {
			 $line = "<span class=\"REM\">".$line."</span>";
			}
			print($line) ;
		} // next i
	
		echo "</pre>";
		echo "</td></tr></table>\n";
		$this->colorbars($this->rowToBodyFgDiv);
?>
	<form method="POST" action="<?=$this->self?>">
	<input type="HIDDEN" name="DIR" value="<?=$this->rel_dir?>"><br>
	<input type="SUBMIT" name="POSTACTION" value="Cancel">
	</form>
<?	
		$this->foot() ;
	
	}

	function Download() {
		$path	= $this->base_dir . $this->rel_dir . "/" . $this->file;
		//SetCookie("Download",yep, time()+36000000, "/", "www.domain.com", 0); 
		$size = filesize($path);
        header("Content-Type: " . exec("file -ib " . $path)); 
		header("Content-Length: $size"); 
		header("Content-Disposition: attachment; filename=$this->file"); 
		header("Content-Transfer-Encoding: binary"); 
		$fh = fopen($path, "r"); 
		fpassthru($fh); 
	}

	
	function icon($txt,$alt="") {
		switch (strtolower($txt)) {
		case ".bmp" :
		case ".gif" :
		case ".jpg" :
		case ".jpeg":
		case ".tif" :
		case ".tiff": 
			$d = "image2.gif" ;
			break ;
		case ".doc" :
			$d = "layout.gif" ;
			break ;
		case ".exe" :
		case ".com"	:
		case ".bin"	:
		case ".bat" :
			$d = "binary.gif" ;
			break ;
		case ".hqx" :
			$d = "binhex.gif" ;
			break ;
		case ".bas" :
		case ".c"   :
		case ".cc"  :
		case ".src" :
			$d = "c.gif" ;
			break ;
		case "file" :
			$d = "generic.gif" ;
			break ;
		case "dir" :
			$d = "dir.gif" ;
			break ;
		case "opendir" :
			$d = "folder.open.gif" ;
			break ;
		case ".phps" :
		case ".php3" :
		case ".htm" :
		case ".html":
		case ".asa" :
		case ".asp" :
		case ".cfm" :
		case ".php3":
		case ".php" :
		case ".phtml" :
		case ".shtml" :
			$d = "world1.gif";
			break;
		case ".pl"	:
		case ".py"	:
			$d = "p.gif";
			break;
		case ".wrl"	:
		case ".vrml":
		case ".vrm"	:
		case ".iv"	:
			$d = "world2.gif";
			break;
		case ".ps"	:
		case ".ai"	:
		case ".eps"	:
			$d	= "a.gif";
			break;
		case ".pdf" :
			$d = "pdf.gif" ;
			break;
		case ".txt" :
		case ".ini" :
			$d = "text.gif" ;
			break;
		case ".xls" :
			$d = "box2.gif" ;
			break ;
		case ".dvi"	:
			$d = "dvi.gif";
			break;
		case ".mpg" :
		case ".mpeg":
			$d = "movie.gif";
			break;
		case ".aiff":
		case ".wav"	:
		case ".it"	:
		case ".mp3" :
			$d = "sound2.gif";
			break;
		case ".conf":
		case ".cfg":
		case ".scr":
		case ".sh":
		case ".shar":
		case ".csh":
		case ".ksh":
		case ".tcl":
			$d = "script.gif";
			break;
		case ".tar" :
		case ".zip" :
		case ".arc" :
		case ".sit" :
		case ".gz"  :
		case ".tgz" :
		case ".Z"   :
			$d = "compressed.gif" ;
			break ;
		case "view" :
			$d = "index.gif" ;
			break ;
		case "box"	:
			$d = "box1.gif";
			break;
		case "up" :
			$d = "back.gif" ;
			break ;
		case "blank" : 
			$d = "blank.gif" ;
			break ;
		default :
			$d = "unknown.gif" ;
		}
	
		return "<img src=\"/icons/" . $d . "\" alt=\"" . $alt . "\" border=0>" ;
	}
	
	
	
	function Navigate() {
		if (!is_dir($this->rel_path)) {
			$this->Error("Folder not found",$this->rel_path);
		}
	
		if (!($dir = @opendir($this->rel_path))) {
			$this->Error("Could not read folder",$this->rel_path) ;
		}
	
		$dirList = array();
		$hiddenFiles = array();
		$fileList = array();

		// read directory contents
		while ($item = readdir($dir)) {
			if ($item == ".." || $item == "." ) continue;
			if (strstr(join(" ",$this->excluded),$item)) continue; // excluded
			if (is_dir($this->rel_path . "/" . $item)) {
				// directory
				$dirList[] = $item;
			} elseif (is_file($this->rel_path . "/" . $item)) {
				// file
				if (!$this->show_hidden && substr($item,0,1)==".") {
					// hidden file, do nothing
					$hiddenFiles[] = $item;
				} else {
					$fileList[] = $item;
				}
			} else {
			  // unknown
			  // $this->Error("Unknown file type", $text . $this->rel_path . "/" . $item) ;
			}
		}
		closedir($dir) ; 
		$emptyDir = !(sizeof($dirList) || sizeof($fileList) || sizeof($hiddenFiles));
	
		// start navigation page
		$text  = "Use this page to view, add, delete or modify files." ;
	
		$this->head($this->title,$text) ;
	
		echo "<table border=0 cellpadding=1 cellspacing=1 width=\"" . $this->siteWidth . "\">" ;
	

		// path location bar
		if ($this->base_dir != $this->rel_path) {
			$parent = dirname($this->rel_dir);
	?>
	<tr><td colspan=6><?=$this->colorbars($this->bodyFgToRowDiv);?></td></tr>

	<tr>
	<td align=center class="ROW1"><?=$this->icon("opendir",$this->rel_dir)?></td>
	<td class="ROW1">
		<?
        echo "<form method='POST' action='" . $this->self . "'>";
		if ($this->breadcrumbs) {
			echo $this->path2bc($this->rel_dir);
		} else {
			echo "<a href=\"" . $this->self . "?D=" . urlencode($parent) . "\">" . $this->rel_dir . "</a>";
		}
        ?>
    </td>
    <td colspan=5 class="ROW1">    
        <?
        echo "<input type='HIDDEN' name='DIR' value='".$this->rel_dir."'>";
        echo "<input type='HIDDEN' name='FN' value=''>";
        echo "<input type='HIDDEN' name='POSTACTION' value='DESCRIBE'>";
        echo "<input type='text' name='DESCRIPTION' size='40' value='" .  $this->getDescFile($this->rel_dir . '/') . "'><input type='SUBMIT' value='Save'><br>";
        echo "</form>";
		?>
	</td>
	</tr>

	<tr><td colspan=6><?=$this->colorbars($this->rowToBodyFgDiv);?></td></tr>


	<?
		} // end parent bar
	
		$BG = array("ROW1","ROW2");

		// output subdirs
		if (sizeof($dirList)>0) {
			sort($dirList);
	?>

	<tr><td colspan=6 cLass="TOP">FOLDERS</td></tr>

	<tr><td colspan=6><?=$this->colorbars($this->bodyFgToRowDiv);?></td></tr>
	<?
			$i=0;
			while (list($key,$dir) = each($dirList)) {
				$i++;
				$bgs	= $BG[$i%2];
				$tstr = "<a href=\"" . $this->self . "?D=" ; 
				$tstr .= urlencode($this->rel_dir . "/" . $dir);
				$tstr .= "\">" . $dir . "/</a>" ;
                
	?>
	<tr>
	<td class="<?=$bgs?>" align=center><a href="<?=$this->self?>?D=<?=urlencode($this->rel_dir . "/" . $dir)?>"><?=$this->icon("dir",$dir . "/")?></a></td>
	<td nowrap class="<?=$bgs?>"><a href="<?=$this->self?>?D=<?=urlencode($this->rel_dir . "/" . $dir)?>"><?=$dir?>/</a></td>
    <td colspan='4' class="<?=$bgs?>"><?=$this->getDescFile($this->rel_dir . '/' . $dir .  '/')?></td>
	</tr>
	<?
			}  // iterate over dirs
	?>
	<tr><td colspan=6><?=$this->colorbars($this->rowToBodyFgDiv);?></td></tr>
	<?
		}  // end if no dirs
	?>


	<?
		if (sizeof($fileList)>0) {
	?>
	<tr><td class="TOP" colspan="2" nowrap>FILENAME</td>
	<td>&nbsp;</td>
	<td class="TOP">LAST UPDATE</td>
	<td class="TOP">DESCRIPTION</td>
	<td class="TOP" align=right>FILE SIZE</td>
	</tr>
	<tr><td colspan=6><?=$this->colorbars($this->bodyFgToRowDiv);?></td></tr>
	<?
			$i	= 0;
			$tot = 0;
		  sort($fileList);
			$BG	= array("ROW1","ROW2");
		  while (list($key,$file) = each($fileList)) {	
				$i++;
				$bgs	= $BG[$i%2];
		    $path = $this->rel_path . "/" . $file;
		    $mod  = filemtime($path);
		    $sz   = filesize($path);
            $desc = $this->getDescFile($this->rel_dir . '/' . $file);
				$tot += $sz; // add size to summary total
		    $a = $b = "" ;
	
		    if (($mod + $this->new_days*86400) > time()) {
		      $a  = " <span class=\"RED\" title=\"Newer than $this->new_days days\">*</span>" ;
		    }
	
		    $tstr = $this->self . "?op=download&D=" . urlencode($this->rel_dir) . "&F=" . rawurlencode($file);
		    $tstr  = "<a href=\"" . $tstr . "\">" . $file . "</a>" . $a;
	
		    $ext = strtolower(strrchr($file,".")) ;
		    if ( $ext=="" || strstr(join(" ",$this->allow_edit),$ext)) {  
					$b  = "<a href=\"" . $this->self . "?op=view&F=" ;
					$b .= urlencode($file) . "&D=" . urlencode($this->rel_dir) ;
		      $b .= "\" title=\"View File\">" ;
		      $b .= $this->icon("view","View Contents") . "</a>";
		    }
	?>
	
	<tr>
	<td class="<?=$bgs?>" align="center">
	<a href="<?=$this->self?>?op=details&F=<?=urlencode($file)?>&D=<?=urlencode($this->rel_dir)?>" title="View/Edit">
	<?=$this->icon($ext,"File Details")?></a></td>
	<td class="<?=$bgs?>" nowrap><?=$tstr?></td>
	<td class="<?=$bgs?>" align="center"><?=$b?>&nbsp;</td>
	<td class="<?=$bgs?>" nowrap><?=date($this->date_format,$mod)?></td>
	<td class="<?=$bgs?>"><?=$desc?></td>
	<td class="<?=$bgs?>" nowrap align="right"><?=$this->fixsize($sz)?></td></tr>
	<?
	if (isset($filelist) && ($i<sizeof($filelist)-1)) {
	?>
		<tr><td colspan=6><?=$this->colorbars($this->rowDiv);?></td></tr>
	<?
	}
		  }  // iterate over files
	?>
	<tr><td colspan=6><?=$this->colorbars($this->rowToBodyFgDiv);?></td></tr>
	<?
		}  // end if files

	
		if ($emptyDir && dirname($this->rel_path)!=dirname($this->base_dir)) {
	?>
	<form method="POST" action="<?=$this->self?>">
	 <tr><td colspan=6 class="BAR">
	  <input type="HIDDEN" name="DIR" value="<?=$this->rel_dir?>">
	  Delete this empty folder?
	  <input type="CHECKBOX" name="CONFIRM"> 
	  <input type="SUBMIT" name="POSTACTION" value="DELETE">
	 </td></tr>
	</form>
	
	<?
		} elseif (sizeof($hiddenFiles)>0 && !$this->show_hidden) {
			// show number of hidden files if any
			print "<tr><td class=\"ROW1\" colspan=\"6\">Unlisted hidden files: <b>" . sizeof($hiddenFiles) . "</b></td></tr>\n";
		}

		if ($this->show_summary && $tot>0) {
			print "<tr><td colspan=\"5\">&nbsp;</td><td class=\"TOP\" align=\"right\">TOTAL ~ " . $this->fixsize($tot) . "</td></tr>\n";
		}
	?>
	
	<tr><td colspan=6><?=$this->colorbars($this->bodyFgDiv)?></td></tr>

	<tr>
	<td colspan="6">
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr class="BAR">

  <form method="POST" action="<?=$this->self?>">
	 <td>&nbsp;New</td>
	 <td nowrap>
	 <input type="RADIO" name="T" value="D" checked> FOLDER<br>
	 <input type="RADIO" name="T" value="F"> FILE
	 </td>
	 <td nowrap>
	 Name <input type="TEXT" name="FN" size=12>
	 <input type="HIDDEN" name="POSTACTION" value="CREATE">
	 <input type="HIDDEN" name="DIR" value="<?=$this->rel_dir?>">
	 <input type="SUBMIT" value="CREATE">
	 </td>
	</form>

	<form enctype="multipart/form-data" method="POST" action="<?=$this->self?>">
	 <td align=right>
	 <input type="HIDDEN" name="MAX_FILE_SIZE" value="<?=$this->size_limit?>">
	 <input type="HIDDEN" name="DIR" value="<?=$this->rel_dir?>">
	 <input type="HIDDEN" name="POSTACTION" value="UPLOAD">
	 <input size=20 type="FILE" name="FN">
	 </td>
	 <td>
	 <input type="SUBMIT" value="UPLOAD">
	 </td>
	</form>

	 </tr>
	</table>

	</td>
	</tr>
	</table>

	
	<?
		$this->foot() ;
	}
	

	function Error($title,$text="") {
		$this->head("ERROR -- ".$title,$text) ;
		print "<h3>" . $title . "</h3>\n";
		$dir = !is_dir($this->base_dir . $this->rel_dir) ? "/" : $this->rel_dir;
	?>
	<form method="POST" action="<?=$this->self?>">
	<input type="HIDDEN" name="DIR" value="<?=$dir?>"><br>
	<input type="SUBMIT" name="POSTACTION" value="Cancel">
	</form>
	<?
		$this->foot() ;
		exit ;
	}
	
	function display_perms($file) {
		$mode = fileperms($file);
	
		if(($mode & 0xC000) === 0xC000) // Unix domain socket 
			$type = 's'; 
		elseif(($mode & 0x4000) === 0x4000) // Directory 
			$type = 'd'; 
		elseif(($mode & 0xA000) === 0xA000) // Symbolic link 
			$type = 'l'; 
		elseif(($mode & 0x8000) === 0x8000) // Regular file 
			$type = '-'; 
		elseif(($mode & 0x6000) === 0x6000) // Block special file 
			$type = 'b'; 
		elseif(($mode & 0x2000) === 0x2000) // Character special file 
			$type = 'c'; 
		elseif(($mode & 0x1000) === 0x1000) // Named pipe 
			$type = 'p'; 
		else // Unknown 
			$type = '?';
	
		/* Determine Type */
		if($mode & 0x1000) $type='p'; /* FIFO pipe */ 
		else if( $mode & 0x2000 ) $type='c'; /* Character special */ 
		else if( $mode & 0x4000 ) $type='d'; /* Directory */ 
		else if( $mode & 0x6000 ) $type='b'; /* Block special */ 
		else if( $mode & 0x8000 ) $type='-'; /* Regular */ 
		else if( $mode & 0xA000 ) $type='l'; /* Symbolic Link */ 
		else if( $mode & 0xC000 ) $type='s'; /* Socket */ 
		else $type='u'; /* UNKNOWN */ 
	
		/* Determine permissions */ 
		$owner["read"] = ($mode & 00400) ? 'r' : '-'; 
	  $owner["write"] = ($mode & 00200) ? 'w' : '-'; 
	  $owner["execute"] = ($mode & 00100) ? 'x' : '-'; 
	  $group["read"] = ($mode & 00040) ? 'r' : '-'; 
	  $group["write"] = ($mode & 00020) ? 'w' : '-'; 
	  $group["execute"] = ($mode & 00010) ? 'x' : '-'; 
	  $world["read"] = ($mode & 00004) ? 'r' : '-'; 
	  $world["write"] = ($mode & 00002) ? 'w' : '-'; 
	  $world["execute"] = ($mode & 00001) ? 'x' : '-'; 
	
		/* Adjust for SUID, SGID and sticky bit */ 
	  if( $mode & 0x800 ) $owner["execute"] = ($owner["execute"]=='x') ? 's' : 'S'; 
		if( $mode & 0x400 ) $group["execute"] = ($group["execute"]=='x') ? 's' : 'S'; 
		if( $mode & 0x200 ) $world["execute"] = ($world["execute"]=='x') ? 't' : 'T'; 
	
		$ret = sprintf("%1s", $type); 
	  $ret .= sprintf("%1s%1s%1s", $owner["read"], $owner["write"], $owner["execute"]); 
	  $ret .= sprintf("%1s%1s%1s", $group["read"], $group["write"], $group["execute"]); 
	  $ret .= sprintf("%1s%1s%1s\n", $world["read"], $world["write"], $world["execute"]); 
		return $ret;
	} 
	
	function fixsize($size) {
		$j = 0; 
		$ext = array("B","KB","MB","GB","TB"); 
		while ($size >= pow(1024,$j)) ++$j; 
		return round($size / pow(1024,$j-1) * 100) / 100 . " " . $ext[$j-1];
	}

	function path2bc($path) {
		$link = "";
		$ret	= "<a href=\"" . $this->self . "?D=" . urlencode("/") . "\">//</a> ";
		$path = substr($path,1,strlen($path));
		$arr = explode("/",$path);
		for ($i=0;$i<sizeof($arr);$i++) {
			$current = $arr[$i];
			$link .= "/" . $current;
			$ret .= "<a href=\"" . $this->self . "?D=" . urlencode($link) . "\">" . $current . "</a>";
			if ($i < sizeof($arr)-1) $ret .= " / ";
		}
		return $ret;
	}

	function authenticate() { 
		header("WWW-Authenticate: Basic realm=\"$this->title\", stale=FALSE"); 
		header("HTTP/1.0 401 Unauthorized"); 
		$this->Error("Authorization failed","You must login to access $this->title");
		exit; 
	} 


	function load_skin () {
        $script_filename = '';
		$skinfile = dirname($script_filename) . "/skin.txt";
		if (file_exists($skinfile)) {
			$fcontents = file ($skinfile);
			for ($i = 0; $i < count($fcontents); $i++) {
				$row = $fcontents[$i];
				$rowa = explode("\t",$row);
				if (count($rowa) == 2) {
					$keyval = trim($rowa[0]);
					$valval = trim($rowa[1]);
					if ($valval == "true") {$valval = true;}
					elseif ($valval == "false") {$valval = false;}
				}
				$this->$keyval = $valval;
			}
		}
	}

	function colorbars($str) {
		if ($str != "") {
			$arr = explode(";",$str);
			echo "\t<table cellspacing=0 cellpadding=0 border=0 width=\"100%\">\n";
			for ($i = 0; $i < count($arr); $i++) {
				$arr2 = explode(",",$arr[$i]);
				echo "\t<tr bgcolor=\"" . $arr2[0] . "\"><td height=\"" . $arr2[1] . "\">";
				echo "<spacer type=\"block\" height=\"" . $arr2[1] . "\">";
				echo "</td></tr>\n";
				}
			echo "\t</table>\n";
		}
	}

    /** Gets the description of a file */
    function getDescFile($path) {
		if ($this->database === FALSE) return "N/A";

		if (!is_writable($this->database['file'])) {
			$this->Error("Database file '".$this->database['file']."' does not exist or is not writable.");
		}

        if (isset($this->database['_db'])) {
            $db = $this->database['_db'];
        } else {
            $db = dba_open($this->database['file'], 'c', $this->database['type']);
            $this->database['_db'] = $db;
        }
		$result	= dba_fetch($path, $db);
		// dba_close($db);
        return htmlentities($result);
    }

    /** Sets the file description */
    function setDescFile($path,  $desc) {
		if ($this->database === FALSE) return true;

        if (isset($this->database['_db'])) {
            $db = $this->database['_db'];
        } else {
            $db = dba_open($this->database['file'], 'c', $this->database['type']);
            $this->database['_db'] = $db;
        }
        $result = dba_replace($path, $desc, $db);
        dba_close($db);
        unset($this->database['_db']);

        return $result;
    }


}
?>

