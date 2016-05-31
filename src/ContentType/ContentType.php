<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 16.03.16
 * Time: 15:21
 */

namespace App\ContentType;


use App\Entity\ContentData;
use App\Service\Config;
use App\Service\Database;
use App\Service\Routing;
use App\Service\Translator;

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
     * @var Translator
     */
    protected $translator;

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
    public function setServices(Config $config, Database $database, Routing $routing, Translator $translator)
    {
        $this->config = $config;
        $this->database = $database;
        $this->routing = $routing;
        $this->translator = $translator;
    }

    /**
     * @param $key
     * @param $contentId
     * @return string
     */
    public function getData($key, $contentId)
    {
        $contentData = $this->database->getLoader('App\Entity\ContentData')->load(['content' => $contentId, 'dataKey' => $key]);

        if ($contentData) {
            return $contentData->getDataValue();
        }

        return '';
    }

    /**
     * Renders the final output of the content type.
     *
     * When overriding this method start with: $output = parent::render($contentId);
     *
     * @param $contentId
     * @return string
     */
    public function render($contentId)
    {
        $widgetfile = __DIR__ . '/' . $this->getClass() . '/widget.php';
        if (file_exists($widgetfile)) {
            $content = $this->database->getLoader('App\Entity\Content')->load(['id' => $contentId]);
            ob_start();
            include $widgetfile;
            $output = ob_get_clean();
            foreach ($this->config->config as $key => $value) {
                if (in_array($key, ['db.host', 'db.user', 'db.pass', 'db.name'])) continue;
                $output = str_replace('%%' . $key . '%%', $value, $output);
            }

            return $output;
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
            $content = $this->database->getLoader('App\Entity\Content')->load(['id' => $contentId]);
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
        $content = $this->database->getLoader('App\Entity\Content')->load(['id' => $contentId]);
        $contentData = $this->database->getLoader('App\Entity\ContentData')->loadAll(['content' => $contentId]);

        //Delete current data

        foreach ($contentData as $item) {
            $this->database->em->remove($item);
        }

        $this->database->em->flush();

        //Save new data

        foreach ($data as $key => $value) {
            if ($key == 'title') continue; //@TODO buttons ausklammern
            $contentData = $this->database->getLoader('App\Entity\ContentData')->load(['content' => $contentId, 'dataKey' => $key]);
            if (!$contentData) {
                $contentData = new ContentData();
                $this->database->em->persist($contentData);
                $contentData->setContent($content);
                $contentData->setDataKey($key);
            }
            $contentData->setDataValue($value);
        }
        $this->database->em->flush();

        return true;
    }

    /**
     * Translates a string by key.
     *
     * @param $key
     * @return string
     */
    public function translate($key, $parameters = [])
    {
        return $this->translator->trans($key, $parameters);
    }
}