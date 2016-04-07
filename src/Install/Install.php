<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 07.04.16
 * Time: 16:01
 */

namespace App\Install;


use Exception;
use Symfony\Component\Filesystem\Filesystem;
use Composer\Script\Event;

class Install
{
    public static function install(Event $event)
    {
        $fs = new Filesystem();
        try {
            $cacheDir = __DIR__ . '/../cache';
            $testfile = $cacheDir . '/test';
            $fs->dumpFile($testfile, 'test');
            $fs->remove($testfile);

            $event->getIO()->write("<info>Writing doctrine entity proxies...</info>\n");
            exec('php vendor/bin/doctrine orm:generate:proxies');
        } catch (Exception $e) {
            $event->getIO()->write("<error>" . $e->getMessage() . "</error>\n");
        }
    }
}