<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 16.03.16
 * Time: 12:52
 */

namespace App\Service;


use App\Entity\ContentCategory;
use Symfony\Component\HttpFoundation\Request;

class Helper
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Database
     */
    private $database;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Routing
     */
    private $routing;

    /**
     * @param Config $config
     * @param Database $database
     * @param Request $request
     * @param Routing $routing
     */
    public function __construct(Config $config, Database $database, Request $request, Routing $routing)
    {
        $this->config = $config;
        $this->database = $database;
        $this->request = $request;
        $this->routing = $routing;
    }

    /**
     * @param ContentCategory $category
     * @return int
     */
    public function getRecursiveCategoryContentCount(ContentCategory $category)
    {
        $count = $category->getContents()->count();

        foreach ($category->getChildren() as $child) {
            $count += $this->getRecursiveCategoryContentCount($child);
        }

        return $count;
    }

    /**
     * @param ContentCategory $category
     * @param string $delimiter
     * @return string
     */
    public function getCategoryPath(ContentCategory $category, $delimiter = '<i class="uk-icon-angle-right"></i>')
    {
        $name = $category->getName();
        while ($category->getParent()) {
            $category = $category->getParent();
            $name = '<span class="uk-text-muted">' . $category->getName() . ' ' . $delimiter . '</span> ' . $name;
        }

        return $name;
    }
}