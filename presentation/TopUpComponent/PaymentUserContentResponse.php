<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class PaymentUserContentResponse extends ResponseBase {
     public function __construct() {
        parent::__construct('paymentUserContent.html');

        parent::declareVars(array(
            'userContent'
        ));
    }

    public function setUserContent($userContent) {
        $this->set('userContent', $userContent);
    }
}

?>