<?php

namespace MiniCRM\Models;

interface Company_able {
    public function __construct(int $id, int $type, string $typename, string $name = null, string $address = null);
    /** A company should be able to have a string representation of its data (like in a letter header)
     * @return string
     */
    public function get_header();
}