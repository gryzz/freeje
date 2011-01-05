<?php
require_once PATH_CALLS . 'AbstractCall.php';

class GetLatestRegistrationRespond extends AbstractCall {

    public function __construct() {
        $this->method = 'getLatestRegistrationRespond';
    }

}
?>
