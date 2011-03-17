<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class SelectPaymentMethodResponse extends ResponseBase {
     public function __construct() {
        parent::__construct('selectPaymentMethod.html');

        parent::declareVars(array('paymentMethods', 'finalPaymentAmounts'));
    }

    public function setPaymentMethods($paymentMethods) {
        $this->set('paymentMethods', $paymentMethods);
    }

    public function setFinalPaymentAmounts($finalPaymentAmounts) {
        $this->set('finalPaymentAmounts', $finalPaymentAmounts);
    }
}

?>