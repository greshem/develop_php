<?php
	class InfoRecord
	{
		var $name;
		var $email;
		function InfoRecord( $a, $b)
		{
			$name=$a;
			$email=$b;
		}
		
	};
	class companyDB
	{
		var $db=array();
		var $count;
		function companyDB( $file)
		{
			$buffer=file_get_contents($file);
			$lines=split("\n", $buffer);
			$i=0;
			foreach ($lines as  $line)
			{
					
				//print $line."\n";
				$arr=preg_split("/\s+/", $line);
				if(isset($arr[0]) && isset($arr[1]) )
				{
					$this->db[$arr[0]]=$arr;
					$i++;
				}
			}
			$count=$i;
			return $count;
		}
		function add($in_name, $in_email)
		{
			//	
			if(isset($in_name) && isset( $in_email) && ! isset($this->db[$in_name]) )
			{
				#array_push($this->db, array($in_name, $in_email ));
				$this->db[$in_name]=array($in_name, $in_email);
				$this->count++;
				return 1;
			}
			return 0;
		}
		function del($in_name)
		{
			if(isset($this->db[$in_name]))
			{
				$this->db[$in_name]=array();
				return 1;	
			}	
			return 0;
		}
		
		function IsExist($name)
		{
			if(isset($this->db[$name]))
			{
				return 1;	
			}
			else
			{
				return 0;
			}
		}
		
		function ToString()
		{
			$string="";
			foreach ( $this->db as $line)
			{
				if(isset($line[0]) && isset ($line[1]))
				{
					$string.=$line[0];
					$string.="\t\t";
					$string.=$line[1];
					$string.="\n";
				}
			}
			return $string;

		}
		function WriteToFile($file)
		{
			$string= $this->ToString();	
			//echo $string;
			file_put_contents($file, $string);
			return 1;
		}
}
	
	/*$a=new   companyDB("info.list");
	$a->add("wenwen", "wnwen@gmail.com");
	echo ($a->ToString());
	$a->WriteToFile("info.list");*/

?>
