<?php
require_once PATH_PRESENTATION . 'common/RequestBase.php';

class ActivateRequest extends RequestBase {

    public function __construct() {
        parent::__construct();

        parent::declareVars(array());
    }

    public function getKey() {
        if ($this->hasParameter('key')) {
            return $this->getParameter('key');
        }

        return null;
    }

    public function getFuid() {
        if ($this->hasParameter('fuid')) {
            return $this->getParameter('fuid');
        }

        return null;
    }

    public function getS2email() {
        if ($this->hasParameter('s2email')) {
            return $this->getParameter('s2email');
        }

        return null;
    }
}
?>
