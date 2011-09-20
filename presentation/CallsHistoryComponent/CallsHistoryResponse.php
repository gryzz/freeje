<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class CallsHistoryResponse extends ResponseBase {
	
    public function __construct() {
        parent::__construct('callsHistory.html');
        
        parent::declareVars(
            array(
                'dateFrom',
                'dateTo',
                'data'
            )
        );
    }

    public function setData($data) {
        $this->set('data', $data);
    }

    public function setDateFrom($dateFrom) {
        $this->set('dateFrom', $dateFrom);
    }

    public function setDateTo($dateTo) {
        $this->set('dateTo', $dateTo);
    }

}
?>