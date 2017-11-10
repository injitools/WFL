<?php

/**
 * Class I18n
 *
 * Helper for internalization
 */
class I18n {
    /**
     * @var array
     */
    public $langs;
    /**
     * @var string
     */
    public $lang;
    /**
     * @var string
     */
    public $defaultLang;
    /**
     * Dictionary groups
     * @var array
     */
    public $groups = [];

    /**
     * I18n constructor.
     */
    public function __construct() {
        $this->langs = App::$cur->config->get('langs', []);
        $this->lang = $this->defaultLang = App::$cur->config->get('defaultLang', false);
    }

    /**
     * Extract lang from request url
     *
     * If lang not isset in url, redirect to url with default land
     *
     * @param string $url
     * @return string
     */
    public function resolveLang($url) {
        if (!$this->langs) {
            return $url;
        }
        $urlPath = explode('/', trim($url, '/'));
        if (!isset($this->langs[$urlPath[0]]) && $this->defaultLang) {
            Response::redirect('/' . $this->defaultLang . '/' . implode('/', $urlPath));
        } elseif (isset($this->langs[$urlPath[0]])) {
            $this->lang = $urlPath[0];
            array_shift($urlPath);
        }
        return '/' . implode('/', $urlPath);
    }

    /**
     * @param string $group
     * @param string $code
     * @return mixed
     */
    function text($group, $code) {
        $this->loadGroup($group);
        if (isset($this->groups[$group][$this->lang][$code])) {
            return $this->groups[$group][$this->lang][$code];
        }
        return $code;
    }

    /**
     * @param string $group
     * @return array
     */
    function loadGroup($group) {
        if (isset($this->groups[$group][$this->lang])) {
            return $this->groups[$group][$this->lang];
        }
        if (!isset($this->groups[$group])) {
            $this->groups[$group] = [];
        }
        $filePath = App::$cur->path . '/i18n/' . $group . '/' . $this->lang . '.php';
        if (!file_exists($filePath)) {
            $this->groups[$group][$this->lang] = [];
            return [];
        }
        $this->groups[$group][$this->lang] = include $filePath;
        return $this->groups[$group][$this->lang];
    }
}