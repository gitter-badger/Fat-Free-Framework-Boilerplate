<?php

namespace Helper;

use Model\User;

class Notification extends \Prefab
{
    /**
     * Отправка письма в кодировке UTF-8
     * @param $to
     * @param $subject
     * @param $body
     * @param null $text
     * @return bool
     */
    protected function _utf8mail($to, $subject, $body, $text = null)
    {
        $fw = \Base::instance();
        $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

        // Добавляем заголовки
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'To: ' . $to . "\r\n";
        $headers .= 'From: ' . $fw->get('mail.from') . "\r\n";

        if ($text) {
            // Генерируем хеш-разделитель сообщения
            $hash = md5(date("r"));
            $headers .= "Content-type: multipart/alternative; boundary=\"$hash\"\r\n";

            // Нормализуем окончания строк
            $body = str_replace("\r\n", "\n", $body);
            $body = str_replace("\n", "\r\n", $body);
            $text = str_replace("\r\n", "\n", $text);
            $text = str_replace("\n", "\r\n", $text);

            // Создаем финальное сообщение
            $msg = "--$hash\r\n";
            $msg .= "Content-type: text/plain; charset=utf-8\r\n";
            $msg .= "Content-Transfer-Encoding: quoted-printable\r\n";
            $msg .= "\r\n" . quoted_printable_encode($text) . "\r\n";
            $msg .= "--$hash\r\n";
            $msg .= "Content-type: text/html; charset=utf-8\r\n";
            $msg .= "Content-Transfer-Encoding: quoted-printable\r\n";
            $msg .= "\r\n" . quoted_printable_encode($body) . "\r\n";
            $msg .= "--$hash\r\n";

            $body = $msg;
        } else {
            $headers .= "Content-type: text/html; charset=utf-8\r\n";
        }

        return mail($to, $subject, $body, $headers);
    }

    /**
     * Отправка письма для смены пароля
     * @param $user_id
     * @throws \Exception
     */
    public function userReset($user_id)
    {
        $fw = \Base::instance();
        if ($fw->get('mail.from')) {
            $user = new User();
            $user->load($user_id);

            if (!$user->id) {
                throw new \Exception("Пользователь не найден");
            }

            $fw->set('user', $user);
            $text = $this->_render('notification/user_reset.txt');
            $body = $this->_render('notification/user_reset.htm');

            // Отправка письма пользователю
            $subject = "Сброс Вашего пароля - " . $fw->get('site.name');
            $this->_utf8mail($user->email, $subject, $body, $text);
        }
    }

    /**
     * Отправка нового пароля пользователю
     * @param $user_id
     * @param $password
     * @throws \Exception
     */
    public function userSendPassword($user_id, $password)
    {
        $fw = \Base::instance();
        if ($fw->get('mail.from')) {
            $user = new User();
            $user->load(array('id = ? AND deleted_date IS NULL', $user_id));

            if (!$user->id) {
                throw new \Exception("Пользователь не найден");
            } else {
                $fw->set('password', $password);
                $text = $this->_render('notification/user_send_password.txt');
                $body = $this->_render('notification/user_send_password.htm');

                $subject = "Новый пароль пользователя - " . $fw->get('site.name');
                $this->_utf8mail($user->email, $subject, $body, $text);
            }
        }
    }

    /**
     * Отрисовываем шаблон и возвращаем результат
     * @param $file
     * @param string $mime
     * @param array $hive
     * @param int $ttl
     * @return string
     */
    protected function _render($file, $mime = 'text/html', array $hive = NULL, $ttl = 0)
    {
        return \Helper\View::instance()->render($file, $mime, $hive, $ttl);
    }
}