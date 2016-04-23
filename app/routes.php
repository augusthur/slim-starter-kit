<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    $this->logger->info("Hello!");
    return $this->view->render($response, 'master.twig', [
        'name' => 'hello!'
    ]);
});

$app->get('/greet/[{name}]', 'App\ExampleController:greet')->setName('greet');

$app->get('/send-mail', 'App\ExampleController:sendMail');

$app->get('/query-db', 'App\ExampleController:queryDB');
