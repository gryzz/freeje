<?

class VarContainer {
    private $varNames;
    private $vars = array();

    
    /**
     * Defines var names
     *
     * @param array $varsList
     */
    public function declareVars ($varNames) {
        $this->varNames = $varNames;
    }
    
    /**
     * Sets var to container
     *
     * @param string $name
     * @param $value
     */
    public function set($name, $value) {
        if (in_array($name, $this->varNames)) {
            $this->vars[$name] = $value;
        }
        //TODO: Add exeption
    }
    
    public function get($name) {
        return $this->vars[$name];
    }
    
    /**
     * Retrievs vars
     *
     * @return array
     */
    public function getVars() {
        return $this->vars;
    }
}