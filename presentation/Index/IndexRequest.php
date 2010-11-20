<?
require_once PATH_PRESENTATION . 'common/RequestBase.php';

class IndexRequest extends RequestBase {
    
    public function __construct() {
        parent::__construct();
        
        parent::declareVars(array());
    }
    
    public function getSection() {
        if ($this->hasParameter('section')) {
            return $this->getParameter('section');
        }
        
        return null;
    }
    
}