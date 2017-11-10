<?php

/**
 * Class Form
 *
 * Form create and validate helper
 */
class Form {
    /**
     * @var FormInput[]
     */
    public $inputs = [];
    /**
     * @var string
     */
    public $requestType = 'post';
    /**
     * @var Validator
     */
    public $validator;

    /**
     * Form constructor.
     * @param array $inputs
     */
    public function __construct($inputs) {
        foreach ($inputs as $name => $inputParams) {
            $formInput = new FormInput($this);
            $formInput->name = $name;
            foreach ($inputParams as $param => $value) {
                $formInput->$param = $value;
            }
            $this->inputs[$formInput->name] = $formInput;
        }
        $this->validator = new Validator($this);
    }

    /**
     * Check user request for form inputs exist
     *
     * @return bool
     */
    public function received() {
        foreach ($this->inputs as $inputName => $input) {
            if (App::$cur->request->{$this->requestType}($inputName) !== null) {
                return true;
            }
        }
        return false;
    }

    /**
     * Validate user request
     *
     * @return bool
     */
    public function validateRequest() {
        $valid = true;
        foreach ($this->inputs as $inputName => $input) {
            if (!$input->validate()) {
                $valid = false;
            }
        }
        return $valid;
    }
}