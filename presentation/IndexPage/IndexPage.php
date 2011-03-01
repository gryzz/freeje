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

        private $isLogined = false;
	
	public function execute() {
                $propel = Propel::init(PATH_PROPEL_CONF);

		$response = new IndexResponse();
                $request = new IndexRequest();

                $caller = Caller::getInstance();

                $isLogined = $caller->makeWhoAmICall();
                
                if ($isLogined) {
                    $this->isLogined = $isLogined;
                } elseif ($request->isFormPosted()) {
                    $result = $caller->makeLoginCall($request->getEmail(), $request->getPassword());

                    if ($result == "true") {
                        $this->isLogined = true;
                        $user = UserQuery::create()->findOneByEmail($request->getEmail());

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
                $response->addChild('mainContent', $contentComponent->execute($request->getPage()));



                //TODO: Fix it
                switch ($request->getPage()) {
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
}