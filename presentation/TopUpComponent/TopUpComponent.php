<?
require_once PATH_PRESENTATION . 'common/ComponentBase.php';
require_once PATH_PRESENTATION . 'TopUpComponent/TopUpResponse.php';

class TopUpComponent extends ComponentBase {

    public function execute() {
        $response = new TopUpResponse();

        return $response;
    }
}

?>