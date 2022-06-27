<?php
require_once(__DIR__.'/vendor/autoload.php');



$app = new \Atabasch\System\Application;
$app->init();

$request = new \Atabasch\System\Request;

exit;

//$app->setRoutes();

$app->run();

?>
