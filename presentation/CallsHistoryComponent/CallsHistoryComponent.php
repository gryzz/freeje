<?
require_once PATH_PRESENTATION . 'common/ComponentBase.php';
require_once PATH_PRESENTATION . 'CallsHistoryComponent/CallsHistoryResponse.php';
require_once PATH_PRESENTATION . 'CallsHistoryComponent/CallsHistoryRequest.php';
require_once PATH_APPLICATION . 'Caller.php';
require_once PATH_APPLICATION . 'Translator.php';

class CallsHistoryComponent extends ComponentBase {
    private $statusMap = array(
        'ANSWER' => 'Answered',
        'ANSWERED' => 'Answered',
        'BUSY' => 'Busy',
        'NOANSWER' => 'No answer'
    );
    
    public function execute() {
        $response = new CallsHistoryResponse();
        $request = new CallsHistoryRequest();
        
        if ($request->getDateFrom() and $request->getDateTo()) {
            $response->setDateFrom($request->getDateFrom());
            $response->setDateTo($request->getDateTo());

            $caller = Caller::getInstance();

            $dateFrom = $this->reformatDate($request->getDateFrom());
            $dateTo = $this->reformatDate($request->getDateTo());
            
            $result = $caller->makeGetCallHistory($dateFrom, $dateTo);

            $translator = Translator::getInstance();
            $data = array();
            foreach ($result as $row) {
                $row['terminatecause'] = $translator->getLable($this->statusMap[$row['terminatecause']]);
                $row['sessionbill'] = round($row['sessionbill'], 2) . '$';
                $row['sessiontime'] = $row['sessiontime'] . ' ' . $translator->getLable('seconds');

                list($date, $time) = split(' ', $row['starttime']);
                list($year, $day, $month) = split('-', $date);

                $row['starttime'] = $day . '/' . $month . '/' . $year . ' ' . $time;

                $data[] = $row;
            }

            $response->setData($data);
        }
        
        return $response;
    }

    private function reformatDate($date) {
        list($day, $month, $year) = split('/', $date);
        return $year . $month . $day;
    }
    
}