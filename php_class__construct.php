<?php

class  Book
{
 
    //private  function __construct() 

	public function __construct() 
	{
		echo "here __construct\n";
    }
 
 
    /**
     * ��ֹ�û���¡ʵ��
     */
    //public function __clone()
    private  function __clone()
	{
        die('Clone is not allowed.' . E_USER_ERROR);
    }
 
    public function test() {
        echo 'Singleton Test!';
    }
 
}
 
class Client 
{
	public static function main() 
	{
        $a = new  Book();
        $a->test();
		
		$b=$a;
    }
}
 
Client::main();
?>
