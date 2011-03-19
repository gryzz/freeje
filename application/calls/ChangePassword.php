<?php
require_once PATH_CALLS . 'AbstractCall.php';

class ChangePassword extends AbstractCall {

    public function __construct($oldPassword, $newPassword) {
        $this->method = 'changePass';
        $this->parameters = array(
            'oldpass' => $oldPassword,
            'newpass' => $newPassword
            );
    }

}

?>
