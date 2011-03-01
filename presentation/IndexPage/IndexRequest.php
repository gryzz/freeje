<?
require_once PATH_PRESENTATION . 'common/RequestBase.php';

class IndexRequest extends RequestBase {
    
    public function __construct() {
        parent::__construct();
        
        parent::declareVars(array());
    }
    
    public function getPage() {
        if ($this->hasParameter('page')) {
            return $this->getParameter('page');
        }
        
        return null;
    }

    public function getEmail() {
        if ($this->hasParameter('email')) {
            return $this->getParameter('email');
        }

        return null;
    }

    public function getPassword() {
        if ($this->hasParameter('password')) {
            return $this->getParameter('password');
        }

        return null;
    }

    public function isFormPosted() {
        return $this->hasParameter('form_posted');
    }
}