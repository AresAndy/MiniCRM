<?php

use PDO;

namespace MiniCRM\Factories;

class MiniCRM_Contacs_Factory {
    function __invoke(PDO $db, int $company) {
        $query = $db->prepare("SELECT * FROM company_contacts WHERE company = :compid");
        $query->bindValue(":compid", $company);
        $query->execute();

        return;

        
/*
        return new MiniCRM(
            $this->filter_companies(
                $query, 
                array_column($types, "naming_conv", "id"))
        );
        */
    }
}