<?php

/** @var Base $fw */
$fw = require('lib/base.php');

$fw->mset(array(
    'UI' => 'app/view/',
    'AUTOLOAD' => 'app/'
));

$fw->config('config.ini');
$fw->config('app/routes.ini');

$fw->set('db.instance', new \DB\SQL(
    'mysql:host=' . $fw->get('db.host') . ';port=' . $fw->get('db.port') . ';dbname=' . $fw->get('db.name'),
    $fw->get('db.user'),
    $fw->get('db.pass')
));

\Helper\Settings::instance()->set('title', 'This is Title');
\Helper\Settings::instance()->delete('title');

$fw->run();