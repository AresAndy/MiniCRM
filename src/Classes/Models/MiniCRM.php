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
}