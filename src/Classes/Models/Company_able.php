<?php

namespace MiniCRM\Models;

interface Company_able {
    public function __construct(int $id, int $type, string $typename, string $name = null, string $address = null);
    public function get_header();
}