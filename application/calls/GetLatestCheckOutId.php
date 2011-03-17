<?php
require_once PATH_CALLS . 'AbstractCall.php';

class GetLatestCheckOutId extends AbstractCall {

    public function __construct() {
        $this->method = 'getLatestCheckOutId';
        $this->parameters = array();
    }

}

?>