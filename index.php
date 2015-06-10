<?php

/** @var Base $fw */
$fw = require('lib/base.php');

$fw->mset(array(
    'UI' => 'app/view/',
    'AUTOLOAD' => 'app/'
));

$fw->config('config.ini');
$fw->config('app/routes.ini');

$fw->run();