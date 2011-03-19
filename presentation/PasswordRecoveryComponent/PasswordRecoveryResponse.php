<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class PasswordRecoveryResponse extends ResponseBase {
     public function __construct() {
        parent::__construct('passwordRecovery.html');

        parent::declareVars(array(
            'error',
            'message'
        ));
    }

    public function setError($error) {
        $this->set('error', $error);
    }

    public function setMessage($message) {
        $this->set('message', $message);
    }
}
?>