<?php 

namespace MiniCRM\Factories;

use MiniCRM\Models\MiniCRM;
use MiniCRM\Models\ClientCompany;
use MiniCRM\Models\SupplierCompany;
use MiniCRM\Sys\DB;
use PDO;
use PDOStatement;
use MiniCRM\Models\CompanyType;
use PDOException;

class MiniCRMFactory {
    private $container;

    private function filter_companies(PDOStatement $execd_query, array $types){
        $companies = array();
        $printed = false;

        foreach($execd_query as $record){
            $valid = true;

            $type = $types[$record["type"]];

            switch($type){
                case "client":
                $valid = new ClientCompany($record["id"], $record["type"], $type, $record["name"], $record["address"]);
                break;

                case "supplier":
                $valid = new SupplierCompany($record["id"], $record["type"], $type, $record["name"], $record["address"]);
                break;

                default:
                $valid = false;
            }

            if($valid){
                array_push($companies, $valid);
            }
        }

        //$this->container->get('logger')->info(var_export($companies, true));
        
        return $companies;
    }

    function __invoke($container) {
        $this->container = $container;

        $dbslt = DB::init(true);
        $db = $dbslt->conn();

        $query = $db->query("SELECT * FROM company_types");
        $types = $query->fetchAll(PDO::FETCH_ASSOC);

        $query = $db->query(
            "SELECT C.id, C.name, C.address, CT.id AS `type`
             FROM companies C 
             JOIN company_types CT on CT.id = C.type"
        );

        return new MiniCRM(
            $this->filter_companies(
                $query, 
                array_column($types, "naming_conv", "id")),
            array_map(
                function($type){
                    return new CompanyType($type["id"], $type["naming_conv"]);
                }, 
                $types
            )
        );
    }
}