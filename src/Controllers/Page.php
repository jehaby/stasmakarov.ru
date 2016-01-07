<?php


namespace Jehaby\Homepage\Controllers;

use Jehaby\Homepage\PageNotFoundException;
use Jehaby\Homepage\Page\PageReader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;


class Page
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var PageReader
     */
    private $pageReader;


    public function __construct(Request $request, Response $response, Twig_Environment $twig, PageReader $pageReader)
    {
        $this->request = $request;
        $this->response = $response;
        $this->twig = $twig;
        $this->pageReader = $pageReader;
    }

    public function show($params)
    {
        $slug = $params['slug'];

        try {
            $data['content'] = $this->pageReader->readBySlug($slug);
        } catch (PageNotFoundException $e) {
            $this->response->setStatusCode(404);
            return $this->response->setContent('404 - Page not found');
        }

        $html = $this->twig->render('page.twig', $data);
        return $this->response->setContent($html);
    }

}