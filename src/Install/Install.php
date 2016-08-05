<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 07.04.16
 * Time: 16:01
 */

namespace App\Install;

use App\Service\ContentTypeCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;

class Install
{
    public static function install(Event $event)
    {
        // services
        $services = new ContainerBuilder();
        $services->addCompilerPass(new ContentTypeCompilerPass());
        $services->addCompilerPass(new RegisterListenersPass());
        $loader = new YamlFileLoader($services, new FileLocator(__DIR__));
        $loader->load('../../config/services.yml');
        $services->compile();

        $fs = new Filesystem();

        try {
            // check cache directory
            $event->getIO()->write("\n<info>Testing Cache...</info>");
            $services->get('cache')->write('test', 'test');
            $services->get('cache')->clear();

            // generate schema
            $event->getIO()->write("<info>Creating Schema (if not exists)...</info>");
            $services->get('database')->createSchema();

            // generate doctrine proxies
            $event->getIO()->write("<info>Writing doctrine entity proxies...</info>");
            exec('php vendor/bin/doctrine orm:generate:proxies');

            // installing demo template
            if ($services->get('config')->get('demo')) {
                $event->getIO()->write("<info>Installing the demo template...</info>");
                $fs->mirror(__DIR__ . '/../../templates/frontend/demo', __DIR__ . '/../../web/');
            }

            // write .htaccess
            $event->getIO()->write("<info>Writing .htaccess file...</info>");
            $fs->copy(__DIR__ . '/../../web/.htaccess.dist', __DIR__ . '/../../web/.htaccess');

            // display installed message
            $event->getIO()->write("\nInstallation successful!\n");
        } catch (\Exception $e) {
            $event->getIO()->write("<error>" . $e->getMessage() . "</error>\n");
        }
    }
}