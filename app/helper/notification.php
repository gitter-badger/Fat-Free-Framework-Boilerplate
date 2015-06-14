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