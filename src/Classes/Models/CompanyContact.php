<?php

namespace MiniCRM\Models;

class CompanyContact {
    public $id;
    public $name;
    public $phone;

    public function __construct(int $id, string $name, string $phone) {
        $this->id = $id;
        $this->name = $name;

        $phoneregx = "/^(\+[0-9]{2})?[0-9]{3,4}-?[0-9]{5,7}$/";

        $this->phone = (preg_match($phoneregx, $phone)) ? $phone : "<invalid>";
    }

    public function get_header(){
        return "{$this->name} ({$this->phone})";
    }
}