<?
require_once PATH_PRESENTATION . 'common/RequestBase.php';

class ChangePasswordRequest extends RequestBase {

    public function __construct() {
        parent::__construct();

        parent::declareVars(array());
    }

    public function getNewPassword() {
        if ($this->hasParameter('newPassword1')) {
            return $this->getParameter('newPassword1');
        }

        return null;
    }

    public function getOldPassword() {
        if ($this->hasParameter('oldPassword')) {
            return $this->getParameter('oldPassword');
        }

        return null;
    }
}
?>