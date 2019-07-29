<?php

namespace MiniCRM\Models;

abstract class Company implements Company_able{
    public $type;

    public function __construct(int $id, string $name = null, string $address = null, $typename){
        $this->id = $id;
        $this->name =    ($name) ? $name : "<noname>";
        $this->address = ($address) ? $address : "<noaddress>";
        $this->type = $typename;
    }

    public abstract function get_header();
}