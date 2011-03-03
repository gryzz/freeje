<?
require_once PATH_PRESENTATION . 'common/interfaces/IPage.php';
require_once PATH_PRESENTATION . 'IndexPage/IndexRequest.php';
require_once PATH_PRESENTATION . 'IndexPage/IndexResponse.php';
require_once PATH_PRESENTATION . 'IndexPage/UserCabinetResponse.php';
require_once PATH_PRESENTATION . 'IndexPage/RegistrationComponent.php';
require_once PATH_PRESENTATION . 'IndexPage/StaticContentComponent.php';
require_once PATH_APPLICATION . 'Caller.php';

require_once ROOT . 'propel/runtime/lib/Propel.php';

class IndexPage implements IPage {

    const DEFAULT_LANGUAGE = 'ua';
    
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

            $response->addChild('userCabinet', $userCabinet);

            $contentComponent = new StaticContentComponent();
            $response->addChild('mainContent', $contentComponent->execute($this->request->getPage()));

            $response->setPage($this->request->getPage());



            //TODO: Fix it
            switch ($this->request->getPage()) {
                case 'registration' :
                    if (!$isLogined) {
                        $registrationComponent = new RegistrationComponent();
                        $registrationResponse = $registrationComponent->execute();

                        $response->addChild('content', $registrationResponse);
                    }
                    break;

               case 'activate' :
                   $response->setActivationMessage('User Activated');
                   break;
            }

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
}