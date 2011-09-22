<?php
require_once PATH_CALLS . 'AbstractCall.php';

class GetPaymentUrl extends AbstractCall {
    const SUCCESS_URL = 'http://www.caller-mate.com/';
    const FAILED_URL = 'http://www.caller-mate.com/';

    public function __construct($cardId, $amount, $request, $successUrl, $failUrl) {
        $this->method = 'getPaymentUrl';
        $this->parameters = array(
            'cardId' => $cardId,
            'amount' => $amount,
            'request' => $request,
            'newSuccessUrl' => $successUrl,
            'newFailUrl' => $failUrl
            );
    }

}

?>