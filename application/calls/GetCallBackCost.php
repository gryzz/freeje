<?php
require_once PATH_CALLS . 'AbstractCall.php';

class GetCallBackCost extends AbstractCall {
    
    public function __construct($firstNumber, $secondNumber, $firstType, $secondType) {
        $this->method = 'GetCallBackCost';
        
        $this->parameters = array(
            'fromNumber' => $firstNumber,
            'toNumber' => $secondNumber,
            'fromNumberType' => $firstType,
            'toNumberType' => $secondType
        );
    }
}
?>
