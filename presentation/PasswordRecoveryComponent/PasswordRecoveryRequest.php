<?
require_once PATH_PRESENTATION . 'common/RequestBase.php';

class PasswordRecoveryRequest extends RequestBase {

    public function __construct() {
        parent::__construct();

        parent::declareVars(array());
    }

    public function getEmail() {
        if ($this->hasParameter('email')) {
            return $this->getParameter('email');
        }

        return null;
    }
}