<?
require_once PATH_PRESENTATION . 'common/ComponentBase.php';
require_once PATH_PRESENTATION . 'IndexPage/StaticContentResponse.php';

class StaticContentComponent extends ComponentBase {

    public function execute($page = null) {
        $response = new StaticContentResponse($this->getTemplate($page));

        return $response;
    }

    public function getTemplate($page = null) {
        switch ($page) {
            case 'contacts' :
                return StaticContentResponse::CONTACTS_TEMPLATE;
                break;

            case 'howItWorks':
                return StaticContentResponse::HOW_IT_WORKS_TEMPLATE;
                break;

            case 'download':
                return StaticContentResponse::DOWNLOAD_TEMPLATE;
                break;
            
            default : 
                return StaticContentResponse::HOME_PAGE_TEMPLATE;
                break;
        }

    }
}

?>