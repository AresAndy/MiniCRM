<?php

namespace MiniCRM\Factories;

use MiniCRM\Models\CompanyContact;
use MiniCRM\Models\ClientCompany;

class MiniCRMCompDetailsFactory {
    private $container;

    private function get_types(){
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        $query = $db->query("SELECT * FROM company_types");
        $types = array_map(
            function($el){
                return new \MiniCRM\Models\CompanyType($el["id"], $el["naming_conv"]);
            },
            $query->fetchAll(\PDO::FETCH_ASSOC)
        );

        return $types;
    }

    function get($id){
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        $types = $this->get_types();

        $query = $db->prepare(
            "SELECT Cc.id, Cc.name, Cc.phone
             FROM company_contacts Cc 
             JOIN companies C ON C.id = Cc.company
             WHERE C.id = :id"
        );
        $query->bindValue(":id", $id, \PDO::PARAM_INT);
        $query->execute();

        $contacts = array_map(
            function($el){
                return new \MiniCRM\Models\CompanyContact($el["id"], $el["name"], $el["phone"]);
            },
            $query->fetchAll(\PDO::FETCH_ASSOC)
        );

        $query = $db->prepare(
            "SELECT C.id, C.name, C.address, CT.id AS `type`
             FROM companies C 
             JOIN company_types CT on CT.id = C.type
             WHERE C.id = :id"
        );
        $query->bindValue(":id", $id, \PDO::PARAM_INT);
        $query->execute();

        $companydata = $query->fetch(\PDO::FETCH_ASSOC);

        $this->container->get('logger')->info("[DEBUG] companydata: " . var_export($companydata, true));
        $this->container->get('logger')->info("[DEBUG] types: " . var_export($types, true));

        $cur_company_type = reset(
            array_filter(
                $types, 
                function(\MiniCRM\Models\CompanyType $el) use($companydata) {
                    return $el->id == $companydata["type"];
                }
            )
        );

        $company = false;
        switch($cur_company_type->naming_conv){
            case "client":
            $company = new \MiniCRM\Models\ClientCompany($companydata["id"], $companydata["type"], $cur_company_type->naming_conv, $companydata["name"], $companydata["address"]);
            break;

            case "supplier":
            $company = new \MiniCRM\Models\SupplierCompany($companydata["id"], $companydata["type"], $cur_company_type->naming_conv, $companydata["name"], $companydata["address"]);
            break;

            default:
            throw new \Exception("Naming conv unknown: {$cur_company_type->naming_conv}");
        }
        
        return new \MiniCRM\Models\MiniCRMCompDetails($company, $types, $contacts);
    }

    function get_from_contact($contactid){
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        $types = $this->get_types();

        $query = $db->prepare(
            "SELECT Cc.id, Cc.name, Cc.phone
             FROM company_contacts Cc 
             WHERE Cc.id = :id"
        );
        $query->bindValue(":id", $contactid, \PDO::PARAM_INT);
        $query->execute();
        $contactdata = $query->fetch(\PDO::FETCH_ASSOC);

        $contacts = array(new CompanyContact($contactdata["id"], $contactdata["name"], $contactdata["phone"]));

        return new \MiniCRM\Models\MiniCRMCompDetails(new ClientCompany(0, 0, ""), $types, $contacts);
    }

    function __invoke($container) {
        $this->container = $container;

        return $this;
    }
}