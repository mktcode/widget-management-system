<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 05.04.16
 * Time: 16:02
 */

namespace App\Service;

use Symfony\Component\Translation\Loader\YamlFileLoader;

class Translator extends \Symfony\Component\Translation\Translator
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $locale = strtolower($config->get('locale'));
        if (strlen($locale) == 2) $locale = $locale . '_' . strtoupper($locale);

        parent::__construct($locale);

        $this->addLoader('yaml', new YamlFileLoader());
        foreach (glob(__DIR__ . '/../../translations/*') as $file) {
            $fileParts = explode('.', $file);
            array_pop($fileParts);
            $fileLocale = array_pop($fileParts);
            if (strlen($fileLocale) == 2) $fileLocale = $fileLocale . '_' . strtoupper($fileLocale);
            $this->addResource('yaml', $file, $fileLocale);
        }

        $this->setFallbackLocales(['en']);
    }
} 