<?
require_once PATH_PRESENTATION_COMMON . 'VarContainer.php';
require_once PATH_PRESENTATION_COMMON . 'TemplateEngine.php';

class ResponseBase {
    protected $container;
    private $childResponses = array();
    private $template;
    
    public function __construct($template) {
        $this->container = new VarContainer();

        if ($_SESSION['language']) {
            $language = $_SESSION['language'];
        } else {
            $language = IndexPage::DEFAULT_LANGUAGE;
        }

        $this->template = $language . '/' . $template;
    }
    
    /**
     * Display response
     *
     * @param bool print
     */
    public function display($print = false) {
        $this->displayChildResponses();
        
        $templateEngine = new TemplateEngine($this->container->getVars(), $this->template);
        
        if ($print) {
            $templateEngine->printTemplate();
        } else {
            return $templateEngine->parse();
        }
    }
    
    /**
     * Adds child response
     *
     * @param string $name
     * @param object $value
     */
    public function addChild ($name, $value) {
        $this->childResponses[$name] = $value;
    }
    
    /**
     * Defines var names
     *
     * @param array $varsList
     */
    protected function declareVars ($varNames) {
        $this->container->declareVars($varNames);
    }
    
    /**
     * Sets container variable
     *
     * @param string $name
     * @param mixed $value
     */
    protected function set($name, $value) {
        $this->container->set($name, $value);
    }
    
    /**
     * Gets container variable
     * 
     * @param string $name
     */
    protected function get($name) {
        $this->container->get($name);
    }
    
    /**
     * Display child responses
     *
     */
    private function displayChildResponses() {
        foreach ($this->childResponses as $name => $response) {
            $this->container->set($name, $response->display()); 
        }
    }
}