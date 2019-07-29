<?php 

use MiniCRM\Models\Company;

namespace MiniCRM\Models;

class SupplierCompany extends Company {
    public function get_header(){
        return "{$this->name} => {$this->address}";
    }
}