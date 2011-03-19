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
require_once PATH_APPLICATION . 'UserApplication.php';

class Caller {

    private $options;
    private $file = '/tmp/cookie.txt';
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
        $this->truncateJarFile();
        
        $curlConnection = curl_init();
        
        $options = $this->createCallOptions($url);
        $options[CURLOPT_COOKIEJAR] = $this->file;
                
        curl_setopt_array($curlConnection, $options);
        $result = curl_exec($curlConnection);

        curl_close($curlConnection);

        if ($result) {
            $this->setSessionCookie();
        }

        return $result;
    }

    public function makeLogoutCall() {
        $logoutCall = new UserLogout();

        $url = $logoutCall->createCallUrl();
        $curlConnection = curl_init();

        $options = $this->createCallOptions($url);
        $options[CURLOPT_COOKIE] = "A2BSesIdentClients=" . $_COOKIE['A2BSesIdentClients'];
        curl_setopt_array($curlConnection, $options);
        $result = json_decode(curl_exec($curlConnection));


        return $result;
    }

    public function makeWhoAmICall() {
        $whoAmICall = new WhoAmI();
        $url = $whoAmICall->createCallUrl();

        $curlConnection = curl_init();

        $options = $this->createCallOptions($url);
        $options[CURLOPT_COOKIE] = "A2BSesIdentClients=" . $_COOKIE['A2BSesIdentClients'];
        curl_setopt_array($curlConnection, $options);
        $result = json_decode(curl_exec($curlConnection));


        return $result;
    }

    public function makeRegisterCall($email, $phone, $firstname, $lastname, $address, $city, $country, $postcode) {
        $userRegistration = new UserRegister($email, $phone, $firstname, $lastname, $address, $city, $country, $postcode);
        $url = $userRegistration->createCallUrl();

        $this->truncateJarFile();

        $curlConnection = curl_init();
        $options = $this->createCallOptions($url);
        $options[CURLOPT_COOKIEJAR] = $this->file;
        curl_setopt_array($curlConnection, $options);
        $result = json_decode(curl_exec($curlConnection));

        curl_close($curlConnection);

        $this->setSessionCookie();

        if (!$result) {
            $error = $this->getLatestRegistrationRespond();
            var_dump($error);
        }

        return $result;
    }

    public function getLatestRegistrationRespond() {
        $latestRegistrationRespond = new GetLatestRegistrationRespond();
        $url = $latestRegistrationRespond->createCallUrl();

        $curlConnection = curl_init();
        $options = $this->createCallOptions($url);
        $options[CURLOPT_COOKIE] = "A2BSesIdentClients=" . $_COOKIE['A2BSesIdentClients'];
        curl_setopt_array($curlConnection, $options);
        $result = json_decode(curl_exec($curlConnection));

        curl_close($curlConnection);

        return $result;
    }

    public function makeActivateUserByCodeCall($freejeId, $key, $ident, $type='email') {
        $activateUserByCode = new ActivateUserByCode($freejeId, $key, $ident, $type);
        $url = $activateUserByCode->createCallUrl();

        $curlConnection = curl_init();
        $options = $this->createCallOptions($url);
        $options[CURLOPT_COOKIE] = "A2BSesIdentClients=" . $_COOKIE['A2BSesIdentClients'];
        curl_setopt_array($curlConnection, $options);
        $result = json_decode(curl_exec($curlConnection));

        curl_close($curlConnection);

        if ($result->code == 0) {
            $credentials = array();

            $credentials['login'] = $result->info->login;
            $credentials['password'] = $result->info->password;

            return $credentials;
        } else {
            return 0;
        }
    }

    public function makeGetPaymentMethodsCall($amount) {
        $getPaymentMethods = new GetPaymentMethods($amount);
        $url = $getPaymentMethods->createCallUrl();

        $curlConnection = curl_init();

        $options = $this->createCallOptions($url);
        $options[CURLOPT_COOKIE] = "A2BSesIdentClients=" . $_COOKIE['A2BSesIdentClients'];
        curl_setopt_array($curlConnection, $options);
        $result = json_decode(curl_exec($curlConnection), true);


        return $result;
    }

    public function makeGetPaymentUrlCall($cardId, $amount, $request, $successUrl = 'home.html', $failUrl = 'home.html') {

        $getPaymentUrl = new GetPaymentUrl($cardId, $amount, $request, $successUrl, $failUrl);
        $url = $getPaymentUrl->createCallUrl();

        $curlConnection = curl_init();

        $options = $this->createCallOptions($url);
        $options[CURLOPT_COOKIE] = "A2BSesIdentClients=" . $_COOKIE['A2BSesIdentClients'];
        curl_setopt_array($curlConnection, $options);
        $result = json_decode(curl_exec($curlConnection), true);


        return $result;
    }

    public function makeGetLatestCheckOutIdCall() {

        $getLatestCheckOutId = new GetLatestCheckOutId();
        $url = $getLatestCheckOutId->createCallUrl();

        $curlConnection = curl_init();

        $options = $this->createCallOptions($url);
        $options[CURLOPT_COOKIE] = "A2BSesIdentClients=" . $_COOKIE['A2BSesIdentClients'];
        curl_setopt_array($curlConnection, $options);
        $result = json_decode(curl_exec($curlConnection), true);

        return $result[checkout_id];
    }

    public function makeGetPaymentFormCall($checkOutId) {
        $getPaymentForm = new GetPaymentForm($checkOutId);
        $url = $getPaymentForm->createCallUrl();

        $curlConnection = curl_init();

        $options = $this->createCallOptions($url);
        $options[CURLOPT_COOKIE] = "A2BSesIdentClients=" . $_COOKIE['A2BSesIdentClients'];
        curl_setopt_array($curlConnection, $options);
        $result = json_decode(curl_exec($curlConnection), true);

        return $result['form'];
    }

    public function makeChangePasswordCall($oldPassword, $newPassword) {
        $changePassword = new ChangePassword($oldPassword, $newPassword);
        $url = $changePassword->createCallUrl();

        $curlConnection = curl_init();

        $options = $this->createCallOptions($url);
        $options[CURLOPT_COOKIE] = "A2BSesIdentClients=" . $_COOKIE['A2BSesIdentClients'];
        curl_setopt_array($curlConnection, $options);
        $result = json_decode(curl_exec($curlConnection), true);

        return $result;
    }

    public function makePasswordRecoveryCall($recoveryField) {
        $passwordRecovery = new PasswordRecovery($recoveryField);
        $url = $passwordRecovery->createCallUrl();

        $curlConnection = curl_init();

        $options = $this->createCallOptions($url);
        $options[CURLOPT_COOKIE] = "A2BSesIdentClients=" . $_COOKIE['A2BSesIdentClients'];
        curl_setopt_array($curlConnection, $options);
        $result = json_decode(curl_exec($curlConnection), true);

        return $result['code'];
    }

    public function createCallOptions($url) {
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

        return $options;
    }

    public function setSessionCookie() {
        $userApp = new UserApplication();
        $userApp->setCookieFromFile($this->file);
    }

    public function truncateJarFile() {
        $fp = fopen($this->file, "w");
        fclose($fp);
    }
}

?>
