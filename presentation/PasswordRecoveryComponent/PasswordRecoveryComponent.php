<?
require_once PATH_PRESENTATION . 'common/ComponentBase.php';
require_once PATH_PRESENTATION . 'PasswordRecoveryComponent/PasswordRecoveryRequest.php';
require_once PATH_PRESENTATION . 'PasswordRecoveryComponent/PasswordRecoveryResponse.php';


class PasswordRecoveryComponent extends ComponentBase {

    public function execute() {
        $request = new PasswordRecoveryRequest();
        $response = new PasswordRecoveryResponse();

        if ($request->getEmail()) {
            $caller = Caller::getInstance();

            $code = $caller->makePasswordRecoveryCall($request->getEmail());

            $translator = Translator::getInstance();

            if ($code == 0) {
                $response->setMessage($translator->getLable('Your password has been sent.'));
            } else {
                $response->setError($translator->getLable('Error occured, go back and try again'));
            }
        }

        return $response;
    }
}