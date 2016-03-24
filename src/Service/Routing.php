<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 15.03.16
 * Time: 12:18
 */

namespace App\Service;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class Routing
{
    public $requestContext;
    public $matcher;
    public $resolver;
    public $urlGenerator;

    public function __construct(Request $request, RequestContext $requestContext)
    {
        $this->requestContext = $requestContext;

        $locator = new FileLocator(__DIR__);
        $loader = new YamlFileLoader($locator);
        $routeCollection = $loader->load('../../config/routes.yml');

        $this->matcher = new UrlMatcher($routeCollection, $requestContext);
        $this->resolver = new ControllerResolver();
        $this->urlGenerator = new UrlGenerator($routeCollection, $requestContext);
    }
}