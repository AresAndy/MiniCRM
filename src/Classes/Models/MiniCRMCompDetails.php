<?php

namespace MiniCRM\Models;

class MiniCRMCompDetails {
    public $types = array();
    public $company;
    public $contacts;

    public function __construct(Company $company, array $types, array $contacts) {
        $this->company = $company;
        $this->types = $types;
        $this->contacts = $contacts;
    }

    function update(int $id, string $name, string $address, int $type){
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        try{
            $query = $db->prepare(
                "UPDATE companies SET
                name = :name, 
                address = :address,
                type = :type
                WHERE
                id = :id");

            $query->bindValue(":id", $id, \PDO::PARAM_INT);
            $query->bindValue(":name", $name, \PDO::PARAM_STR);
            $query->bindValue(":address", $address, \PDO::PARAM_STR);
            $query->bindValue(":type", $type, \PDO::PARAM_INT);
            $query->execute();
         
            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    function insert_contact(int $compid, string $name, string $phone){
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        try{
            $query = $db->prepare(
                "INSERT INTO company_contacts
                (company, name, phone)
                VALUES
                (:compid, :name, :phone)");

            $query->bindValue(":compid", $compid, \PDO::PARAM_INT);
            $query->bindValue(":name", $name, \PDO::PARAM_STR);
            $query->bindValue(":phone", $phone, \PDO::PARAM_STR);
            $query->execute();
         
            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    function delete_contact(int $contactid){
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        try{
            $query = $db->prepare(
                "DELETE FROM company_contacts
                WHERE id = :conid");

            $query->bindValue(":conid", $contactid, \PDO::PARAM_INT);
            $query->execute();
         
            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    function update_contact(int $contactid, string $name, string $phone){
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        try{
            $query = $db->prepare(
                "UPDATE company_contacts SET
                name = :name, 
                phone = :phone
                WHERE
                id = :id");

            $query->bindValue(":id", $contactid, \PDO::PARAM_INT);
            $query->bindValue(":name", $name, \PDO::PARAM_STR);
            $query->bindValue(":phone", $phone, \PDO::PARAM_STR);
            $query->execute();
         
            return true;
        } catch(PDOException $e){
            return false;
        }
    }
}