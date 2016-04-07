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
    public function clear()
    {
        $fs = new Filesystem();
        $fs->remove(glob(__DIR__ . '/../../cache/frontend/*'));
    }
} 