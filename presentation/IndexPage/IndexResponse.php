<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class IndexResponse extends  ResponseBase {
	
    public function __construct() {
        parent::__construct('index.tpl');
        
        parent::declareVars(array('pageTitle', 'isLogined', 'error', 'content'));

        $this->set('pageTitle', 'Головна сторінка.');
    }

    public function setIsLogined($isLogined) {
        $this->set('isLogined', $isLogined);
    }

    public function setError($error) {
        $this->set('error', $error);
    }
}
?>