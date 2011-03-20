<?php
require_once PATH_CALLS . 'AbstractCall.php';

class SetLanguage extends AbstractCall {

    public function __construct($language = 'en') {
        $this->method = 'setLang';
        $this->parameters = array(
            'lang' => $language
            );
    }

}

?>
