<?php
require_once PATH_CALLS . 'AbstractCall.php';

class GetPaymentMethods extends AbstractCall {

    public function __construct($amount) {
        $this->method = 'getPaymentMethods';
        $this->parameters = array(
            'amount' => $amount
            );
    }

}

?>
