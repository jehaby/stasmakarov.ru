<?php


namespace Jehaby\Homepage\Page;

use InvalidArgumentException;
use League\CommonMark\CommonMarkConverter;


class FilePageReader implements PageReader
{

    /**
     * @var string
     */
    private $pageFolder;

    /**
     * @var CommonMarkConverter
     */
    private $converter;


    public function __construct($pageFolder, CommonMarkConverter $converter)
    {
        if (!is_string($pageFolder)) {
            throw new InvalidArgumentException('pageFolder must be a string');
        }
        $this->pageFolder = $pageFolder;

        $this->converter = $converter;
    }


    public function readBySlug($slug)
    {
        if (!is_string($slug)) {
            throw new InvalidArgumentException('Slug must be a string.');
        }

        $path = "{$this->pageFolder}{$slug}.md";

        if (!file_exists($path)) {
            throw new PageNotFoundException($slug);
        }

        return $this->converter->convertToHtml(file_get_contents($path));

    }


}