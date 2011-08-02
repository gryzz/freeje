<?
require_once PATH_PRESENTATION . 'common/interfaces/IPage.php';
require_once PATH_PRESENTATION . 'IndexPage/IndexRequest.php';
require_once PATH_PRESENTATION . 'IndexPage/IndexResponse.php';
require_once PATH_PRESENTATION . 'IndexPage/UserCabinetResponse.php';
require_once PATH_PRESENTATION . 'IndexPage/RegistrationComponent.php';
require_once PATH_PRESENTATION . 'IndexPage/StaticContentComponent.php';
require_once PATH_PRESENTATION . 'TopUpComponent/TopUpComponent.php';
require_once PATH_PRESENTATION . 'ChangePasswordComponent/ChangePasswordComponent.php';
require_once PATH_PRESENTATION . 'PasswordRecoveryComponent/PasswordRecoveryComponent.php';
require_once PATH_APPLICATION . 'Caller.php';
require_once PATH_APPLICATION . 'Translator.php';
require_once PATH_APPLICATION . 'UserApplication.php';

require_once ROOT . 'propel/runtime/lib/Propel.php';

class IndexPage implements IPage {

    const DEFAULT_LANGUAGE = 'ua';

    private $titles = array(
        'home' => 'Home Page',
        'howItWorks' => 'How it works',
        'download' => 'Download',
        'contacts' => 'Contacts'
    );
    
    private $components = array(
        'registration' => 'RegistrationComponent',
        'passwordRecovery' => 'PasswordRecoveryComponent',
        'changePassword' => 'ChangePasswordComponent',
        'topUp' => 'TopUpComponent'
    );

    private $request;


    /**
     * Executes main flow of site
     * @return IndexResponse
     */
    public function execute() {
        $propel = Propel::init(PATH_PROPEL_CONF);
        $translator = Translator::getInstance();

        $response = new IndexResponse();
        $this->request = new IndexRequest();

        $response->setLanguage($this->setupLanguage());

        $this->handleActions();

        $caller = Caller::getInstance();

        $isLogined = (bool)$caller->makeWhoAmICall();

        if (!$isLogined && $this->request->isFormPosted()) {
            $isLogined = $this->loginByPostedForm();

            if (!$isLogined) {
                $response->setError("Login error");
            }
        } elseif (!$isLogined && $this->request->getSessionVar('id')) {
            $isLogined = $this->loginBySession();

            if (!$isLogined) {
                $response->setError("Login error");
            }
        }

        $response->setIsLogined($isLogined);

        $page = $this->request->getPage();
        $response->setPage($page);

        $userCabinet = new UserCabinetResponse($page, $isLogined);
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
    public function setupLanguage() {
        if ($this->request->getSessionVar('language') != $this->request->getLanguage() && $this->request->getLanguage() != null) {
            $this->request->setSessionVar('language', $this->request->getLanguage());
        } elseif (!$this->request->getSessionVar('language')) {
            $this->request->setSessionVar('language', self::DEFAULT_LANGUAGE);
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
     * Logs out the user using logout call and destroing their session
     */
    private function logout() {
        $caller = Caller::getInstance();

        session_destroy();
        $caller->makeLogoutCall();
        header('Location: ' . WWW_ROOT);
    }

    /**
     * Handles page actions
     */
    private function handleActions() {
        switch ($this->request->getAction()) {
            case 'activate' :
                $response->setActivationMessage('User Activated');
                break;

            case 'logout' :
                $this->logout();
                break;
        }
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
            $this->request->setSessionVar('id', $user->getId());
            $this->setSessionCookie();

            return true;
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
            return true;
        }

        return false;
    }

    /**
     * Sets cookie from file
     */
    public function setSessionCookie() {
        $userApp = new UserApplication();
        $userApp->setCookieFromFile(Caller::CURL_SESSION_FILE);
    }
}