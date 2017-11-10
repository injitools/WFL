<?php

class Users extends Controller {
    public $actionName = 'loginAction';

    public function run() {
        if (in_array($this->actionName, ['loginAction', 'signupAction']) && !empty($_SESSION['user_id'])) {
            Response::redirect('/profile', App::$cur->i18n->text('users', 'You are already authorized'), 'info');
        } elseif ($this->actionName === 'profileAction' && empty($_SESSION['user_id'])) {
            Response::redirect('/login', App::$cur->i18n->text('users', 'You are not authorized'), 'danger');
        }
        parent::run();
    }

    public function logoutAction() {
        unset($_SESSION['user_id']);
        Response::redirect('/login', App::$cur->i18n->text('users', 'You have successfully signed out of your profile'), 'success');
    }

    public function profileAction() {
        $user = User::getOne(['where' => ['query' => 'id = ?', 'params' => [$_SESSION['user_id']]]]);
        App::$cur->render->setTitle(App::$cur->i18n->text('users', 'Profile'));
        App::$cur->render->view('users/profile', compact('user'));
    }

    public function loginAction() {
        $form = new Form([
            'email' => [
                'type' => 'text',
                'label' => 'Email address',
                'placeholder' => 'example@mail.com',
                'required' => true,
                'validator' => 'email',
                'validatorParams' => [
                    'model' => 'User',
                    'isset' => true,
                    'maxLen' => 255
                ]
            ],
            'password' => [
                'type' => 'password',
                'label' => 'Password',
                'placeholder' => '••••••',
                'required' => true,
                'validator' => 'password',
                'validatorParams' => ['maxLen' => 255]
            ]
        ]);
        if ($form->received() && $form->validateRequest()) {
            $user = User::getOne(['where' => ['query' => 'email = ?', 'params' => [$form->inputs['email']->fromRequest()]]]);
            if (!password_verify($form->inputs['password']->fromRequest(), $user->password)) {
                $form->inputs['password']->error = 'Incorrect password';
            } else {
                $_SESSION['user_id'] = $user->id;
                Response::redirect('/profile');
            }
        }
        App::$cur->render->setTitle(App::$cur->i18n->text('users', 'Login'));
        App::$cur->render->view('users/login', compact('form'));
    }

    public function signupAction() {
        $form = new Form([
            'email' => [
                'type' => 'text',
                'label' => 'Email address',
                'placeholder' => 'example@mail.com',
                'required' => true,
                'validator' => 'email',
                'validatorParams' => [
                    'model' => 'User',
                    'isset' => false,
                    'maxLen' => 255
                ]
            ],
            'name' => [
                'type' => 'text',
                'label' => 'Full name',
                'placeholder' => 'John Doe',
                'required' => true,
                'validator' => 'characters',
                'validatorParams' => ['maxLen' => 255]
            ],
            'password' => [
                'type' => 'password',
                'label' => 'Password',
                'placeholder' => '••••••',
                'required' => true,
                'validator' => 'password',
                'validatorParams' => ['maxLen' => 255]
            ],
            'passwordRepeat' => [
                'type' => 'password',
                'label' => 'Repeat password',
                'placeholder' => '••••••',
                'required' => true,
                'validator' => 'passwordRepeat',
                'validatorParams' => ['passwordField' => 'password', 'maxLen' => 255]
            ],
            'sex' => [
                'type' => 'select',
                'label' => 'Sex',
                'values' => [1 => 'Male', 2 => 'Female']
            ],
            'avatar' => [
                'type' => 'file',
                'label' => 'Avatar',
                'validator' => 'image',
                'validatorParams' => ['maxHeight' => 2000, 'maxWidth' => 200, 'maxWeight' => 2]
            ]
        ]);
        if ($form->received() && $form->validateRequest()) {
            $user = User::fromForm($form);
            $user->save();
            $_SESSION['user_id'] = $user->id;
            Response::redirect('/profile', App::$cur->i18n->text('users', 'You have successfully registered'), 'success');
        }
        App::$cur->render->setTitle(App::$cur->i18n->text('users', 'Sign Up'));
        App::$cur->render->view('users/signup', compact('form'));
    }
}