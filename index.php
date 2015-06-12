<?php

require_once('vendor/autoload.php');

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

$fw->set('template', Fenom::factory($fw->get('UI'), $fw->get('TEMP')));

if ($fw->get('DEBUG') > 2) {
    $handler = PhpConsole\Handler::getInstance();
    $handler->start(); // Стартуем обработчик PHP ошибок и исключений
    $handler->getConnector()->setSourcesBasePath($_SERVER['DOCUMENT_ROOT']); // задаем путь к папке исходников (опционально)
    $fw->set('debugger', $handler);
}

\Helper\Settings::instance()->set('title', 'This is Title');
\Helper\Settings::instance()->delete('title');

$fw->run();