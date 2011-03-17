<?

require_once 'include/global.php';
require_once PATH_PRESENTATION . 'IndexPage/IndexPage.php';
require_once PATH_PRESENTATION . 'TopUpComponent/TopUpComponent.php';

switch ($_GET['page']) {
    case 'topUp':
        $topUpComponent = new TopUpComponent();

        $response = $topUpComponent->execute('selectPaymentMethod');
        break;
}

$response->display(true);

?>
