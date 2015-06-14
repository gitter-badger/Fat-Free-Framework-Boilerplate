<?php

namespace Controller;

use Helper\Notification;
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

    public function reset()
    {
        $this->_render('index/reset.htm');
    }

    public function resetPost(\Base $fw)
    {
        $user = new User();
        $login = $fw->get('POST.login');

        if (strpos($login, '@')) {
            $user->load(array('email = ? AND deleted_date IS NULL', $login));
        } else {
            $user->load(array('login = ? AND deleted_date IS NULL', $login));
        }

        if ($user->id) {
            Notification::instance()->userReset($user->id);
        } else {
            $fw->set('error', 'Пользователь с данным логином или E-Mail не найден');
        }

        $this->_render('index/reset.htm');
    }

    public function completeReset(\Base $fw, $params)
    {
        if ($params['id'] && $params['hash']) {
            $user = new User();
            $user->load(array('id = ? AND deleted_date IS NULL', $params['id']));
            if ($user->id) {
                if (md5($user->password) == $params['hash']) {
                    $password = Security::instance()->generatePassword();
                    $user->password = Security::instance()->password_hash($password, PASSWORD_BCRYPT);
                    if ($user->save()) {
                        Notification::instance()->userSendPassword($user->id, $password);
                        $fw->reroute('/login'); // TODO: сообщение о успешной отправке письма
                    } else {
                        echo "По какой-то причине не удалось сохранить данные пользователя";
                    }
                }
            } else {
                echo "Пользователь с данным id не найден в системе";
            }
        } else {
            echo "Не переданы обязательные параметры";
        }
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