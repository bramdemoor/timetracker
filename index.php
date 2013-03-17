<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

define('SERVER_ROOT' , '/Applications/MAMP/htdocs/timetracker/');

use Library\Loader\SplClassLoader;

require_once __DIR__ . "/Library/Loader/SplClassLoader.php";
$autoloader = new SplClassLoader();
$autoloader->register();

//require_once(SERVER_ROOT . '/Library/' . 'Router.php');

$router = new \Library\Router();





