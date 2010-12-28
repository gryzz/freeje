<?
require_once PATH_PRESENTATION . 'common/ComponentBase.php';
require_once PATH_PRESENTATION . 'IndexPage/RegistrationRequest.php';
require_once PATH_PRESENTATION . 'IndexPage/RegistrationResponse.php';

class RegistrationComponent extends ComponentBase {
    
    public function execute () {
        $response = new RegistrationResponse();
        
        return $response;
    }
}

?>
