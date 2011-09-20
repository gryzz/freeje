<?
class Translator {

    private static $instance;

    private $lables = null;
    private $currentLanguage = null;

    private function  __construct() {

    }

    /**
     * @return Translator
     */
    public function getInstance() {
        if (!self::$instance) {
            self::$instance = new Translator();
        }

        return self::$instance;
    }

    public function getLable($lable) {
        if (!$this->lables || $this->currentLanguage != $_SESSION['language']) {
            $this->loadLables();
        }

        if (!$this->lables[$lable]) {
            return $lable;
        } else {
            return $this->lables[$lable];
        }
    }

    private function loadLables() {
        $fp = fopen(PATH_PRESENTATION . 'languages/' . $_SESSION['language'] . '.csv', 'r');

        while ($row = fgetcsv($fp)) {
            $this->lables[$row[0]] = $row[1];
        }

        $this->currentLanguage = $_SESSION['language'];
    }
}
?>