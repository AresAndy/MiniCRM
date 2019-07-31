<?php

namespace MiniCRM\Controllers;

use MiniCRM\Models\JSONResp;
use MiniCRM\Models\Company;
use MiniCRM\Models\CompanyContact;

class Mainpage {
    protected $container;

    function __construct($container) {
        $this->container = $container;
    }

    /**
     * GET /
     */
    function home($request, $response, $args) {
        $minicrm = $this->container->get('MiniCRM_DB')($this->container)->get();
        $tplargs = array(
            "companies" => $minicrm->companies
        );

        return $this->container->get('renderer')->render($response, "index.phtml", $tplargs);
    }

    /**
     * GET /modal_insert_company
     */
    function modal_insert_company($request, $response, $args) {
        $minicrm = $this->container->get('MiniCRM_DB')($this->container)->get();
        $tplargs = array(
            "types" => $minicrm->types
        );

        return $this->container->get('renderer')->render($response, "modal_insert_company.phtml", $tplargs);
    }

    /**
     * POST /insert_company
     * Content-type: application/json
     * {
     *  name: string,
     *  address: string,
     *  type: int,
     * }
     */
    function insert_company($request, $response, $args) {
        $injson = $request->getParsedBody();

        $status = (Company::insert($injson["name"], $injson["address"], $injson["type"])) ? 0 : -1;

        $respjson = new JSONResp($status);
        return $response->withJson($respjson->to_assoc());
    }

    /**
     * POST /delete_company/{id:int}
     */
    function delete_company($request, $response, $args) {
        $compid = $args["id"];

        $status = (Company::delete($compid)) ? 0 : -1;

        $respjson = new JSONResp($status);
        return $response->withJson($respjson->to_assoc());
    }

    /**
     * GET /company_details/{id:int}
     */
    function company_details($request, $response, $args) {
        $compid = $args["id"];

        $minicrmdetails = $this->container->get('MiniCRM_DB_CompDetails')($this->container)->get_company_details($compid);

        $tplargs = array(
            "details" => $minicrmdetails->company,
            "types" => $minicrmdetails->types,
            "contacts" => $minicrmdetails->contacts
        );

        $this->container->get('renderer')->render($response, "company_details.phtml", $tplargs);
    }

    /**
     * POST /update_company{id:int}
     * Content-type: application/json
     * {
     *  name: string,
     *  address: string,
     *  type: int,
     * }
     */
    function update_company($request, $response, $args) {
        $injson = $request->getParsedBody();
        $compid = $injson["id"];

        $status = (Company::update($compid, $injson['name'], $injson['address'], $injson['type'])) ? 0 : -1;

        $respjson = new JSONResp($status);
        return $response->withJson($respjson->to_assoc());
    }

    /**
     * GET /modal_insert_contact
     */
    function modal_insert_contact($request, $response, $args) {
        $tplargs = array(
        );

        return $this->container->get('renderer')->render($response, "modal_insert_contact.phtml", $tplargs);
    }

    /**
     * POST /insert_contact
     * Content-type: application/json
     * {
     *  company: int,
     *  name: string,
     *  phone: string,
     * }
     */
    function insert_contact($request, $response, $args) {
        $injson = $request->getParsedBody();

        $compid = $injson["company"];

        $status = (CompanyContact::insert($compid, $injson["name"], $injson["phone"])) ? 0 : -1;

        $respjson = new JSONResp($status);
        return $response->withJson($respjson->to_assoc());
    }

    /**
     * POST /delete_contact/{id:int}
     */
    function delete_contact($request, $response, $args) {
        $contactid = $args["id"];
        

        $status = (CompanyContact::delete($contactid)) ? 0 : -1;

        $respjson = new JSONResp($status);
        return $response->withJson($respjson->to_assoc());
    }

    /**
     * GET /modal_update_contact/{id:int}
     */
    function modal_update_contact($request, $response, $args) {
        $contactid = $args["id"];
        $tplargs = array(
            "contact_details" => CompanyContact::get($contactid)
        );

        return $this->container->get('renderer')->render($response, "modal_update_contact.phtml", $tplargs);
    }

    /**
     * POST /update_contact/{id:int}
     * Content-type: application/json
     * {
     *  name: string,
     *  phone: string
     * }
     */
    function update_contact($request, $response, $args) {
        $injson = $request->getParsedBody();
        $contactid = $injson["id"];

        $status = (CompanyContact::update($contactid, $injson['name'], $injson['phone'])) ? 0 : -1;

        $respjson = new JSONResp($status);
        return $response->withJson($respjson->to_assoc());
    }
}