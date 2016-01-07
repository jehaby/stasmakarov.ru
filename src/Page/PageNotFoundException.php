<?php


namespace Jehaby\Homepage\Page;


class PageNotFoundException extends \Exception
{

    public function __construct($slug, $code = 0, \Exception $previous = null)
    {
        $message = "No page with the slug `$slug` was found";
        parent::__construct($message, $code, $previous);
    }

}