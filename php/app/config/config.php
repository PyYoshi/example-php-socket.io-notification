<?php

return new \Phalcon\Config([
    'session' => [
        'path' => 'tcp://127.0.0.1:6379?weight=1',
        'lifetime' => 259200, // 3days
    ],
    'socketIoEmitter' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'auth' => null
    ],
    'application' => [
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'formsDir'       => __DIR__ . '/../../app/forms/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'libraryDir'     => __DIR__ . '/../../app/library/',
        'cacheDir'       => __DIR__ . '/../../app/cache/',
        'vendorDir'      => __DIR__ . '/../../vendor/',
        'baseUri'        => '/',
    ]
]);
