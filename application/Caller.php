<?php
require_once PATH_CALLS . 'UserLogin.php';
require_once PATH_CALLS . 'UserLogout.php';
require_once PATH_CALLS . 'WhoAmI.php';
require_once PATH_CALLS . 'UserRegister.php';
require_once PATH_CALLS . 'GetLatestRegistrationRespond.php';
require_once PATH_CALLS . 'ActivateUserByCode.php';
require_once PATH_CALLS . 'GetPaymentMethods.php';
require_once PATH_CALLS . 'GetPaymentUrl.php';
require_once PATH_CALLS . 'GetLatestCheckOutId.php';
require_once PATH_CALLS . 'GetPaymentForm.php';
require_once PATH_CALLS . 'ChangePassword.php';
require_once PATH_CALLS . 'PasswordRecovery.php';
require_once PATH_CALLS . 'SetLanguage.php';
require_once PATH_CALLS . 'GetCallBackCost.php';
require_once PATH_CALLS . 'GetCallHistory.php';
require_once PATH_CALLS . 'GetUserData.php';

class Caller {
    private static $instance = null;
    
    public $cookieFile;

    private function __construct() {
        
        $this->cookieFile = PATH_SESSIONS . session_id();

    }

    /**
     * @static
     * @return Caller
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Caller();
        }

        return self::$instance;
    }

    public function makeLoginCall($login, $password) {
        $loginCall = new UserLogin($login, $password);        
        $url = $loginCall->createCallUrl();
        
        $options = $this->createCallOptions($url, false);
        $result = $this->curlCall($options);

        return $result;
    }

    public function makeLogoutCall() {
        $logoutCall = new UserLogout();
        $url = $logoutCall->createCallUrl();

        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);

        return $result;
    }

    public function makeWhoAmICall() {
        $whoAmICall = new WhoAmI();
        $url = $whoAmICall->createCallUrl();

        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);

        return $result;
    }

    public function makeRegisterCall($email, $phone, $firstname, $lastname, $address, $city, $country, $postcode) {
        $userRegistration = new UserRegister($email, $phone, $firstname, $lastname, $address, $city, $country, $postcode);
        $url = $userRegistration->createCallUrl();

        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);

        return $result;
    }

    public function getLatestRegistrationRespond() {
        $latestRegistrationRespond = new GetLatestRegistrationRespond();
        $url = $latestRegistrationRespond->createCallUrl();

        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);

        return $result;
    }

    public function makeActivateUserByCodeCall($freejeId, $key, $ident, $type='email') {
        $activateUserByCode = new ActivateUserByCode($freejeId, $key, $ident, $type);
        $url = $activateUserByCode->createCallUrl();

        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);

        if ($result->code == 0) {
            $credentials = array();

            $credentials['login'] = $result['info']['login'];
            $credentials['password'] = $result['info']['password'];

            return $credentials;
        } else {
            return false;
        }
    }

    public function makeGetPaymentMethodsCall($amount) {
        $this->setLanguageCall();

        $getPaymentMethods = new GetPaymentMethods($amount);
        $url = $getPaymentMethods->createCallUrl();

        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);
//        printDump($result);

        return $result;
    }

    public function setLanguageCall($language = 'en', $userLogined = true) {
        //Brutal hack
        if ($language == 'ua') {
            $language = 'ru';
        }
        
        $setLanguage = new SetLanguage($language);
        $url = $setLanguage->createCallUrl();
        
        if ($userLogined) {
            $options = $this->createCallOptions($url);
        } else {
            $options = $this->createCallOptions($url, false);
        }
        $result = $this->curlCall($options);

        return $result;

    }

    public function makeGetPaymentUrlCall($cardId, $amount, $request, $successUrl = GetPaymentUrl::SUCCESS_URL, $failUrl = GetPaymentUrl::FAILED_URL) {
        $getPaymentUrl = new GetPaymentUrl($cardId, $amount, $request, $successUrl, $failUrl);
        $url = $getPaymentUrl->createCallUrl();
        
        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);


        return $result;
    }

    public function makeGetLatestCheckOutIdCall() {

        $getLatestCheckOutId = new GetLatestCheckOutId();
        $url = $getLatestCheckOutId->createCallUrl();

        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);

        return $result[checkout_id];
    }

    public function makeGetPaymentFormCall($checkOutId) {
        $getPaymentForm = new GetPaymentForm($checkOutId);
        $url = $getPaymentForm->createCallUrl();

        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);

        return $result['form'];
    }

    public function makeChangePasswordCall($oldPassword, $newPassword) {
        $changePassword = new ChangePassword($oldPassword, $newPassword);
        $url = $changePassword->createCallUrl();

        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);

        return $result;
    }

    public function makePasswordRecoveryCall($recoveryField) {
        $passwordRecovery = new PasswordRecovery($recoveryField);
        $url = $passwordRecovery->createCallUrl();

        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);

        return $result['code'];
    }
    
    public function makeGetCallBackCostCall($firstNumber, $secondNumber, $firstType, $secondType) {
        $callBackCosts = new GetCallBackCost($firstNumber, $secondNumber, $firstType, $secondType);
        $url = $callBackCosts->createCallUrl();
        
        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);
        
        return $result;
    }
    
    public function makeGetCallHistory($dateFrom, $dateTo) {
        $getCallHistory = new GetCallHistory($dateFrom, $dateTo);
        $url = $getCallHistory->createCallUrl();
        
        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);
        
        return $result;
    }
    
    public function makeGetUserDataCall() {
        $getUserData = new GetUserData();
        $url = $getUserData->createCallUrl();
        
        $options = $this->createCallOptions($url);
        $result = $this->curlCall($options);
        
        return $result;
    }

    public function createCallOptions($url, $useCurrentSession = true) {
        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_USERAGENT      => "spider",
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_MAXREDIRS      => 10,
            CURLINFO_HEADER_OUT    => true
        );

        if ($useCurrentSession) {
            $options[CURLOPT_COOKIE] = "A2BSesIdentClients=" . $_COOKIE['A2BSesIdentClients'];
        } else {
            $this->truncateJarFile();
            $options[CURLOPT_COOKIEJAR] = $this->cookieFile;
        }

        return $options;
    }

    public function truncateJarFile() {
        $fp = fopen($this->cookieFile, "w");
        fclose($fp);
    }

    private function curlCall($options) {
        $curlConnection = curl_init();

        curl_setopt_array($curlConnection, $options);
        $result = json_decode(curl_exec($curlConnection), true);

        curl_close($curlConnection);

        return $result;
    }
}

?>
