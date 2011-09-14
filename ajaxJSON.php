<?php
require_once 'include/global.php';
require_once PATH_APPLICATION . 'Caller.php';

$caller = Caller::getInstance();

$firstNumber = $_GET['firstNumber'];
$secondNumber = $_GET['secondNumber'];

if (ereg("[A-Za-z]", $secondNumber)) {
    $secondType = 'skype';
} else {
    $secondType = 'phone';
}


$result = $caller->makeGetCallBackCostCall($firstNumber, $secondNumber, 'phone', $secondType);

if ($result['code'] == 0) {
    print "{status: 'ok', data: {price: '" . $result['cost'] . "'}}";
} else {
    if ($result['code'] == 5) {
        $error = 'firstNumber';
    } elseif ($result['code'] == 8) {
        $error = 'secondNumber';
    } else {
        $error = 'bothNumbers';
    }
    
    print "{status: 'error', data: {error: '" . $result['code'] . "'}}";
}

//print "{status: 'error', data: {error: 'bothNumber'}}";

//print "{status: 'ok', data: {price: '0.05'}}";

?>
