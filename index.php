<?php
$time = microtime(true);

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

echo round((microtime(true) - $time) * 1000, 0) . ' ms' . '<br/>';
echo round(memory_get_peak_usage(true) / 1024, 0) . ' кБ';