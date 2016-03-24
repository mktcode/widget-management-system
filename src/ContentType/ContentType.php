<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 16.03.16
 * Time: 15:21
 */

namespace App\ContentType;


use App\Service\Config;
use App\Service\Database;
use App\Service\Routing;

abstract class ContentType
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Database
     */
    protected $database;

    /**
     * @var Routing
     */
    protected $routing;

    /**
     * Returns the name of the extending class without the namespace.
     *
     * @return mixed
     */
    protected function getClass()
    {
        return array_pop(explode('\\', get_class($this)));
    }

    /**
     * Set commonly needed services.
     *
     * @param Config $config
     * @param Database $database
     * @param Routing $routing
     */
    public function setServices(Config $config, Database $database, Routing $routing)
    {
        $this->config = $config;
        $this->database = $database;
        $this->routing = $routing;
    }

    /**
     * Renders the final output of the content type.
     *
     * @param $contentId
     * @return string
     */
    public function render($contentId)
    {
        $widgetfile = __DIR__ . '/' . $this->getClass() . '/widget.php';
        if (file_exists($widgetfile)) {
            ob_start();
            include $widgetfile;
            return ob_get_clean();
        }

        return '';
    }

    /**
     * Renders the form for backend editing.
     *
     * @param null $contentId
     * @return string
     */
    public function form($contentId = null)
    {
        $formfile = __DIR__ . '/' . $this->getClass() . '/form.php';
        if (file_exists($formfile)) {
            ob_start();
            include $formfile;
            return ob_get_clean();
        }

        return '';
    }

    /**
     * Returns the label for the button.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->getClass();
    }

    /**
     * Returns the icon class for the button.
     *
     * @return string
     */
    public function getIcon()
    {
        return '';
    }

    /**
     * Returns possible css classes for the button.
     *
     * @return string
     */
    public function getButtonClasses()
    {
        return '';
    }

    /**
     * Saves additional data.
     *
     * @param int $contentId
     * @param array $data
     * @return bool
     */
    public function save($contentId, $data = [])
    {
        return true;
    }

    /**
     * Updates the additional data.
     *
     * @param $contentId
     * @return bool
     */
    public function update($contentId)
    {
        return true;
    }
}