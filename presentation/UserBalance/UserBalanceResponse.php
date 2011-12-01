<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class UserBalanceResponse extends ResponseBase {
	
    public function __construct() {
        parent::__construct('userBalance.html');
        
        parent::declareVars(
            array(
                'balance'
            )
        );
    }

    public function setBalance($balance) {
        $this->set('balance', $balance);
    }

}
?>