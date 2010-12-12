<?php

class UserApplication {
    public function setCookieFromFile($file) {
        $content = file($file);

        $variables = explode("\t", trim($content[4]));

        setcookie($variables[5], $variables[6]);
        
        $_COOKIE[$variables[5]] = $variables[6];
    }
}

?>
