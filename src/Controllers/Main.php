<?php

namespace Jehaby\Homepage\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;


class Main
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;


    private $twig;


    public function __construct(Request $request, Response $response, Twig_Environment $twig)
    {
        $this->request = $request;
        $this->response = $response;
        $this->twig = $twig;
    }


    public function index()
    {
        $this->response->setContent($this->twig->render('index.twig'))->send();
    }

    public function contacts()
    {
        
    }

}