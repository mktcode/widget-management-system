<?php

namespace App\Controller;

use App\ContentType\ContentType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Persisters\Entity\EntityPersister;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class Controller implements ContainerAwareInterface
{
    /**
     * @var ContainerBuilder
     */
    protected $services;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $services A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $services = null)
    {
        $this->services = $services;
    }

    /**
     * Gets a services.
     *
     * @param $id
     * @return object
     */
    public function getService($id)
    {
        return $this->services->get($id);
    }

    /**
     * Gets a content type. (Alias for getService)
     *
     * @param $contentTypeId
     * @return ContentType
     */
    public function getContentType($contentTypeId)
    {
        return $this->getService($contentTypeId);
    }

    /**
     * Get the entity manager.
     *
     * @return EntityManager|null
     */
    public function getEntityManager()
    {
        return $this->getService('database')->em;
    }

    /**
     * Gets an entity loader for a given entity class.
     *
     * @param $entityClass
     * @return EntityPersister|null
     */
    public function getEntityLoader($entityClass)
    {
        return $this->getEntityManager()->getUnitOfWork()->getEntityPersister($entityClass);
    }

    /**
     * Gets a value from the config.
     *
     * @param $key
     * @return mixed
     */
    public function getParameter($key)
    {
        return $this->getService('config')->get($key);
    }

    /**
     * @param $route
     * @param array $arguments
     * @return mixed
     */
    public function getUrl($route, $arguments = [])
    {
        return $this->getService('routing')->urlGenerator->generate($route, $arguments);
    }

    /**
     * Gets all available content type services.
     *
     * @return array
     */
    public function getContentTypes()
    {
        $contentTypeIds = $this->services->findTaggedServiceIds('content_type');

        $contentTypes = [];
        foreach ($contentTypeIds as $id => $contentType) {
            $contentTypes[$id] = $this->getService($id);
        }

        return $contentTypes;
    }

    /**
     * Renders a template file based on the current route name.
     *
     * @param array $vars
     * @return Response
     */
    function render($vars = [])
    {
        $template = __DIR__ . '/../../templates/' . $this->getService('request')->attributes->get('_route') . '.php';
        if (!file_exists($template)) {
            throw new Exception('Template not found.');
        }

        ob_start();
        include $template;

        return new Response(ob_get_clean());
    }
}