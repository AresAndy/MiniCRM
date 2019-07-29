<?php

namespace MiniCRM\Models;

interface Company_able {
    public function __construct(int $id, string $name = null, string $address = null, $typename);
    public function get_header();
}