<?php

namespace Helper;

class Flash extends \Prefab
{
    protected $f3;

    public function __construct()
    {
        $this->f3 = \Base::instance();
        if (!$this->f3->exists('SESSION.flash.msg')) {
            $this->f3->set('SESSION.flash.msg', array());
        }
    }

    /**
     * Добавляем сообщение
     * @param $text
     * @param bool|string $status
     */
    public function addMessage($text, $status = false)
    {
        $msg = array('text' => $text, 'status' => $status);
        $this->f3->push('SESSION.flash.msg', $msg);
    }

    /**
     * Получаем сообщение
     * @return mixed
     */
    public function getMessages()
    {
        $out = $this->f3->get('SESSION.flash.msg');
        $this->clearMessages();
        return $out;
    }

    /**
     * Очищаем массив сообщений
     */
    public function clearMessages()
    {
        $this->f3->clear('SESSION.flash.msg');
    }

    /**
     * Проверка на наличие сообщений в массиве
     * @return bool
     */
    public function hasMessages()
    {
        $val = $this->f3->get('SESSION.flash.msg');
        return !empty($val);
    }

    /**
     * Задаем сообщение с ключем
     * @param $key
     * @param null $val
     */
    public function setKey($key, $val = null)
    {
        $this->f3->set('SESSION.flash.key.' . $key, $val);
    }

    /**
     * Получаем сообщение по ключу
     * @param $key
     * @return mixed|string
     */
    public function getKey($key)
    {
        if (!$this->f3->exists('SESSION.flash.key.' . $key))
            return '';
        $out = $this->f3->get('SESSION.flash.key.' . $key);
        $this->f3->clear('SESSION.flash.key.' . $key);
        return $out;
    }
}