<?php

namespace Model;

class User extends \Model
{
    protected $_table_name = 'user';

    public function loadCurrent()
    {
        $fw = \Base::instance();
        if ($fw->get('SESSION.user_id')) {
            $this->load(array('id = ? AND deleted_date IS NULL', $fw->get('SESSION.user_id')));
            if ($this->id) {
                $fw->set('user', $this->cast());
                $fw->set('user_obj', $this);

                // Изменяем стандартный язык, если указан для пользователя
                if ($this->exists('language') && $this->language) {
                    $fw->set('LANGUAGE', $this->language);
                }
            }
        }

        return $this;
    }
}