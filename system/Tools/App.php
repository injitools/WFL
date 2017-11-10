<?php

/**
 * Class App
 *
 * Main entry point
 */
class App {
    /**
     * App directory path
     *
     * @var string
     */
    public $path;
    /**
     * Controllers directory path
     *
     * @var string
     */
    public $controllersPath;
    /**
     * User request object
     *
     * @var Request
     */
    public $request;
    /**
     * Current app storage
     *
     * @var App
     */
    public static $cur;
    /**
     * App loaded modules storage
     * @var array
     */
    private $modules = [];

    /**
     * App constructor.
     * @param string $path path of app files
     */
    public function __construct($path) {
        $this->path = $path;
        $this->controllersPath = $path . DIRECTORY_SEPARATOR . 'controllers';
    }

    /**
     * Run controller action from request url
     *
     * @param Request $request
     */
    public function processRequest($request) {
        $this->request = $request;
        $url = $this->i18n->resolveLang($request->getUrl());
        $controller = $this->resolveActionByUrl($url);
        $controller->run();
    }

    /**
     * Return controller and set needed action from url
     *
     * @param string $url
     * @return Controller mixed
     * @throws AppException
     */
    public function resolveActionByUrl($url) {
        $urlPath = explode('/', trim($url, '/'));
        $posibleControllerName = ucfirst($urlPath[0]);
        $posibleControllerPath = $this->controllersPath . DIRECTORY_SEPARATOR . $posibleControllerName . '.php';
        if (file_exists($posibleControllerPath)) {
            include_once $posibleControllerPath;
            $controller = new $posibleControllerName();
            array_shift($urlPath);
        } elseif ($controllerName = $this->config->get('defaultController', false)) {
            include_once $this->controllersPath . DIRECTORY_SEPARATOR . $controllerName . '.php';
            $controller = new $controllerName();
        } else {
            throw new AppException('Controller not found', 2);
        }
        $controller->setParams($urlPath);

        return $controller;
    }

    /**
     * App modules autoloader
     *
     * @param string $objectName
     * @return mixed
     */
    public function __get($objectName) {
        if (!isset($this->modules[$objectName])) {
            $className = ucfirst($objectName);
            $this->modules[$objectName] = new $className();
        }
        return $this->modules[$objectName];
    }
}