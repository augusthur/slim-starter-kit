<?php
$container = $app->getContainer();

// database
$container['db'] = function ($c) {
    $settings = $c->get('settings')['eloquent'];
    return new \App\Util\EloquentService($settings);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['monolog'];
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], \Monolog\Logger::DEBUG));
    return $logger;
};

// swift mailer
$container['mailer'] = function ($c) {
    $settings = $c->get('settings')['swiftmailer'];
    $mailer = new \App\Util\SwiftMailerService(
        $c->get('settings')['mode'],
        $settings['transport'],
        $settings['options']
    );
    return $mailer;
};

// debbuger
$container['debugger'] = function ($c) {
    return new \App\Util\DebuggerService(
        $c->get('settings')['mode'],
        $c->get('db')->getConnection(),
        $c->get('mailer')->getMailer(),
        $c->get('logger')
    );
};
$container->get('debugger');

// view renderer
$container['view'] = function ($c) {
    $settings = $c->get('settings')['twig'];
    $view = new \Slim\Views\Twig($settings['path'], $settings['options']);
    $view->addExtension(new \App\Util\TwigExtension(
        $c['router'],
        $c['request']->getUri(),
        $c['debugger']
    ));
    return $view;
};

$container['App\ExampleController'] = function ($c) {
    return new \App\Controller\ExampleController($c);
};

// csfr protection
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard();
};

// flash messages
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};
