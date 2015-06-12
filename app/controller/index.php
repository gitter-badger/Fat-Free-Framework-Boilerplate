<?php

namespace Controller;

class Index extends \Controller
{
    public function index(\Base $fw, $params)
    {
        $fw->set('list', array(
            'Item One',
            'Item Two',
            'Other Item'
        ));

        $fw->template->display('index/index.tpl', $fw->hive());
//        $this->_render('index/index.htm');
    }
    
    public function login(\Base $fw, $params)
    {
        
    }
    
    public function loginPost(\Base $fw, $params)
    {
        
    }
    
    public function registration(\Base $fw, $params)
    {
        
    }
    
    public function registrationPost(\Base $fw, $params)
    {

    }
}