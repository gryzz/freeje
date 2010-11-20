<?
require_once (PATH_PRESENTATION . 'common/interfaces/IPage.php');
require_once (PATH_PRESENTATION . 'IndexPage/IndexRequest.php');
require_once (PATH_PRESENTATION . 'IndexPage/IndexResponse.php');

class IndexPage implements IPage {
	
	public function execute() {
		$response = new IndexResponse();
		
		return $response;
	}
}