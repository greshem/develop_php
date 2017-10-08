<?php
/**
 * 工厂模式 2010-06-25 sz
 * @author 胖子 phppan.p#gmail.com  http://www.phppan.com
 * 哥学社成员（http://www.blog-brother.com/）
 * @package design pattern
 */
 
/**
 * 抽象工厂角色
 */
interface Creator 
{
    public function factoryMethod();
}
 
/**
 * 具体工厂角色A
 */
class ConcreteCreatorA implements Creator 
{
 
    /**
     * 工厂方法 返回具体 产品A
     * @return ConcreteProductA
     */
    public function factoryMethod() 
	{
        return new ConcreteProductA();
    }
}
 
/**
 * 具体工厂角色B
 */
class ConcreteCreatorB implements Creator {
 
    /**
     * 工厂方法 返回具体 产品B
     * @return ConcreteProductB
     */
    public function factoryMethod() {
        return new ConcreteProductB();
    }
}
 
/**
 * 抽象产品角色
 */
interface Product {
    public function operation();                                                                                    
}
 
/**
 * 具体产品角色A
 */
class ConcreteProductA implements Product {
 
    /**
     * 接口方法实现 输出特定字符串
     */
    public function operation() {
        echo "ConcreteProductA <br />\n";
    }
}
 
/**
 * 具体产品角色B
 */
class ConcreteProductB implements Product {
 
    /**
     * 接口方法实现 输出特定字符串
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

