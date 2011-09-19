<?
require_once PATH_PRESENTATION . 'common/RequestBase.php';

class IndexRequest extends RequestBase {

    /**
     * @return IndexRequest
     */
    public function __construct() {

    }

    public function getPage() {
        if ($this->hasParameter('page')) {
            return $this->getParameter('page');
        }
        
        return null;
    }

    public function getAction() {
        if ($this->hasParameter('action')) {
            return $this->getParameter('action');
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

    /**
     * @return bool
     */
    public function isFormPosted() {
        return $this->hasParameter('form_posted');
    }
    
    public function getLanguage() {
        if ($this->hasParameter('language')) {
            return $this->getParameter('language');
        }

        return null;
    }
}