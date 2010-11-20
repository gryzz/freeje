<?php
require_once PATH_CALLS . 'AbstractCall.php';

class UserLogin extends AbstractCall {

    public function __construct($login, $password) {
        $this->method = 'login';
        $this->parameters = array(
            'login' => $login,
            'password' => $password,
            'site' => $site
            );
    }

}

?>
