<?php 
class BaseClass {
   public function test() {
       echo "BaseClass::test() called\n";
   }
   
   //final public function moreTesting() {
   public function moreTesting() {
       echo "BaseClass::moreTesting() called\n";
   }
}

class ChildClass extends BaseClass {
   public function moreTesting() {
       echo "ChildClass::moreTesting() called\n";
   }
}

$b=new ChildClass;
$b->moreTesting();
// Results in Fatal error: Cannot override final method BaseClass::moreTesting()
?>  
