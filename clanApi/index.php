<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/Autoload.php';
require_once 'config/routes.php';

use vendor\Router;

$autoload = new Autoload();
$autoload->execute();

$routeHandle = new Router($routes);
$routeHandle->run();