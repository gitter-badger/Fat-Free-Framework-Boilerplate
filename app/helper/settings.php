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
            $result = $this->db->exec("SELECT * FROM settings", null, $this->fw->get('cache_expire.db'));
            foreach ($result as $item) {
                $this->_settings[$item['key']] = json_decode($item['value'], true) ?: $item['value'];
            }
            $this->cache->set('settings', $this->_settings, $this->fw->get('cache_expire.db'));
        } else {
            $this->_settings = $this->cache->get('settings');
        }
        $this->fw->mset($this->_settings);
    }
}