<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 07.04.16
 * Time: 15:45
 */

namespace App\Service;


use Symfony\Component\Filesystem\Filesystem;

class Cache
{
    private $cacheDir;

    /**
     * @var Filesystem
     */
    private $fs;

    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->cacheDir = __DIR__ . '/../../cache/frontend';
        $this->fs = new Filesystem();
        $this->config = $config;
    }

    public function clear()
    {
        $this->fs->remove(glob($this->cacheDir . '/*'));
    }

    public function read($file)
    {
        return file_get_contents($this->cacheDir . '/' . $file);
    }

    public function write($file, $html)
    {
        $this->fs->dumpFile($this->cacheDir . '/' . $file, $html);
    }

    public function isCached($file)
    {
        $cacheFile = $this->cacheDir . '/' . $file;
        return $this->fs->exists($cacheFile) && filemtime($cacheFile) > time() - $this->config->get('cache.lifetime');
    }
}