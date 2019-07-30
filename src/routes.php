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
    $app->get('/company_details/{id:[0-9]+}', Mainpage::class . ':company_details');
    $app->post('/update_company', Mainpage::class . ':update_company');
    $app->get('/modal_insert_contact', Mainpage::class . ':modal_insert_contact');
    $app->post('/insert_contact', Mainpage::class . ':insert_contact');
    $app->post('/delete_contact/{id:[0-9]+}', Mainpage::class . ':delete_contact');
    $app->get('/modal_modify_contact/{id:[0-9]+}', Mainpage::class . ':modal_update_contact');
    $app->post('/update_contact', Mainpage::class . ':update_contact');
};
