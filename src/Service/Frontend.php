<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 29.03.16
 * Time: 19:50
 */

namespace App\Service;


use App\Entity\Content;
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

    /**
     * Checks if the file specified by the uri exists and sets related class properties.
     *
     * @param $uri
     * @param ContainerInterface $services
     * @return void
     */
    public function init($uri, ContainerInterface $services)
    {
        $this->services = $services;
        $this->fs = new Filesystem();

        $this->uri = strtok($uri, '?');
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
     * Replaces the snippets in the html content.
     *
     * @return void
     */
    public function replaceSnippets()
    {
        $this->html = file_get_contents($this->file);
        $contents = $this->services->get('database')->getLoader('App\Entity\Content')->loadAll();

        /** @var Content $content */
        foreach ($contents as $content) {
            if ($content->isActive() && strpos($this->html, $content->getHash()) !== false) {
                $type = $this->services->get($content->getType());
                $this->html = str_replace('<!--' . $content->getHash() . '-->', $type->render($content->getId()), $this->html);
            }
        }
    }

    /**
     * Displays the HTML content of the requested file, either from cache or freshly generated.
     *
     * @return void
     */
    public function output()
    {
        $cacheFile = __DIR__ . '/../../cache/frontend' . $this->uri;
        if ($this->fs->exists($cacheFile) && filemtime($cacheFile) > time() - $this->services->get('config')->get('cache.lifetime')) {
            $this->html = file_get_contents($cacheFile);
        } else {
            $this->replaceSnippets();
            $this->fs->dumpFile($cacheFile, $this->html);
        }

        echo $this->html;
    }
}