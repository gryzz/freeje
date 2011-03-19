<?php
require_once PATH_CALLS . 'AbstractCall.php';

class PasswordRecovery extends AbstractCall {

    public function __construct($recoveryField) {
        $this->method = 'recoveryPassword';
        $this->parameters = array(
            'UserIdent' => $recoveryField,
            'SiteIdent' => self::SITE
            );
    }

}

?>