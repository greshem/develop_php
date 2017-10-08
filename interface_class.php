<?
interface Creator 
{
    public function factoryMethod();
}
 
/**
 * 具体工厂角色A
 */
//interface class ConcreteCreatorA implements Creator 
class  ConcreteCreatorA implements Creator 
{
 
    /**
     * 工厂方法 返回具体 产品A
     * @return ConcreteProductA
     */
    public function factoryMethod() 
	{
        echo "生产飞机\n";
    }
}

#$a=new Creator;
$a=new ConcreteCreatorA;
$a->factoryMethod();
?>
