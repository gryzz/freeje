<?php
require_once PATH_CALLS . 'UserLogin.php';
require_once PATH_CALLS . 'WhoAmI.php';
require_once PATH_APPLICATION . 'UserApplication.php';

class Caller {
    const FILE = '/tmp/cookie.txt';

    private $options;
    private static $instance = null;

    private function  __construct() {

    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Caller();
        }

        return self::$instance;
    }


    public function makeLoginCall($login, $password) {
        $loginCall = new UserLogin($login, $password);
        
        $url = $loginCall->createCallUrl();
        $fp = fopen(self::FILE, "w");
        fclose($fp);
        
        $curlConnection = curl_init();
        
        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_COOKIEJAR      => self::FILE,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_USERAGENT      => "spider",
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_MAXREDIRS      => 10,
            CURLINFO_HEADER_OUT    => true
        );
        
        
    curl_setopt_array($curlConnection, $options);
    $result = curl_exec($curlConnection);

    curl_close($curlConnection);

    if ($result) {
        $userApp = new UserApplication();
        $userApp->setCookieFromFile(self::FILE);
    }

    return $result;
    }

    public function makeWhoAmICall() {
        $whoAmICall = new WhoAmI();
        $url = $whoAmICall->createCallUrl();

        $curlConnection = curl_init();

        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_COOKIE         => "A2BSesIdentClients=" . $_COOKIE['A2BSesIdentClients'],
            CURLOPT_ENCODING       => "",
            CURLOPT_USERAGENT      => "spider",
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_MAXREDIRS      => 10,
            CURLINFO_HEADER_OUT    => true
        );


        curl_setopt_array($curlConnection, $options);
        $result = curl_exec($curlConnection);

        return json_decode($result);
    }
}

?>
