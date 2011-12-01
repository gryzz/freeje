<?
require_once PATH_PRESENTATION . 'common/ComponentBase.php';
require_once PATH_PRESENTATION . 'UserBalance/UserBalanceResponse.php';
require_once PATH_APPLICATION . 'Caller.php';

class UserBalanceComponent extends ComponentBase {
    public function execute() {
        $response = new UserBalanceResponse();
        
        $caller = Caller::getInstance();
        $result = $caller->makeGetUserDataCall();
        
        $response->setBalance(number_format($result['credit'], 2, ',', ' '));
        return $response;
    }
}