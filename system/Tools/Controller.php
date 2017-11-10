<?php

/**
 * Class Controller
 *
 * Handles user requests
 */
class Controller {
    /**
     * Action name for run
     *
     * @var string
     */
    public $actionName = 'indexAction';
    /**
     * Params from user request
     *
     * @var array
     */
    public $params = [];

    /**
     * Set and processing params
     *
     * @param $params
     */
    public function setParams($params) {
        if (is_callable([$this, $params[0] . 'Action'])) {
            $this->actionName = $params[0] . 'Action';
            array_shift($params);
        }
        $this->params = $params;
    }

    /**
     * Run action from actionName
     *
     * @throws Exception
     */
    public function run() {
        if (!is_callable([$this, $this->actionName])) {
            throw new Exception('Action not found', 3);
        }
        call_user_func_array([$this, $this->actionName], $this->params);
    }
}