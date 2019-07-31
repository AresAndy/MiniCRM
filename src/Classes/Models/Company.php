<?php

use \MiniCRM\Sys\DB;

namespace MiniCRM\Models;

abstract class Company implements Company_able{
    public $type;

    /**
     * @param int $id the company's id
     * @param int $type the company's type id
     * @param string $typename the company's type name
     * @param string $name the company's name
     * @param string $address the company's address
     */
    public function __construct(int $id, int $type, string $typename, string $name = null, string $address = null){
        $this->id = $id;
        $this->name =    ($name) ? $name : "<noname>";
        $this->address = ($address) ? $address : "<noaddress>";
        $this->type = $typename;
        $this->typeid = $type;
    }

    // keep it abstract at this point
    public abstract function get_header();

    /**
     * @param string $name the company's name
     * @param string $address the company's address
     * @param int $type the company's type id
     */
    public static function insert(string $name, string $address, int $type) {
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

    /**
     * @param int $id the company's id
     * @param string $name the company's name
     * @param string $address the company's address
     * @param int $type the company's type id
     */
    public static function update(int $id, string $name, string $address, int $type){
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

    /**
    * @param int $id the company's id
    */
    function delete($id) {
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