<?php 

namespace MiniCRM\Models;

class CompanyType {
    public $id;
    public $naming_conv;

    public function __construct($id, $naming_conv) {
        $this->id = $id;
        $this->naming_conv = $naming_conv;
    }

    /**
     * Gets all company types
     * @return array the array of CompanyTypes
     */
    public static function get(){
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
}