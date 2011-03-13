<?
require_once PATH_PRESENTATION . 'common/ComponentBase.php';
require_once PATH_PRESENTATION . 'IndexPage/RegistrationRequest.php';
require_once PATH_PRESENTATION . 'IndexPage/RegistrationResponse.php';
require_once PATH_APPLICATION . 'Caller.php';
require_once PATH_APPLICATION . 'Translator.php';

class RegistrationComponent extends ComponentBase {
    
    public function execute () {
        $request = new RegistrationRequest();
        $response = new RegistrationResponse();

        if ($request->isFormPosted()) {
            $caller = Caller::getInstance();

            $freejeId = $caller->makeRegisterCall(
                        $request->getEmail(),
                        $request->getPhone(),
                        $request->getFirstname(),
                        $request->getLastname(),
                        '',
                        '',
                        222,
                        ''
                    );
            
            if ($freejeId) {
                $user = new User();

                $user->setFreejeId($freejeId);
                $user->setEmail($request->getEmail());
                $user->setPhone($request->getPhone());
                $user->setFirstname($request->getFirstname());
                $user->setLastname($request->getLastname());

                $response->setSuccessRegistration(true);

                $user->save();

            } else {

                $translator = Translator::getInstance();

                $response->setEmail($request->getEmail());
                $response->setPhone($request->getPhone());
                $response->setFirstname($request->getFirstname());
                $response->setLastname($request->getLastname());

                $response->setSuccessRegistration(false);

                $response->setError($translator->getLable('registration error'));
            }
        }
        
        return $response;
    }
}

?>
