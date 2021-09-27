<?php

use Core\Exception\NotFoundException;
use Core\Session\Session;
use Router\Router;

require "../vendor/autoload.php";

Session::sessionInstance()->initializeSession();

// Constants
define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR);
define('PATH_ORIGIN',  '/nowa-innov' . DIRECTORY_SEPARATOR);

//var_dump('PATH_ORIGIN',  '/nowa-innov' . DIRECTORY_SEPARATOR); die();
$router = new Router($_GET['url']);

/* FrontController routes */

//Homepage Tab
//var_dump($router); die;
$router->get((String)'/', (String)'App\Controllers\FrontController@home');

//var_dump($v); die;




// Searching Innovations & Strategy

// Faq & tarifs

$router->get('faq', 'App\Controllers\FrontController@faq');
$router->get('tarifs', 'App\Controllers\FrontController@tarifs');

// CTA
$router->get('CTA', 'App\Controllers\FrontController@CTA');
$router->post('CTA', 'App\Controllers\FrontController@CTA');

// CTA2
$router->get('CTA2', 'App\Controllers\FrontController@CTA2');
$router->post('CTA2', 'App\Controllers\FrontController@CTA2');

// Contact
$router->get('contact', 'App\Controllers\FrontController@contact');
$router->post('contact', 'App\Controllers\FrontController@contact');

// Login
/* End FrontController routes */

/* BackController routes */

// Logout
/* End BackController routes */

// function dump($variable)
// {
//     echo '<pre>';
//     print_r($variable);
//     echo '</pre>';
//     die();
// }

try {
    $router->run();
} catch (NotFoundException $e) {
    return $e->error404();
}
