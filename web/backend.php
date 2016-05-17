<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Service\ContentTypeCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use App\Service\Routing;

// services
$services = new ContainerBuilder();
$services->addCompilerPass(new ContentTypeCompilerPass());
$loader = new YamlFileLoader($services, new FileLocator(__DIR__));
$loader->load('../config/services.yml');
$services->compile();

/** @var Request $request */
$request = $services->get('request');

/** @var Routing $routing */
$routing = $services->get('routing');

// handle request
$response = new Response();
try {
    // match route
    $request->attributes->add($routing->matcher->match($request->getPathInfo()));

    // check login
    if (!array_key_exists('user', $_SESSION) && $request->attributes->get('_route') != 'login') {
        header('Location: ' . $routing->urlGenerator->generate('login'));
        die();
    } else {
        // get controller for route
        $controller = $routing->resolver->getController($request);
        $controller[0]->setContainer($services);
        $arguments = $routing->resolver->getArguments($request, $controller);

        // execute controller
        $response = call_user_func_array($controller, $arguments);
    }
} catch (ResourceNotFoundException $e) {
    // 404
    $response->setContent($e->getMessage())->setStatusCode(404);
} catch (Exception $e) {
    // 500
    $response->setContent($e->getMessage())->setStatusCode(500);
}

// send the response to the browser
$response->send();