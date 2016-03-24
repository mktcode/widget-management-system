<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Entity\Content;
use App\Service\ContentTypeCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

// services
$services = new ContainerBuilder();
$services->addCompilerPass(new ContentTypeCompilerPass());
$loader = new YamlFileLoader($services, new FileLocator(__DIR__));
$loader->load('../config/services.yml');
$services->compile();

// get page file
$uri = strtok($_SERVER["REQUEST_URI"], '?');
if (substr($uri, -1) == '/') $uri .= '/index.html';
$file = __DIR__ . $uri;
if (!file_exists($file)) {
    header("HTTP/1.0 404 Not Found");
    echo '<h1>404 Not Found</h1>';
    die();
}
$page = file_get_contents($file);

// replace snippets
$contents = $services->get('database')->getLoader('App\Entity\Content')->loadAll();
/** @var Content $content */
foreach ($contents as $content) {
    $type = $services->get($content->getType());
    $page = str_replace('<!--' . $content->getHash() . '-->', $type->render($content->getId()), $page);
}

// output page
echo $page;