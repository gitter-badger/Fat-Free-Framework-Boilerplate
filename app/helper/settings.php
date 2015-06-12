<?php

namespace Helper;

class Settings extends \Prefab
{
    private $_settings = array();

    function __construct()
    {
        $this->fw = \Base::instance();
        $this->cache = \Cache::instance();
        $this->db = $this->fw->get('db.instance');

        if (!$this->cache->exists('settings')) {
            $result = $this->db->exec("SELECT * FROM settings");
            foreach ($result as $item) {
                $this->_settings[$item['key']] = json_decode($item['value'], true) ?: $item['value'];
            }
            $this->cache->set('settings', $this->_settings, $this->fw->get('cache_expire.db'));
        } else {
            $this->_settings = $this->cache->get('settings');
        }
        $this->fw->mset($this->_settings);
    }

    /**
     * Сохраняем или обновляем значение
     * @param $key
     * @param null $value
     */
    public function set($key, $value = null)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        if (array_key_exists($key, $this->_settings)) {
            $query = "UPDATE settings SET `value` = :value WHERE `key` = :key";
        } else {
            $query = "INSERT INTO settings VALUES (:key, :value)";
        }

        $this->fw->debugger->debug($query);
        $this->db->exec($query, array(':key' => $key, ':value' => $value));
        $this->clearCache();
    }

    /**
     * Очистка кеша настроек
     * @return bool
     */
    public function clearCache()
    {
        if ($this->cache->clear('settings')) {
            $this->fw->debugger->debug('Кеш очищен');
            return true;
        }
    }
}