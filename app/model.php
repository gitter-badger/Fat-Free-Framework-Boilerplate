<?php

abstract class Model extends \DB\SQL\Mapper
{

    protected $fields = array();
    protected static $requiredFields = array();

    function __construct($table_name = null)
    {
        $f3 = \Base::instance();

        if (empty($this->_table_name)) {
            if (empty($table_name)) {
                $f3->error(500, "В модель не передано имя таблицы.");
            } else {
                $this->table_name = $table_name;
            }
        }

        parent::__construct($f3->get("db.instance"), $this->_table_name, null, $f3->get("cache_expire.db"));
        return $this;
    }
}