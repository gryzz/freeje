<?php
require_once PATH_CALLS . 'AbstractCall.php';

class GetCallHistory extends AbstractCall {

    public function __construct($dateFrom, $dateTo) {
        $this->method = 'getCallHistory';
        $this->parameters = array(
            'from' => $dateFrom,
            'to' => $dateTo,
            'SiteIdent' => self::SITE
            );
    }

}

?>