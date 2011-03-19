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

require_once ROOT . 'propel/runtime/lib/Propel.php';

class IndexPage implements IPage {

    const DEFAULT_LANGUAGE = 'ua';

    const HOME_PAGE_TITLE = 'Home Page';
    const DOWNLOAD_PAGE_TITLE = 'Download';
    const CONTACTS_PAGE_TITLE = 'Contacts';
    const HOW_IT_WORKS_PAGE_TITLE = 'How it works';
    
    private $isLogined = false;
    private $request;

    public function execute() {
            $propel = Propel::init(PATH_PROPEL_CONF);

            $response = new IndexResponse();
            $this->request = new IndexRequest();

            //It should be on top!!!
            $response->setLanguage($this->setupLanguage());

            $caller = Caller::getInstance();

            $isLogined = $caller->makeWhoAmICall();
            if ($isLogined) {
                $this->isLogined = $isLogined;
            } elseif ($this->request->isFormPosted()) {
                $result = $caller->makeLoginCall($this->request->getEmail(), $this->request->getPassword());

                if ($result == "true") {
                    $this->isLogined = true;
                    $user = UserQuery::create()->findOneByEmail($this->request->getEmail());

                    $_SESSION['id'] = $user->getId();
                } else {
                    $response->setError("Error happened");
                }
            } elseif($_SESSION['id']) {
                $user = UserQuery::create()->findOneById($_SESSION['id']);

                if ($user) {
                    $result = $caller->makeLoginCall($user->getEmail(), $user->getPassword());
                }

                if ($result == "true") {
                    $this->isLogined = true;
                } else {
                    $response->setError("Error happened");
                }
            }

            $response->setIsLogined($this->isLogined);

            if ($this->isLogined) {
                $userCabinet = new UserCabinetResponse(UserCabinetResponse::USER_CABINET_TEMPLATE);
            } else {
                $userCabinet = new UserCabinetResponse(UserCabinetResponse::USER_LOGIN_TEMPLATE);
            }

            $userCabinet->setPage($this->request->getPage());

            $response->addChild('userCabinet', $userCabinet);

            
            //TODO: Fix it
            switch ($this->request->getPage()) {
                case 'registration' :
                    if (!$isLogined) {
                        $registrationComponent = new RegistrationComponent();
                        $registrationResponse = $registrationComponent->execute();

                        $response->addChild('mainContent', $registrationResponse);
                    }
                    break;

                case 'activate' :
                    $response->setActivationMessage('User Activated');
                    break;

                case 'logout' :
                    session_destroy();
                    $caller->makeLogoutCall();
                    header('Location: ' . WWW_ROOT);
                    break;

                case 'passwordRecovery':
                    $passwordRecovery = new PasswordRecoveryComponent();
                    $response->addChild('mainContent', $passwordRecovery->execute());
                    break;

                case 'changePassword':
                    $changePassword = new ChangePasswordComponent();
                    $response->addChild('mainContent', $changePassword->execute());
                    break;

                case 'topUp':
                    $topUpComponent = new TopUpComponent();
                    $response->addChild('mainContent', $topUpComponent->execute());                    
                    break;

                default:
                    $contentComponent = new StaticContentComponent();
                    $response->addChild('mainContent', $contentComponent->execute($this->request->getPage()));

                    break;
            }

            $response->setPage($this->request->getPage());
            $response->setTitle($this->getTitle());

            return $response;
    }

    public function setupLanguage() {
        if ($_SESSION['language'] != $this->request->getLanguage() && $this->request->getLanguage() != null) {
            $_SESSION['language'] = $this->request->getLanguage();
        } elseif (!$_SESSION['language']) {
            $_SESSION['language'] = self::DEFAULT_LANGUAGE;
        }

        return $_SESSION['language'];
    }

    public function getTitle() {
        $translator = Translator::getInstance();

        switch ($this->request->getPage()) {
            case 'home':
                return $translator->getLable(self::HOME_PAGE_TITLE);
                break;

            case 'howItWorks':
                return $translator->getLable(self::HOW_IT_WORKS_PAGE_TITLE);
                break;

            case 'download':
                return $translator->getLable(self::DOWNLOAD_PAGE_TITLE);
                break;

            case 'contacts':
                return $translator->getLable(self::CONTACTS_PAGE_TITLE);
                break;
        }
    }
}