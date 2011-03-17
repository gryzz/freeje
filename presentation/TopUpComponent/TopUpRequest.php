<?
require_once PATH_PRESENTATION . 'common/RequestBase.php';

class TopUpRequest extends RequestBase {

    public function __construct() {
        parent::__construct();

        parent::declareVars(array());
    }

    public function getAmount() {
        if ($this->hasParameter('amount')) {
            return $this->getParameter('amount');
        }

        return null;
    }

    public function isPaymentFormPosted() {
        if ($this->hasParameter('isPaymentFormPosted')) {
            return true;
        }

        return false;
    }

    public function getFinalAmount() {
        if ($this->hasParameter('finalAmount')) {
            return $this->getParameter('finalAmount');
        }

        return null;
    }

    public function getPaymentMethod() {
        if ($this->hasParameter('paymentMethod')) {
            return $this->getParameter('paymentMethod');
        }

        return null;
    }
}
?>