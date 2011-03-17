<?php
require_once PATH_CALLS . 'AbstractCall.php';

class GetPaymentUrl extends AbstractCall {

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