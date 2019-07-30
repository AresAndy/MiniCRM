<?php

namespace MiniCRM\Models;

abstract class Company implements Company_able{
    public $type;

    public function __construct(int $id, int $type, string $typename, string $name = null, string $address = null){
        $this->id = $id;
        $this->name =    ($name) ? $name : "<noname>";
        $this->address = ($address) ? $address : "<noaddress>";
        $this->type = $typename;
        $this->typeid = $type;
    }

    public abstract function get_header();
}