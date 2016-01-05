<?php

namespace Jehaby\Homepage;

use Symfony\Component\HttpFoundation\Request;

$environment = 'development';
error_reporting(E_ALL);

require '../vendor/autoload.php';
$injector = include('Dependencies.php');

$request = Request::createFromGlobals();
$injector->share($request);


// $whoops = new \Whoops\Run;

// /**
//  * Register the error handler
//  */
// $whoops = new \Whoops\Run;
// if ($environment !== 'production') {
//     $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
// } else {
//     $whoops->pushHandler(function($e){
//         echo 'Friendly error page and send an email to the developer';
//     });
// }
// $whoops->register();


$routeDefinitionCallback = function (\FastRoute\RouteCollector $r) {
    $routes = include('Routes.php');
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
};


$twig = new \Twig_Environment(
    new \Twig_Loader_Filesystem('../resources/views/'),
    ['cache' => '../storage/twig-cache/']
);
$injector->share($twig);


$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        $response->setContent('404 - Page not found');
        $response->setStatusCode(404);
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response->setContent('405 - Method not allowed');
        $response->setStatusCode(405);
        break;
    case \FastRoute\Dispatcher::FOUND:
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];

        $class = $injector->make($className);
        $class->$method($vars);
        break;
}



