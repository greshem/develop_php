<?php
//clone ���� ������= ������Ҫ���� clone 
// 2011_03_17_17:37:36   ������   add by greshem
/**
 * ����ʽ������
 */
class Singleton 
{
 
    /**
     * ��̬��Ʒ���� ����ȫ��ʵ��
     */
    private static  $_instance = NULL;
 
    /**
     * ˽�л�Ĭ�Ϲ��췽������֤����޷�ֱ��ʵ����
     */
    private function __construct() 
	{
		echo "here __construct\n";
    }
 
    /**
     * ��̬�������������������Ψһʵ��
     */
    public static function getInstance() 
	{
        if (is_null(self::$_instance)) 
		{
            self::$_instance = new Singleton();
        }
 
        return self::$_instance;
    }
 
    /**
     * ��ֹ�û���¡ʵ��
     */
    public function __clone()
	{
        die('Clone is not allowed.' . E_USER_ERROR);
    }
 
    /**
     * �����÷���
     */
    public function test() {
        echo 'Singleton Test!';
    }
 
}
 
/**
 * �ͻ���
 */
class Client 
{
	public static function main() 
	{
        $instance = Singleton::getInstance();
        $instance->test();
		
		$b=clone($instance);
    }
}
 
Client::main();
?>
