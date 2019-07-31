<?php

namespace MiniCRM\Models;

/**
 * This is a helper to keep the XHR responses JSON consistent througout the system. 
 */
class JSONResp {
    public $status;
    public $data;

    public function __construct($status, $data = array()) {
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * Prepares the array to be sent by the Slim Framework
     * @return array
     */
    public function to_assoc(){
        return array(
            "result" => $this->status,
            "data" => $this->data
        );
    }
}