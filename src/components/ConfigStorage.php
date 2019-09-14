<?php
/**
 * Created by PhpStorm.
 * User: Saymon
 * Date: 14.09.2019
 * Time: 19:50
 */

namespace src\components;

/**
 * Class ConfigStorage
 * @package src\components
 */
class ConfigStorage
{
    const CONFIG_PATH = __ROOT_DIR__ . '/config/config.php';
    /**
     * @var array
     */
    private $config;

    /**
     * ConfigStorage constructor.
     */
    public function __construct()
    {
        $this->config = require_once self::CONFIG_PATH;
    }

    /**
     * @param String $key
     *
     * @return String
     */
    public function getParam(String $key): String
    {
        return array_key_exists($key, $this->config) ? $this->config[$key] : null;
    }
}