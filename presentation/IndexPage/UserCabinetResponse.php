<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class UserCabinetResponse extends ResponseBase {
    private $isLoginedTemplates = array (
        true => 'userCabinet.html',
        false => 'login.html'
    );

    public function __construct($page, $isLogined = false) {
        parent::__construct($this->isLoginedTemplates[$isLogined]);

        parent::declareVars(array('page', 'loginError'));

         $this->set('page', $page);
    }

    public function setPage($page) {
        $this->set('page', $page);
    }

    public function setLoginError($loginError) {
        $this->set('loginError', $loginError);
    }
}
?>