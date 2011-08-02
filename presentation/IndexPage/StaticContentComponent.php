<?
require_once PATH_PRESENTATION . 'common/interfaces/IComponent.php';
require_once PATH_PRESENTATION . 'IndexPage/StaticContentResponse.php';

class StaticContentComponent implements IComponent {

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