<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use MiniCRM\Controllers\Mainpage;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', Mainpage::class . ':home');
    $app->get('/modal_insert_company', Mainpage::class . ':modal_insert_company');
    $app->post('/insert_company', Mainpage::class . ':insert_company');
    $app->post('/delete_company/{id:[0-9]+}', Mainpage::class . ':delete_company');
};
