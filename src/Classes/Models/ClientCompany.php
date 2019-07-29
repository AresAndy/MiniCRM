<?php 

use MiniCRM\Models\Company;

namespace MiniCRM\Models;

class ClientCompany extends Company {
    public function get_header(){
        return "{$this->name} @ {$this->address}";
    }
}