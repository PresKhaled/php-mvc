<?php

namespace App;

use ArrayAccess;
use Minwork\Helper\Arr;

class Config extends WithArrayAccess {
    public function __construct(array $items)
    {
        parent::__construct($items);
    }
}
