<?php
require_once PATH_CALLS . 'AbstractCall.php';

class UserLogout extends AbstractCall {

    public function __construct() {
        $this->method = 'logout';
    }

}

?>
