<?
require_once PATH_PRESENTATION . 'common/ComponentBase.php';
require_once PATH_PRESENTATION . 'IndexPage/RegistrationRequest.php';
require_once PATH_PRESENTATION . 'IndexPage/RegistrationResponse.php';
require_once PATH_APPLICATION . 'Caller.php';

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
                        $request->getAddress(),
                        $request->getCity(),
                        222,
                        $request->getPostcode()
                    );
            
            if ($freejeId) {
                $user = new User();

                $user->setFreejeId($freejeId);
                $user->setEmail($request->getEmail());
                $user->setPhone($request->getPhone());
                $user->setFirstname($request->getFirstname());
                $user->setLastname($request->getLastname());
                $user->setAddress($request->getAddress());
                $user->setCity($request->getCity());
                //It's brutal hack
                $user->setCountry(222);
                $user->setPostcode($request->getPostcode());

                $user->save();

            } else {
                $response->setEmail($request->getEmail());
                $response->setPhone($request->getPhone());
                $response->setFirstname($request->getFirstname());
                $response->setLastname($request->getLastname());
                $response->setAddress($request->getAddress());
                $response->setCity($request->getCity());
                $response->setCountry($request->getCountry());
                $response->setPostcode($request->getPostcode());
            }
        }
        
        return $response;
    }
}

?>
