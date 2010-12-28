<?
require_once PATH_PRESENTATION . 'common/interfaces/IPage.php';
require_once PATH_PRESENTATION . 'IndexPage/IndexRequest.php';
require_once PATH_PRESENTATION . 'IndexPage/IndexResponse.php';
require_once PATH_PRESENTATION . 'IndexPage/RegistrationComponent.php';
require_once PATH_APPLICATION . 'Caller.php';

class IndexPage implements IPage {
	
	public function execute() {
		$response = new IndexResponse();
                $request = new IndexRequest();

                $caller = Caller::getInstance();

                $isLogined = $caller->makeWhoAmICall();
                
                if ($isLogined) {
                    //$result = $caller->makeLoginCall('gryzz@mail.lviv.ua', '4188991524');
                    $response->setIsLogined($isLogined);
                } elseif ($request->isFormPosted()) {
                    $result = $caller->makeLoginCall($request->getEmail(), $request->getPassword());
                    
                    if ($result == "true") {
                        $response->setIsLogined(true);
                    } else {
                        $response->setError("Error happened");
                    }
                }

                switch ($request->getSection()) {
                    case 'registration' :
                        if (!$isLogined) {
                            $registrationComponent = new RegistrationComponent();
                            $registrationResponse = $registrationComponent->execute();

                            $response->addChild('content', $registrationResponse);
                        }
                        break;
                }
                
		return $response;
	}
}