<?php

/**
 * Class Autoload
 *
 * Load classes by his names
 */
class Autoload {
    /**
     * Autoload paths
     *
     * @var array
     */
    private static $searchPaths = [];

    /**
     * Autoload registration
     */
    public static function register() {
        spl_autoload_register('Autoload::findClass');
    }

    /**
     * Load class by name from search paths
     *
     * @param string $className
     * @return bool
     */
    public static function findClass($className) {
        $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        foreach (self::$searchPaths as $path) {
            $possiblePath = $path . DIRECTORY_SEPARATOR . $classPath . '.php';
            if (file_exists($possiblePath)) {
                include_once $possiblePath;
                return true;
            }
        }
        return false;
    }

    /**
     * Add path to search paths
     *
     * @param string $path
     * @return bool
     */
    public static function addPath($path) {
        $path = rtrim($path, '/\\');
        if (!in_array($path, self::$searchPaths)) {
            self::$searchPaths[] = $path;
        }
        return true;
    }


}