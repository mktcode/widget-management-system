<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 29.03.16
 * Time: 19:50
 */

namespace App\Service;


use App\Entity\Content;
use App\Entity\ContentCategory;
use App\Event\PostEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

class Frontend
{
    /**
     * @var ContainerInterface
     */
    private $services;

    /**
     * @var Filesystem
     */
    private $fs;

    private $uri;

    private $file;

    private $html;

    public function __construct(ContainerInterface $services)
    {
        $this->services = $services;
    }

    /**
     * Checks if the file specified by the uri exists and sets related class properties.
     *
     * @return void
     */
    public function init()
    {
        $this->fs = new Filesystem();

        // set file path by uri
        $this->uri = strtok($_SERVER["REQUEST_URI"], '?');
        if (substr($this->uri, -1) == '/') $this->uri .= 'index.html';
        if (substr($this->uri, -5) != '.html') $this->uri .= '.html';
        $this->file = __DIR__ . '/../../web' . $this->uri;

        # fallback check for missing file, although mod_rewrite should take care of this
        if (!$this->fs->exists($this->file)) {
            header("HTTP/1.0 404 Not Found");
            echo '<h1>404 Not Found</h1>';
            die();
        }
    }

    /**
     * Displays the HTML content of the requested file, either from cache or freshly generated.
     *
     * @return void
     */
    public function output()
    {
        if ($this->services->get('cache')->isCached($this->uri)) {
            $this->html = $this->services->get('cache')->read($this->uri);
        } else {
            $this->replaceSnippets();
            $this->services->get('cache')->write($this->uri, $this->html);
        }

        echo $this->html;
    }

    /**
     * Replaces the snippets in the html content.
     *
     * @return void
     */
    public function replaceSnippets()
    {
        $this->html = file_get_contents($this->file);

        // replace single contents
        $contents = $this->services->get('database')->getLoader('App\Entity\Content')->loadAll();
        /** @var Content $content */
        foreach ($contents as $content) {
            if ($content->isActive() && strpos($this->html, $content->getHash()) !== false) {
                $type = $this->services->get($content->getType());
                $this->html = str_replace('<!--' . $content->getHash() . '-->', $type->render($content->getId()), $this->html);
            }
        }

        // replace categories
        $contentCategories = $this->services->get('database')->getLoader('App\Entity\ContentCategory')->loadAll();
        /** @var ContentCategory $category */
        foreach ($contentCategories as $category) {
            if (strpos($this->html, $category->getHash()) !== false) {
                $categoryHtml = '';
                /** @var Content $content */
                foreach ($category->getContents() as $content) {
                    if ($content->isActive()) {
                        $type = $this->services->get($content->getType());
                        $categoryHtml .= $type->render($content->getId());
                    }
                }

                $this->html = str_replace('<!--' . $category->getHash() . '-->', $categoryHtml, $this->html);
            }
        }
    }
}