<?php

$loader = new \Phalcon\Loader();

$namespaces = [
    'ExamplePhalcon\Controllers' => $config->application->controllersDir,
    'ExamplePhalcon\Models' => $config->application->modelsDir,
    'ExamplePhalcon\Forms' => $config->application->formsDir,

    'Rhumsaa\Uuid' => $config->application->vendorDir . '/rhumsaa/uuid/src',
];
$loader->registerNamespaces($namespaces);

$loader->registerDirs(
    array(
        $config->application->vendorDir . '/phalcon/incubator/Library/',
        $config->application->vendorDir . '/rase/socket.io-emitter/src/',
    )
);

$loader->register();
