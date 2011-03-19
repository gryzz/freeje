<?
require_once PATH_PRESENTATION . 'common/ComponentBase.php';
require_once PATH_PRESENTATION . 'ChangePasswordComponent/ChangePasswordRequest.php';
require_once PATH_PRESENTATION . 'ChangePasswordComponent/ChangePasswordResponse.php';


class ChangePasswordComponent extends ComponentBase {

    public function execute() {
        $request = new ChangePasswordRequest();
        $response = new ChangePasswordResponse();
        $translator = Translator::getInstance();

        if ($request->getNewPassword()) {
            $user = UserQuery::create()->findOneById($_SESSION['id']);
            
            if ($user->getPassword() != $request->getOldPassword()) {
                $response->setError('Old password is not correct.');
            } else {
                $caller = Caller::getInstance();

                $result = $caller->makeChangePassowrdCall($request->getOldPassword(), $request->getNewPassword());

                if ($result) {
                    $user->setPassword($request->getNewPassword());
                    $user->save();

                    $response->setMessage('Password has been changed');
                } else {
                    $response->setError('Something went wrong, go back and try again.');
                }

                
            }
        }

        return $response;
    }
}