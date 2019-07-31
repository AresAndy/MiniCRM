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
}