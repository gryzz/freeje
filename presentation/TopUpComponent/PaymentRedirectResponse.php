<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class PaymentRedirectResponse extends ResponseBase {
     public function __construct() {
        parent::__construct('paymentForm.html');

        parent::declareVars(array(
            'action',
            'charset',
            'fields'
        ));
    }

    public function setAction($action) {
        $this->set('action', $action);
    }

    public function setCharset($charset) {
        $this->set('charset', $charset);
    }

    public function setFields($fields) {
        $this->set('fields', $fields);
    }
}

?>