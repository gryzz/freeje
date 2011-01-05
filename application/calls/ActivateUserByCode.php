<?php
require_once PATH_CALLS . 'AbstractCall.php';

class ActivateUserByCode extends AbstractCall {

    public function __construct($freejeId, $key, $ident, $type='email') {
        $this->method = 'activateUserByCode';
        $this->parameters = array(
            'UserId' => $freejeId,
            'SiteId' => self::SITE,
            'Ident' => $ident,
            'Code' => $key,
            'Type' => $type
        );
    }
}
?>