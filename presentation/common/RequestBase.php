<?
require_once PATH_PRESENTATION_COMMON . 'VarContainer.php';

class RequestBase {    
    /**
     * Defines var names
     *
     * @param array $varsList
     */
    public function declareVars ($varNames) {
        $this->container->declareVars($varNames);
    }
    
    /**
     * Checks if parameter exists
     *
     * @param string $name
     * @return bool
     */
    public function hasParameter($name) {
        if (isset($_POST[$name]) || isset($_GET[$name])) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Retrieves parameter
     *
     * @param string $name
     * @return string
     */
    public function getParameter($name) {
        return $_REQUEST[$name];
    }

    /**
     * Gets session parameter
     * @param string $key
     * @return string
     */
    public function getSessionVar($key) {
        return $_SESSION[$key];
    }

    /**
     * Sets session parameter
     * @param string $key
     * @param string $value
     */
    public function setSessionVar($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    
}