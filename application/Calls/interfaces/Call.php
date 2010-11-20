<?php

interface Call {
    private $method;
    private $parameters;

    public function createCallUrl();
}

?>
