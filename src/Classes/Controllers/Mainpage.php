<?php

namespace MiniCRM\Controllers;

use MiniCRM\Models\JSONResp;

class Mainpage {
    protected $container;

    function __construct($container) {
        $this->container = $container;
    }

    function home($request, $response, $args) {
        $minicrm = $this->container->get('MiniCRM_DB')($this->container);
        $tplargs = array(
            "companies" => $minicrm->companies
        );

        return $this->container->get('renderer')->render($response, "index.phtml", $tplargs);
    }

    function modal_insert_company($request, $response, $args) {
        $minicrm = $this->container->get('MiniCRM_DB')($this->container);
        $tplargs = array(
            "types" => $minicrm->types
        );

        return $this->container->get('renderer')->render($response, "modal_insert_company.phtml", $tplargs);
    }

    function insert_company($request, $response, $args) {
        $injson = $request->getParsedBody();

        $minicrm = $this->container->get('MiniCRM_DB')($this->container);
        $status = ($minicrm->insert_company($injson["name"], $injson["address"], $injson["type"])) ? 0 : -1;

        $respjson = new JSONResp($status);
        return $response->withJson($respjson->to_assoc());
    }

    function delete_company($request, $response, $args) {
        $compid = $args["id"];

        $minicrm = $this->container->get('MiniCRM_DB')($this->container);
        $status = ($minicrm->delete_company($compid)) ? 0 : -1;

        $respjson = new JSONResp($status);
        return $response->withJson($respjson->to_assoc());
    }
}