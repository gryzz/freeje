<?
session_start();

require_once 'include/global.php';
require_once PATH_PRESENTATION . 'ActivatePage/ActivatePage.php';


$page = new ActivatePage();

$reponse = $page->execute();


?>
