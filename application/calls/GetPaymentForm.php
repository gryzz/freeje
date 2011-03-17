<?php
require_once PATH_CALLS . 'AbstractCall.php';

class GetPaymentForm extends AbstractCall {

    public function __construct($checkOutId) {
        $this->method = 'getPaymentForm';
        $this->parameters = array('checkOutId' => $checkOutId);
    }

}

?>