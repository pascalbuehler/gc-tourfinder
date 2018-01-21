<?php

use Core\InputParameters;
use Core\PageRenderer;
use Core\Router;
use Helper\ConfigHelper;

// SECURITY
// Unset PHP_SELF because it allows SQL-Injection and Cross-Site-Scripting
unset($PHP_SELF);
unset($_SERVER['PHP_SELF']);

// ERROR REPORTING
error_reporting(E_ALL);
ini_set('dislay_errors', 1);
ini_set('dislay_startup_errors', 1);

// TIMEZONE
date_default_timezone_set('UTC');

// AUTOLOAD
spl_autoload_register(function($class) {
    $parts = explode('\\', $class);
    $classFilename = '../src/'.implode('/', $parts).'.php';
    if(file_exists($classFilename)) {
        require $classFilename;
    }
});

// ENVIRONMENT
$env = getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'dist';

// INPUT PARAMETERS
InputParameters::init();

// CONFIG
ConfigHelper::init('../src/Config/'.$env.'.php');

// ROUTE
$rewrite = filter_input(INPUT_GET, 'rewrite', FILTER_SANITIZE_STRING);
if($rewrite) {
    $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);
    $routeResult = Router::route($url);
    if(!$routeResult) {
        throw new Exception('No route found');
    }
}

// RUN
PageRenderer::render(InputParameters::get('page'));

