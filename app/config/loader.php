<?php

use Phalcon\Loader;

$loader = new Loader();

/**
 * Register Namespaces
 */
$loader->registerNamespaces([
    'Yabasi'   => APP_PATH . '/models/',
    'Library'  => APP_PATH . '/library/',
]);

/**
 * Register module classes
 */
$loader->registerClasses([
    'Yabasi\Frontend\Module' => APP_PATH . '/frontend/Module.php',
    'Yabasi\Backend\Module'      => APP_PATH . '/backend/Module.php',
    'Yabasi\Api\Module'      => APP_PATH . '/api/Module.php'
]);

$loader->register();
