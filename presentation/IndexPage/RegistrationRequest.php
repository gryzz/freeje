<?
require_once PATH_PRESENTATION . 'common/RequestBase.php';

class RegistrationRequest extends RequestBase {

    public function isFormPosted() {
        return $this->hasParameter('form_posted');
    }
}

?>
