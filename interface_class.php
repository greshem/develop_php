<?
interface Creator 
{
    public function factoryMethod();
}
 
/**
 * ���幤����ɫA
 */
//interface class ConcreteCreatorA implements Creator 
class  ConcreteCreatorA implements Creator 
{
 
    /**
     * �������� ���ؾ��� ��ƷA
     * @return ConcreteProductA
     */
    public function factoryMethod() 
	{
        echo "�����ɻ�\n";
    }
}

#$a=new Creator;
$a=new ConcreteCreatorA;
$a->factoryMethod();
?>
