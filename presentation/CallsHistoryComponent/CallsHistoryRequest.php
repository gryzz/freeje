<?
require_once PATH_PRESENTATION . 'common/RequestBase.php';

class CallsHistoryRequest extends RequestBase {

    public function getDateFrom() {
        if ($this->hasParameter('dateFrom')) {
            return $this->getParameter('dateFrom');
        }
        
        return null;
    }
    
    public function getDateTo() {
        if ($this->hasParameter('dateTo')) {
            return $this->getParameter('dateTo');
        }
        
        return null;
    }
}