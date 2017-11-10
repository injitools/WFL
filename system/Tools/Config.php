<?php

/**
 * Class Config
 *
 * App config manager
 */
class Config {
    /**
     * Loaded config storage
     *
     * @var array
     */
    private $configArray = [];
    /**
     * Path of config file
     *
     * @var string
     */
    private $configPath;

    /**
     * Config constructor.
     */
    public function __construct() {
        $this->configPath = App::$cur->path . DIRECTORY_SEPARATOR . 'config.php';
        $this->load();
    }

    /**
     * Load configs from config path
     */
    public function load() {
        if (file_exists($this->configPath)) {
            $this->configArray = include $this->configPath;
        }
    }

    /**
     * Config params getter by param name
     *
     * @param string $name
     * @param mixed $default If config param no exist, return this
     * @return mixed
     */
    public function get($name, $default = '') {
        return isset($this->configArray[$name]) ? $this->configArray[$name] : $default;
    }
}