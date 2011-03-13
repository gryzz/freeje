<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class TopUpResponse extends ResponseBase {
     public function __construct() {
        parent::__construct('topUp.html');

        parent::declareVars(array());

    }
}

?>