<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 16.03.16
 * Time: 12:52
 */

namespace App\Service;


use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Yaml\Parser;

class Config
{
    public $config;

    public function __construct()
    {
        $yaml = new Parser();
        $this->config = $yaml->parse(file_get_contents(__DIR__ . '/../../config/config.yml'));
    }

    public function get($key)
    {
        if (!array_key_exists($key, $this->config)) {
            throw new Exception("Missing configuration key: " . $key);
        }

        return $this->config[$key];
    }
} 