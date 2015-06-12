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

    public function login()
    {
        $this->_render('index/login.htm');
    }

    public function loginPost(\Base $fw)
    {
        $user = new User();
        $login = $fw->get('POST.login');
        $password = $fw->get('POST.password');

        if (strpos($login, '@')) {
            $user->load(array('email = ? AND deleted_date IS NULL', $login));
        } else {
            $user->load(array('login = ? AND deleted_date IS NULL', $login));
        }

        if ($user->id) {
            if (Security::instance()->password_verify($password, $user->password)) {
                $fw->set('SESSION.user_id', $user->id);
                $fw->reroute('/');
            } else {
                $fw->set('error', 'Не верно введен пароль');
            }
        } else {
            $fw->set('error', 'Пользователь с данным логином или E-Mail не найден');
        }

        $this->_render('index/login.htm');
    }

    public function registration(\Base $fw)
    {

    }

    public function registrationPost(\Base $fw)
    {

    }

    public function logout(\Base $fw)
    {
        unset($_SESSION['user_id']);
        session_destroy();
        $fw->reroute('/');
    }
}