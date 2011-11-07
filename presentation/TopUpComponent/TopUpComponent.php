<?
require_once PATH_PRESENTATION . 'common/ComponentBase.php';
require_once PATH_PRESENTATION . 'TopUpComponent/TopUpRequest.php';
require_once PATH_PRESENTATION . 'TopUpComponent/TopUpResponse.php';
require_once PATH_PRESENTATION . 'TopUpComponent/SelectPaymentMethodResponse.php';
require_once PATH_PRESENTATION . 'TopUpComponent/PaymentRedirectResponse.php';
require_once PATH_PRESENTATION . 'TopUpComponent/PaymentUserContentResponse.php';

require_once ROOT . 'propel/runtime/lib/Propel.php';

require_once PATH_APPLICATION . 'Caller.php';

class TopUpComponent extends ComponentBase {

    public function execute($section = 'main') {

        $request = new TopUpRequest();

        switch ($section) {
            case 'main':
                if ($request->isPaymentFormPosted()) {
                    
                    $paymentForm = $this->getPaymentForm($request);
                    if ($paymentForm['UserContent']) {
                        $response = new PaymentUserContentResponse();
                        
                        $response->setUserContent($paymentForm['UserContent']);
                    } else {
                        $response = new PaymentRedirectResponse();

                        $response->setAction($paymentForm['FormAction']);
                        $response->setCharset($paymentForm['encoding']);
                        $response->setFields($paymentForm['Fields']);
                    }
                } else {
                    $response = new TopUpResponse();
                }
                
                break;

            case 'selectPaymentMethod':
                try {
                    $propel = Propel::init(PATH_PROPEL_CONF);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }

                $paymentMethods = PaymentMethodPeer::doSelect(new Criteria());

                $paymentMethodsArray = $this->buildPaymentMethodsArray($paymentMethods, $request->getAmount());
                $finalPaymentAmounts = $this->buildFinalPaymentAmountsArray($paymentMethods, $request->getAmount());
                
                $response = new SelectPaymentMethodResponse();
                $response->setPaymentMethods($paymentMethodsArray);
                $response->setFinalPaymentAmounts($finalPaymentAmounts);
                $response->setAmount($request->getAmount());
                break;
        }
        

        return $response;
    }

    public function buildPaymentMethodsArray($paymentMethods, $payAmount) {
        $paymentMethodsArray = array();

        foreach ($paymentMethods as $paymentMethod) {
            $totalAmount = round($payAmount * $paymentMethod->getCours(), 2);
            $paymentMethodsArray[$paymentMethod->getRequest()] = $paymentMethod->getDescription() . '           ' . $totalAmount . ' ' . $paymentMethod->getValute();
        }

        return $paymentMethodsArray;
    }

    public function buildFinalPaymentAmountsArray($paymentMethods, $payAmount) {
        $paymentMethodsArray = array();

        foreach ($paymentMethods as $paymentMethod) {
            $totalAmount = round($payAmount * $paymentMethod->getCours(), 2);

            $paymentMethodsArray[$paymentMethod->getRequest()]['amount'] = $payAmount;
            $paymentMethodsArray[$paymentMethod->getRequest()]['value'] = $totalAmount . ' ' . $paymentMethod->getValute();
        }

        return $paymentMethodsArray;
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