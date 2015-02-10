<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Redis as SessionAdapter;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

$di = new FactoryDefault();

$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

$di->set(
    'router',
    function () {
        $router = new \Phalcon\Mvc\Router\Annotations();
        $router->addResource('ExamplePhalcon\Controllers\Index');
        $router->addResource('ExamplePhalcon\Controllers\Session');
        $router->addResource('ExamplePhalcon\Controllers\Dashboard');
        return $router;
    }
);

$di->set(
    'dispatcher',
    function () {
        $dispatcher = new MvcDispatcher();
        $dispatcher->setDefaultNamespace('ExamplePhalcon\Controllers');
        return $dispatcher;
    }
);

$di->set('view', function () use ($config) {
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {
            $volt = new VoltEngine($view, $di);
            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));
            return $volt;
        }
    ));
    return $view;
}, true);

$di->set('session', function () use ($config) {
    ini_set('session.cookie_httponly', true);
    $session = new SessionAdapter($config->session);
    $session->start();

    return $session;
});

$di->set('socketIoEmitter', function() use($config) {
    $redis = new \Redis();
    $redis->connect($config->socketIoEmitter->host, $config->socketIoEmitter->port);
    if (!is_null($config->socketIoEmitter->auth)) {
        $redis->auth($config->socketIoEmitter->auth);
    }
    $emitter = new \SocketIO\Emitter($redis);
    return $emitter;
});