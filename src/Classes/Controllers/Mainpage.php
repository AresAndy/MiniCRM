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

    function company_details($request, $response, $args) {
        $compid = $args["id"];

        $minicrmdetails = $this->container->get('MiniCRM_DB_CompDetails')($this->container)->get($compid);

        $tplargs = array(
            "details" => $minicrmdetails->company,
            "types" => $minicrmdetails->types,
            "contacts" => $minicrmdetails->contacts
        );

        $this->container->get('renderer')->render($response, "company_details.phtml", $tplargs);
    }

    function update_company($request, $response, $args) {
        $injson = $request->getParsedBody();
        $compid = $injson["id"];

        $minicrmdetails = $this->container->get('MiniCRM_DB_CompDetails')($this->container)->get($compid);
        $status = ($minicrmdetails->update($compid, $injson['name'], $injson['address'], $injson['type'])) ? 0 : -1;

        $respjson = new JSONResp($status);
        return $response->withJson($respjson->to_assoc());
    }

    function modal_insert_contact($request, $response, $args) {
        $tplargs = array(
        );

        return $this->container->get('renderer')->render($response, "modal_insert_contact.phtml", $tplargs);
    }

    function insert_contact($request, $response, $args) {
        $injson = $request->getParsedBody();

        $compid = $injson["company"];

        $minicrmdetails = $this->container->get('MiniCRM_DB_CompDetails')($this->container)->get($compid);
        $status = ($minicrmdetails->insert_contact($compid, $injson["name"], $injson["phone"])) ? 0 : -1;

        $respjson = new JSONResp($status);
        return $response->withJson($respjson->to_assoc());
    }

    function delete_contact($request, $response, $args) {
        $contactid = $args["id"];
        
        $minicrmdetails = $this->container->get('MiniCRM_DB_CompDetails')($this->container)->get_from_contact($contactid);

        $status = ($minicrmdetails->delete_contact($contactid)) ? 0 : -1;

        $respjson = new JSONResp($status);
        return $response->withJson($respjson->to_assoc());
    }

    function modal_update_contact($request, $response, $args) {
        $contactid = $args["id"];
        $minicrmdetails = $this->container->get('MiniCRM_DB_CompDetails')($this->container)->get_from_contact($contactid);

        $tplargs = array(
            "contact_details" => $minicrmdetails->contacts[0]
        );

        return $this->container->get('renderer')->render($response, "modal_update_contact.phtml", $tplargs);
    }

    function update_contact($request, $response, $args) {
        $injson = $request->getParsedBody();
        $contactid = $injson["id"];

        $minicrmdetails = $this->container->get('MiniCRM_DB_CompDetails')($this->container)->get_from_contact($contactid);
        $status = ($minicrmdetails->update_contact($contactid, $injson['name'], $injson['phone'])) ? 0 : -1;

        $respjson = new JSONResp($status);
        return $response->withJson($respjson->to_assoc());
    }
}