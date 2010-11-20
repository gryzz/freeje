<?

class DataEngine {
    static $instance = null;
    
    private function __construct() {
        $link = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('Error connect to DB');
        mysql_select_db(DB_NAME, $link) or die('Can not select DB');
        mysql_query('SET NAMES utf8');
    }
    
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new DataEngine();
        }
        
        return self::$instance;
    }
    
    /**
     * Executes query
     *
     * @param string $query
     */
    public function executeQuery($query) {
        $result = mysql_query($query);
        
        return $result;
    }
    
    /**
     * Fetch mysql result
     *
     * @param mysql resource $result
     * @return array
     */
    public function fetchResult($result) {
        return mysql_fetch_array($result);
    }
    
    /**
     * Escapes string
     *
     * @param string $string
     * @return string
     */
    public function escape($string) {
        $string = htmlspecialchars($string);
        
        return $string;
    }
    
    /**
     * Gets last inserted id
     *
     * @return int
     */
    public function getLastId() {
        return mysql_insert_id();
    }
}