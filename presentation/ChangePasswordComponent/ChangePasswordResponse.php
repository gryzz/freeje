<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class ChangePasswordResponse extends ResponseBase {
     public function __construct() {
        parent::__construct('changePassword.html');

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