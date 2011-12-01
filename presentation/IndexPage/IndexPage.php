<?
require_once PATH_PRESENTATION . 'common/interfaces/IPage.php';
require_once PATH_PRESENTATION . 'IndexPage/IndexRequest.php';
require_once PATH_PRESENTATION . 'IndexPage/IndexResponse.php';
require_once PATH_PRESENTATION . 'IndexPage/UserCabinetResponse.php';
require_once PATH_PRESENTATION . 'IndexPage/RegistrationComponent.php';
require_once PATH_PRESENTATION . 'IndexPage/StaticContentComponent.php';
require_once PATH_PRESENTATION . 'TopUpComponent/TopUpComponent.php';
require_once PATH_PRESENTATION . 'CallsHistoryComponent/CallsHistoryComponent.php';
require_once PATH_PRESENTATION . 'ChangePasswordComponent/ChangePasswordComponent.php';
require_once PATH_PRESENTATION . 'PasswordRecoveryComponent/PasswordRecoveryComponent.php';
require_once PATH_PRESENTATION . 'UserBalance/UserBalanceComponent.php';
require_once PATH_APPLICATION . 'Caller.php';
require_once PATH_APPLICATION . 'Translator.php';
require_once PATH_APPLICATION . 'UserApplication.php';

require_once ROOT . 'propel/runtime/lib/Propel.php';

class IndexPage implements IPage {

    const DEFAULT_LANGUAGE = 'ua';

    private $titles = array(
        'home' => 'Home Page',
        'howItWorks' => 'How it works',
        'FAQ' => 'FAQ',
        'download' => 'Download',
        'contacts' => 'Contacts'
    );
    
    private $components = array(
        'registration' => 'RegistrationComponent',
        'passwordRecovery' => 'PasswordRecoveryComponent',
        'changePassword' => 'ChangePasswordComponent',
        'topUp' => 'TopUpComponent',
        'callsHistory' => 'CallsHistoryComponent',
        'userBalance' => 'UserBalanceComponent'
    );

    /**
     * @var IndexRequest
     */
    private $request;


    /**
     * Executes main flow of site
     * @return IndexResponse
     */
    public function execute() {

        try {
            $propel = Propel::init(PATH_PROPEL_CONF);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
        $translator = Translator::getInstance();
        
        $this->request = new IndexRequest();

        $response = new IndexResponse();

        /**
         * @todo fix it
         */
        $response = $this->handleActions($response);

        $caller = Caller::getInstance();

        $isLogined = (bool)$caller->makeWhoAmICall();

        if (!$isLogined && $this->request->isFormPosted()) {
            $isLogined = $this->loginByPostedForm();

            if (!$isLogined) {
                $loginError = true;
            }
        } elseif (!$isLogined && $this->request->getSessionVar('id')) {
            $isLogined = $this->loginBySession();

//            if (!$isLogined) {
//                $response->setLoginError("Login error");
//            }
        }
        
        $language = $this->setupLanguage($isLogined);
        $response->setLanguage($language);

        $response->setIsLogined($isLogined);

        $page = $this->request->getPage();
        $response->setPage($page);

        $userCabinet = new UserCabinetResponse($page, $isLogined);
        if ($loginError) {
            $userCabinet->setLoginError($translator->getLable("Login data is wrong"));
        }
        $response->addChild('userCabinet', $userCabinet);

        $component = $this->createComponentByPage($page);
        if ($component) {
            $response->addChild('mainContent', $component->execute());
        } else {
            $component = new StaticContentComponent();
            $response->addChild('mainContent', $component->execute($page));
        }

        $title = $translator->getLable($this->titles[$page]);
        $response->setTitle($title);

        return $response;
    }

    /**
     * Setups language.
     * @return string
     */
    public function setupLanguage($isLogined) {
        $caller = Caller::getInstance();
        
        if ($this->request->getSessionVar('language') != $this->request->getLanguage() && $this->request->getLanguage() != null) {
            $this->request->setSessionVar('language', $this->request->getLanguage());
            $caller->setLanguageCall($this->request->getLanguage(), $isLogined);
        } elseif (!$this->request->getSessionVar('language')) {
            $this->request->setSessionVar('language', self::DEFAULT_LANGUAGE);
            $caller->setLanguageCall(self::DEFAULT_LANGUAGE, $isLogined);
        }
        
        if (!$isLogined) {
            $this->setSessionCookie();
        }

        return $this->request->getSessionVar('language');
    }

    /**
     * Creates component depends on page get parameter
     * @param string $page
     * @return IComponent
     */
    private function createComponentByPage($page) {
        if ($this->components[$page]) {
            return new $this->components[$page]();
        }

        return null;
    }

    /**
     * Logs out the user using logout call and destroying their session
     */
    private function logout() {
        $caller = Caller::getInstance();

        $caller->makeLogoutCall();
        
        setcookie('A2BSesIdentClients', '' , time() - 42);

        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

        $_SESSION = array();

        session_destroy();
        
        header('Location: ' . WWW_ROOT);
    }

    /**
     * Handles page actions
     */
    private function handleActions($response) {
        switch ($this->request->getAction()) {
            case 'activate' :
                $response->setActivationMessage('User Activated');
                break;

            case 'logout' :
                $this->logout();
                break;
        }

        return $response;
    }

    /**
     * Tries log in use if login for is posted
     * @return bool
     */
    private function loginByPostedForm() {
         $caller = Caller::getInstance();

        $result = $caller->makeLoginCall($this->request->getEmail(), $this->request->getPassword());

        if ($result == "true") {
            $user = UserQuery::create()->findOneByEmail($this->request->getEmail());
            
            if ($user) {
                $this->request->setSessionVar('id', $user->getId());
                $this->setSessionCookie();
                
                $caller->setLanguageCall($this->request->getSessionVar('language'));
                return true;
            }
        }

        return false;
    }

    /**
     * Tries to login user if user session exists
     * @return bool
     */
    private function loginBySession() {
        $caller = Caller::getInstance();

        $user = UserQuery::create()->findOneById($this->request->getSessionVar('id'));

        if ($user) {
            $result = $caller->makeLoginCall($user->getEmail(), $user->getPassword());
        }

        if ($result == "true") {
            $this->setSessionCookie();
            
            $caller->setLanguageCall($this->request->getSessionVar('language'));
            return true;
        }

        return false;
    }

    /**
     * Sets cookie from file
     */
    public function setSessionCookie() {
        $caller = Caller::getInstance();
        
        $userApp = new UserApplication();
        $userApp->setCookieFromFile($caller->cookieFile);
    }
}