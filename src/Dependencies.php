<?php


use Symfony\Component\HttpFoundation\Request;

$injector = new \Auryn\Injector;


$request = Request::createFromGlobals();
$injector->share($request);


$twig = new \Twig_Environment(
    new \Twig_Loader_Filesystem('../resources/views/'),
    ['cache' => '../storage/twig-cache/']
);
$injector->share($twig);


$injector->define('Jehaby\Homepage\Page\FilePageReader', [
    ':pageFolder' => __DIR__ . '/../resources/pages/',
]);
$injector->alias('Jehaby\Homepage\Page\PageReader', 'Jehaby\Homepage\Page\FilePageReader');
$injector->share('Jehaby\Homepage\Page\FilePageReader');


return $injector;
