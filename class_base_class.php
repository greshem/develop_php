<?
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

$a=new Creator;
?>
