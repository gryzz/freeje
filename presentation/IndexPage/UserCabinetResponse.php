<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class UserCabinetResponse extends  ResponseBase {

    const USER_CABINET_TEMPLATE = 'userCabinet.html';
    const USER_LOGIN_TEMPLATE = 'login.html';

    public function __construct($template = self::USER_LOGIN_TEMPLATE) {
        parent::__construct($template);

        parent::declareVars(array());

    }
}
?>