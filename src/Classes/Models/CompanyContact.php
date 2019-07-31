<?php

use \PDO;
use \MiniCRM\Sys\DB;

namespace MiniCRM\Models;

class CompanyContact {
    public $id;
    public $name;
    public $phone;

    /**
     * @param int $id the contact's id
     * @param string $name the contact's name
     * @param string $address the contact's phone
     */
    public function __construct(int $id, string $name, string $phone) {
        $this->id = $id;
        $this->name = $name;

        $phoneregx = "/^(\+[0-9]{2})?[0-9]{3,4}-?[0-9]{5,7}$/";

        $this->phone = (preg_match($phoneregx, $phone)) ? $phone : "<invalid>";
    }

    public function get_header(){
        return "{$this->name} ({$this->phone})";
    }

    /**
     * Builds CompanyContact's from a company's id
     * @param int $companyid the company owning the contacts
     * @return array the CompanyContact array
     */
    public static function get_from_company(int $companyid){
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        $query = $db->prepare(
            "SELECT Cc.id, Cc.name, Cc.phone
             FROM company_contacts Cc 
             JOIN companies C ON C.id = Cc.company
             WHERE C.id = :id"
        );
        $query->bindValue(":id", $companyid, \PDO::PARAM_INT);
        $query->execute();

        $contacts = array_map(
            function($el){
                return new \MiniCRM\Models\CompanyContact($el["id"], $el["name"], $el["phone"]);
            },
            $query->fetchAll(\PDO::FETCH_ASSOC)
        );

        return $contacts;
    }

    /**
     * Builds a CompanyContact from its id
     * @param int $id the contact id
     * @return CompanyContact
     */
    public static function get(int $id){
        $dbslt = \MiniCRM\Sys\DB::init(true);
        $db = $dbslt->conn();

        $query = $db->prepare(
            "SELECT Cc.id, Cc.name, Cc.phone
             FROM company_contacts Cc 
             WHERE Cc.id = :id"
        );
        $query->bindValue(":id", $id, \PDO::PARAM_INT);
        $query->execute();
        $contactdata = $query->fetch(\PDO::FETCH_ASSOC);

        return new CompanyContact($contactdata["id"], $contactdata["name"], $contactdata["phone"]);
    }

    /**
     * @param int $compid the company owning the contact
     * @param string $name the contact's name
     * @param string $phone the contact's phone
     */
    public static function insert(int $compid, string $name, string $phone){
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

    /**
     * @param int $contactid the contact's id
     * @param string $name the contact's name
     * @param string $phone the contact's phone
     */
    public static function update(int $contactid, string $name, string $phone){
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

    /**
     * @param int $contactid the contact's id
     */
    public static function delete(int $contactid){
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
}