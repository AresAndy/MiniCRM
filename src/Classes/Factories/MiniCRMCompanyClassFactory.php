<?php

use MiniCRM\Models\ClientCompany;
use MiniCRM\Models\SupplierCompany;

namespace MiniCRM\Factories;

class MiniCRMCompanyClassFactory {

    /**
     * Given a DB record of a company, determine the type using the available types
     * @param array $companydata the DB record
     * @param array $types the array of DB company types
     * @return ClientCompany|SupplierCompany|bool the company class or false if failed (with exception)
     */
    public static function determine(array $companydata, array $types){
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

        return $company;
    }

    /**
     * Gets a company using its id.
     * @param int $id the company id
     * @return ClientCompany|SupplierCompany|bool the company class or false if failed (with exception)
     */
    public static function get(int $id){
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        $types = \MiniCRM\Models\CompanyType::get();

        $query = $db->prepare(
            "SELECT C.id, C.name, C.address, CT.id AS `type`
             FROM companies C 
             JOIN company_types CT on CT.id = C.type
             WHERE C.id = :id"
        );
        $query->bindValue(":id", $id, \PDO::PARAM_INT);
        $query->execute();

        $companydata = $query->fetch(\PDO::FETCH_ASSOC);

        return self::determine($companydata, $types);
    }

    /**
     * Gets all companies.
     * @return array the array of determined company classes (with exception)
     */
    public static function get_all(){
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        $types = \MiniCRM\Models\CompanyType::get();

        $query = $db->query(
            "SELECT C.id, C.name, C.address, CT.id AS `type`
             FROM companies C 
             JOIN company_types CT on CT.id = C.type"
        );

        $companies = array();

        foreach($query as $companydata){
            array_push($companies, self::determine($companydata, $types));
        }

        return $companies;
    }
}