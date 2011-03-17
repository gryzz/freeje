<?
require_once PATH_PRESENTATION . 'common/ComponentBase.php';
require_once PATH_PRESENTATION . 'TopUpComponent/TopUpRequest.php';
require_once PATH_PRESENTATION . 'TopUpComponent/TopUpResponse.php';
require_once PATH_PRESENTATION . 'TopUpComponent/SelectPaymentMethodResponse.php';
require_once PATH_PRESENTATION . 'TopUpComponent/PaymentRedirectResponse.php';

require_once PATH_APPLICATION . 'Caller.php';

class TopUpComponent extends ComponentBase {

    public function execute($section = 'main') {

        $request = new TopUpRequest();

        switch ($section) {
            case 'main':
                if ($request->isPaymentFormPosted()) {
                    
                    $paymentForm = $this->getPaymentForm($request);

                    $response = new PaymentRedirectResponse();

                    $response->setAction($paymentForm['FormAction']);
                    $response->setCharset($paymentForm['encoding']);
                    $response->setFields($paymentForm['Fields']);

                } else {
                    $response = new TopUpResponse();
                }
                
                break;

            case 'selectPaymentMethod':
                $caller = Caller::getInstance();

                $paymentData = $caller->makeGetPaymentMethodsCall($request->getAmount());

                $paymentMethods = $this->buildPaymentMethodsArray($paymentData['pay_methods']);
                $finalPaymentAmounts = $this->buildFinalPaymentAmountsArray($paymentData['pay_methods']);
                
                $response = new SelectPaymentMethodResponse();
                $response->setPaymentMethods($paymentMethods);
                $response->setFinalPaymentAmounts($finalPaymentAmounts);
                break;
        }
        

        return $response;
    }

    public function buildPaymentMethodsArray($data) {
        $paymentMeythods = array();

        foreach ($data as $paymentMethod) {
            $paymentMeythods[$paymentMethod['request']] = $paymentMethod['description'] . '           ' . $paymentMethod['full_summ'] . ' ' . $paymentMethod['valute'];
        }

        return $paymentMeythods;
    }

    public function buildFinalPaymentAmountsArray($data) {
        $paymentAmounts = array();

        foreach ($data as $paymentMethod) {
            $paymentAmounts[$paymentMethod['request']]['amount'] = $paymentMethod['full_summ'];
            $paymentAmounts[$paymentMethod['request']]['value'] = $paymentMethod['full_summ'] . ' ' . $paymentMethod['valute'];
        }

        return $paymentAmounts;
    }

    public function getPaymentForm($request) {
        $user = UserQuery::create()->findOneById($_SESSION['id']);

        $caller = Caller::getInstance();

        $paymentUrl = $caller->makeGetPaymentUrlCall($user->getFreejeId(), $request->getFinalAmount(), $request->getPaymentMethod());
        $checkOutId = $caller->makeGetLatestCheckOutIdCall();
        $paymentForm = $caller->makeGetPaymentFormCall($checkOutId);

        return $paymentForm;
    }
}

?>