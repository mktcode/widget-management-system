<?php

// services
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$services = new ContainerBuilder();
$loader = new YamlFileLoader($services, new FileLocator(__DIR__));
$loader->load('config/services.yml');
$services->compile();

return ConsoleRunner::createHelperSet($services->get('database')->em);