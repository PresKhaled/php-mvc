<?php

namespace App;


use Khaled\PhpMvc\support\WithArrayAccess;

class Config extends WithArrayAccess
{
    /**
     * @param array $items -
     */
    public function __construct(array $items)
    {
        parent::__construct($items);
    }
}
