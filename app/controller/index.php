<?php

namespace Controller;

use Helper\Security;
use Model\User;

class Index extends \Controller
{
    public function index(\Base $fw, $params)
    {
        $fw->set('list', array(
            'Item One',
            'Item Two',
            'Other Item'
        ));

        $this->_render('index/index.htm');
    }

    public function login(\Base $fw, $params)
    {
        $this->_render('index/login.htm');
    }

    public function loginPost(\Base $fw, $params)
    {
        $login = $fw->get('POST.login');
        $password = $fw->get('POST.password');
        $user = new User();

        if (strpos($login, '@')) {
            $user->load(array('email = ? AND deleted_date IS NULL', $login));
        } else {
            $user->load(array('login = ? AND deleted_date IS NULL', $login));
        }

        if ($user->id) {
            if (Security::instance()->password_verify($password, $user->password)) {
                $fw->reroute('/');
            } else {
                $fw->set('error', 'Не верно введен пароль');
            }
        } else {
            $fw->set('error', 'Пользователь с данным логином или E-Mail не найден');
        }

        $this->_render('index/login.htm');
    }

    public function registration(\Base $fw, $params)
    {

    }

    public function registrationPost(\Base $fw, $params)
    {

    }
}