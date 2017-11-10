<?php

/**
 * Class Request
 *
 * User request handler
 */
class Request {
    /**
     * @var string
     */
    private $url = '';
    /**
     * @var array
     */
    private $get = [];
    /**
     * @var array
     */
    private $post = [];
    /**
     * @var array
     */
    private $files = [];

    /**
     * Request constructor.
     * @param string $url
     * @param array $get
     * @param array $post
     * @param array $files
     */
    public function __construct($url, $get, $post, $files) {
        $this->url = $url;
        $this->get = $get;
        $this->post = $post;
        $this->files = $files;
    }

    /**
     * Create request instance from user request
     *
     * @return Request
     */
    public static function fromUserRequest() {
        $url = explode('?', $_SERVER['REQUEST_URI'])[0];
        return new Request($url, $_GET, $_POST, $_FILES);
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param string $fieldName
     * @param mixed $default
     * @return mixed
     */
    public function post($fieldName, $default = null) {
        return isset($this->post[$fieldName]) ? $this->post[$fieldName] : $default;
    }

    /**
     * @param string $fieldName
     * @param mixed $default
     * @return mixed
     */
    public function files($fieldName, $default = null) {
        return isset($this->files[$fieldName]) ? $this->files[$fieldName] : $default;
    }
}