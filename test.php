<?php
abstract class TestAbstract {
        
    abstract public function test();
    
    public function printValue($value) {
        print $value;
    }
}

class Test extends TestAbstract {
    public function advancedPrintValue($value) {
        $value = "It's value: " . $value;
        
        print $value;
    }
}


$test = new Test();

$test->printValue('value');

?>
