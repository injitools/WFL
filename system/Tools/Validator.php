<?php

/**
 * Class Validator
 *
 * Validation helper
 */
class Validator {
    /**
     * @var Form
     */
    public $form;

    /**
     * Validator constructor.
     * @param $form
     */
    public function __construct($form) {
        $this->form = $form;
    }

    /**
     * Validate E-mail
     * @param string $value
     * @param array $params
     * @param FormInput $input
     * @return bool|string
     */
    public function email($value, $params, $input) {
        $regexp = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Zа-яА-Я\-0-9]+\.)+[a-zA-Zа-яА-Я]{2,}))$/u';
        if (!preg_match($regexp, $value)) {
            return 'Incorrect E-mail, please enter your working E-mail';
        }
        $modelName = $params['model'];
        $user = $modelName::getOne(['where' => ['query' => $input->name . ' = ?', 'params' => [$value]]]);
        if ($params['isset'] && !$user) {
            return 'E-mail not registered';
        } elseif (!$params['isset'] && $user) {
            return 'E-mail already registered';
        }
        return true;
    }

    /**
     * Validate simple strings
     *
     * @param $value
     * @return bool|string
     */
    public function characters($value) {
        $regexp = '/^[a-zA-Zа-яА-Я0-9 \.]+$/u';
        if (!preg_match($regexp, $value)) {
            return 'The field can not contain special characters';
        }
        return true;
    }

    /**
     * Validate password
     *
     * @param string $value
     * @return bool|string
     */

    public function password($value) {
        if (mb_strlen($value) < 6) {
            return 'Minimum password length is 6 characters';
        }
        return true;
    }

    /**
     * Validate password repeat
     * @param string $value
     * @param array $params
     * @return bool|string
     */
    public function passwordRepeat($value, $params) {
        if ($value != $this->form->inputs[$params['passwordField']]->fromRequest()) {
            return 'Passwords do not match';
        }
        return true;
    }

    /**
     * Validate image
     * @param array $value
     * @return bool|string
     */
    public function image($value) {
        if (!empty($value['type']) && !in_array($value['type'], ['image/gif', 'image/jpeg', 'image/png'])) {
            return 'Only image files are allowed (gif, jpg, png)';
        }
        return true;
    }
}