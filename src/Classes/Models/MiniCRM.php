<?php 

use MiniCRM\Models\Company;

namespace MiniCRM\Models;

class MiniCRM {
    public $companies = array();
    public $types = array();

    public function __construct(array $companies, array $types) {
        if(isset($companies)){
            $this->companies = $companies;
        }   

        if(isset($types)){
            $this->types = $types;
        }   
    }

    function insert_company(string $name, string $address, int $type) {
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        try{
            $query = $db->prepare(
                "INSERT INTO companies 
                (name, address, type) VALUES 
                (:name, :address, :type)");

            $query->bindValue(":name", $name, \PDO::PARAM_STR);
            $query->bindValue(":address", $address, \PDO::PARAM_STR);
            $query->bindValue(":type", $type, \PDO::PARAM_INT);
            $query->execute();
         
            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    function delete_company($id) {
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        try{
            $query = $db->prepare(
                "DELETE FROM companies WHERE id = :id");

            $query->bindValue(":id", $id, \PDO::PARAM_INT);
            $query->execute();
         
            return true;
        } catch(PDOException $e){
            return false;
        }
    }
}