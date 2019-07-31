<?php

use Slim\App;
use MiniCRM\Sys\DB;
use MiniCRM\Factories\MiniCRMFactory;
use MiniCRM\Factories\MiniCRMCompDetailsFactory;

return function (App $app) {
    $db = DB::init(true); //omit or `false` if in production

    $container = $app->getContainer();

    //DB factories
    $container["MiniCRM_DB"] = function($container) {
        return new MiniCRMFactory($container);
    };

    $container["MiniCRM_DB_CompDetails"] = function($container) {
        return new MiniCRMCompDetailsFactory($container);
    };

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };
};
