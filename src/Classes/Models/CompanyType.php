<?php 

namespace MiniCRM\Models;

class CompanyType {
    public $id;
    public $naming_conv;

    public function __construct($id, $naming_conv) {
        $this->id = $id;
        $this->naming_conv = $naming_conv;
    }
}