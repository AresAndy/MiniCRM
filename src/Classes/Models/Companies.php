<?php

use MiniCRM\Models\Company;

namespace MiniCRM\Models;

class Companies {
    private $arr;

    public function __construct(array $companies = array()){
        
        $this->arr = array_reduce(
            $companies,

            function($carry, $el){
                if(is_a($el, "Company")){
                    array_push($carry, $el);
                }

                return $carry;
            },
            array()
        );

        return $this;
    }
    
    public function get(int $n = null){
        if(isset($n)){
            return $this->arr[$n];
        } else {
            return $this->arr;
        }
    }

    public function set(int $n)
}