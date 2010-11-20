<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class IndexResponse extends  ResponseBase {
	
    public function __construct() {
        parent::__construct('index.tpl');
        
        parent::declareVars(array('pageTitle'));

        $this->set('pageTitle', 'Головна сторінка.');
    }
}
?>