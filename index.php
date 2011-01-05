<?
session_start();

require_once 'include/global.php';
require_once PATH_PRESENTATION . 'IndexPage/IndexPage.php';


$page = new IndexPage();

$reponse = $page->execute();

$reponse->display(true);

?>