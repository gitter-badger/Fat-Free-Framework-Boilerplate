<?php

abstract class Controller
{
    public function beforeRoute(\Base $fw)
    {

    }

    public function afterRoute(\Base $fw)
    {

    }

    /**
     * Рендер вида
     * @param string $file
     * @param string $mime
     * @param array $hive
     * @param integer $ttl
     */
    protected function _render($file, $mime = "text/html", array $hive = null, $ttl = 0)
    {
        echo \Helper\View::instance()->render($file, $mime, $hive, $ttl);
    }

    /**
     * Выводим объект в формате JSON и задаем соответствующий заголовок
     * @param mixed $object
     */
    protected function _printJson($object)
    {
        if (!headers_sent()) {
            header("Content-type: application/json");
        }
        echo json_encode($object);
    }

    /**
     * Получаем текушие дату и время в MySQL NOW() формате
     * @param  boolean $time Включать ли время в строку
     * @return string
     */
    function now($time = true)
    {
        return $time ? date("Y-m-d H:i:s") : date("Y-m-d");
    }
}