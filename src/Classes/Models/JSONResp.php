<?php

namespace MiniCRM\Models;

class JSONResp {
    public $status;
    public $data;

    public function __construct($status, $data = array()) {
        $this->status = $status;
        $this->data = $data;
    }

    public function to_assoc(){
        return array(
            "result" => $this->status,
            "data" => $this->data
        );
    }
}