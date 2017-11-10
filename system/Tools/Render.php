<?php

/**
 * Class Render
 *
 * App template render
 */
class Render {
    /**
     * @var string
     */
    public $templatePath;
    /**
     * @var string
     */
    public $viewsPath;
    /**
     * @var string
     */
    public $widgetsPath;
    /**
     * @var string
     */
    public $templateFile = 'main';
    /**
     * @var string
     */
    public $title = 'NoTitle';
    /**
     * @var string
     */
    public $contentFileName = 'index';
    /**
     * @var array
     */
    public $contentData = [];

    /**
     * Render constructor.
     */
    public function __construct() {
        $this->templatePath = App::$cur->path . DIRECTORY_SEPARATOR . 'template';
        $this->viewsPath = App::$cur->path . DIRECTORY_SEPARATOR . 'views';
        $this->widgetsPath = App::$cur->path . DIRECTORY_SEPARATOR . 'widgets';
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title . ' - ' . App::$cur->config->get('appName', 'Unnamed site');
    }

    /**
     * @param string $contentFileName
     * @param array $data
     */
    public function view($contentFileName = '', $data = []) {
        if ($contentFileName) {
            $this->contentFileName = $contentFileName;
        }
        $this->contentData = $data;
        include $this->templatePath . DIRECTORY_SEPARATOR . $this->templateFile . '.php';
    }

    /**
     * @throws AppException
     */
    public function content() {
        $contentPath = $this->viewsPath . DIRECTORY_SEPARATOR . $this->contentFileName . '.php';
        if (file_exists($contentPath)) {
            extract($this->contentData);
            include $contentPath;
        } else {
            throw new AppException('Content not found', 1);
        }
    }

    /**
     * Fast access for i18n
     * @return mixed
     */
    public function lang() {
        return call_user_func_array([App::$cur->i18n, 'text'], func_get_args());
    }

    /**
     * @param string $href
     * @return string
     */
    public function href($href) {
        if (strpos($href, '/') !== 0) {
            return $href;
        }
        return '/' . App::$cur->i18n->lang . $href;
    }

    /**
     * @param string $widgetName
     * @param array $params
     * @throws AppException
     */
    public function widget($widgetName, $params = []) {
        $__widgetPath = $this->widgetsPath . DIRECTORY_SEPARATOR . $widgetName . '.php';
        if (file_exists($__widgetPath)) {
            extract($params);
            include $__widgetPath;
        } else {
            throw new AppException('Widget not found', 4);
        }
    }

}