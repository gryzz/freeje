<?
require_once PATH_PRESENTATION_COMMON . 'VarContainer.php';

class RequestBase {
    protected $container;
    
    public function __construct() {
        $this->container = new VarContainer(); 
    }
    
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
    
    
}