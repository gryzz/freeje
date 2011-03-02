<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class IndexResponse extends  ResponseBase {
	
    public function __construct() {
        parent::__construct('index.html');
        
        parent::declareVars(array(
            'pageTitle',
            'page',
            'isLogined',
            'error',
            'content',
            'activationMessage',
            'userCabinet',
            'mainContent'
        ));

        $this->set('pageTitle', 'Головна сторінка.');
    }

    public function setPage($page) {
        $this->set('page', $page);
    }

    public function setIsLogined($isLogined) {
        $this->set('isLogined', $isLogined);
    }

    public function setError($error) {
        $this->set('error', $error);
    }

    public function setActivationMessage($activationMessage) {
        $this->set('activationMessage', $activationMessage);
    }
}
?>