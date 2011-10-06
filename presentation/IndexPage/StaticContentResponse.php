<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class StaticContentResponse extends ResponseBase {

    const HOME_PAGE_TEMPLATE = 'static/home.html';
    const CONTACTS_TEMPLATE = 'static/contacts.html';
    const HOW_IT_WORKS_TEMPLATE = 'static/howItWorks.html';
    const USER_ACTIVATED_TEMPLATE = 'static/userActivated.html';
    const FAQ_TEMPLATE = 'static/FAQ.html';
    const DOWNLOAD_TEMPLATE = 'static/download.html';

    public function __construct($template = self::HOME_PAGE_TEMPLATE) {
        parent::__construct($template);

        parent::declareVars(array());

    }
}
?>