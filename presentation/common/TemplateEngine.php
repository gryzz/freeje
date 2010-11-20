<?

class TemplateEngine {
    private $fields;
    private $template;
    
    /**
     * Template engine constructor
     *
     * @param array $fields
     * @param string $template
     */
    public function __construct($fields = array(), $template) {
        $this->fields = $fields;
        $this->template = $template;
    }
    
    /**
     * Parses template
     *
     * @return unknown
     */
    public function parse() {
//        var_dump($this->fields);
        ob_start();
        extract($this->fields);
        
        include PATH_TEMPLATES . $this->template;        
        
        return ob_get_clean();
    }
    
    /**
     * Parses and prints template
     *
     */
    public function printTemplate() {
        echo $this->parse();
    }
}