<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class RegistrationResponse extends  ResponseBase {

    public function __construct() {
        parent::__construct('registration.tpl');

        parent::declareVars(array());

    }

}

?>
