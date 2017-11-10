<?php
/**
 * Class FormInput
 *
 * Form input wrapper
 */

class FormInput {
    /**
     * @var string
     */
    public $type;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $label;
    /**
     * @var bool
     */
    public $required = false;
    /**
     * @var string
     */
    public $placeholder;
    /**
     * @var string
     */
    public $validator;
    /**
     * @var array
     */
    public $validatorParams = [];
    /**
     * @var Form
     */
    public $form;
    /**
     * @var string
     */
    public $error = '';
    /**
     * @var array
     */
    public $values = [];

    /**
     * FormInput constructor.
     * @param Form $form
     */
    public function __construct($form) {
        $this->form = $form;
    }

    /**
     * Draw input
     */
    public function draw() {
        App::$cur->render->widget($this->resolveWidget(), [
            'type' => $this->type,
            'name' => $this->name,
            'label' => $this->label,
            'required' => $this->required,
            'placeholder' => $this->placeholder,
            'values' => $this->values,
            'validator' => $this->validator,
            'validatorParams' => $this->validatorParams,
            'error' => $this->error,
            'value' => $this->type !== 'file' ? $this->fromRequest() : '',
        ]);
    }

    /**
     * Resolve widget path by type
     *
     * @return string
     */
    public function resolveWidget() {
        if (in_array($this->type, ['file', 'select'])) {
            return 'form/' . $this->type;
        }
        return 'form/input';
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function fromRequest($default = null) {
        $requestType = $this->type !== 'file' ? $this->form->requestType : 'files';
        return App::$cur->request->{$requestType}($this->name, $default);
    }

    /**
     * Prepare user request for db insert
     * @return string
     */
    public function forDb() {
        $value = $this->fromRequest();
        if ($this->type === 'password') {
            return password_hash($value, PASSWORD_DEFAULT);
        }
        if ($this->type !== 'file') {
            return $value;
        }
        if (!empty($value['tmp_name'])) {
            $fileName = microtime(true) . '.' . explode('/', $value['type'])[1];
            $savePath = 'static' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR . $fileName;
            if (move_uploaded_file($value['tmp_name'], $savePath)) {
                return $fileName;
            }
        }
        return '';
    }

    /**
     * Validate user request
     *
     * @return bool
     */
    public function validate() {
        $input = $this->fromRequest();
        if (!$input && $this->required) {
            $this->error = 'This field can not be empty';
            return false;
        }
        if ($this->validator) {
            $result = $this->form->validator->{$this->validator}($input, $this->validatorParams, $this);
            if ($result !== true) {
                $this->error = $result;
                return false;
            }
        }
        return true;
    }
}