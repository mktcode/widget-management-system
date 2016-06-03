<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Service\ContentTypeCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

// services
$services = new ContainerBuilder();
$services->addCompilerPass(new ContentTypeCompilerPass());
$services->addCompilerPass(new RegisterListenersPass());
$loader = new YamlFileLoader($services, new FileLocator(__DIR__));
$loader->load('../config/services.yml');
$services->compile();

// output
$frontend = $services->get('frontend');
$frontend->init();
$frontend->output();