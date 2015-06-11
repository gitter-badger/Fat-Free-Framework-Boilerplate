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

if ($fw->get('DEBUG') > 3) {
    require('app/helper/PhpConsole/__autoload.php');
    $handler = PhpConsole\Handler::getInstance();
    $handler->start(); // Стартуем обработчик PHP ошибок и исключений
    $handler->getConnector()->setSourcesBasePath($_SERVER['DOCUMENT_ROOT']); // so files paths on client will be shorter (optional)
    $fw->set('debugger', $handler);
}

$fw->run();