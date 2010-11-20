<?php
require_once PATH_CALLS . 'interfaces/Call.php';

abstract class AbstractCall implements Call{
    const SITE = 25;

    private $method;
    private $parameters = array();

    /*
     * Creates url for json call
     */
    public function createCallUrl() {
        $url = FREEJE_URL_BASE . $this->method;

        foreach ($this->parameters as $parameter) {
            $url .= '/' . $parameter;
        }

        return $url;
    }

}

?>
