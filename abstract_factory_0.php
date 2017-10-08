<?php
/**
 * ����ģʽ 2010-06-25 sz
 * @author ���� phppan.p#gmail.com  http://www.phppan.com
 * ��ѧ���Ա��http://www.blog-brother.com/��
 * @package design pattern
 */
 
/**
 * ���󹤳���ɫ
 */
interface Creator 
{
    public function factoryMethod();
}
 
/**
 * ���幤����ɫA
 */
class ConcreteCreatorA implements Creator 
{
 
    /**
     * �������� ���ؾ��� ��ƷA
     * @return ConcreteProductA
     */
    public function factoryMethod() 
	{
        return new ConcreteProductA();
    }
}
 
/**
 * ���幤����ɫB
 */
class ConcreteCreatorB implements Creator {
 
    /**
     * �������� ���ؾ��� ��ƷB
     * @return ConcreteProductB
     */
    public function factoryMethod() {
        return new ConcreteProductB();
    }
}
 
/**
 * �����Ʒ��ɫ
 */
interface Product {
    public function operation();                                                                                    
}
 
/**
 * �����Ʒ��ɫA
 */
class ConcreteProductA implements Product {
 
    /**
     * �ӿڷ���ʵ�� ����ض��ַ���
     */
    public function operation() {
        echo "ConcreteProductA <br />\n";
    }
}
 
/**
 * �����Ʒ��ɫB
 */
class ConcreteProductB implements Product {
 
    /**
     * �ӿڷ���ʵ�� ����ض��ַ���
     */
    public function operation() {
        echo "ConcreteProductB <br />\n";
    }
}
 
class Client {
 
    /**
     * Main program.
     */
    public static function main() {
        $creatorA = new ConcreteCreatorA();
        $productA = $creatorA->factoryMethod();
        $productA->operation();
 
        $creatorB = new ConcreteCreatorB();
        $productB = $creatorB->factoryMethod();
        $productB->operation();
    }
 
}
 
Client::main();
?>

