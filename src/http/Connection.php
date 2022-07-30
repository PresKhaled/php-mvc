<?php

namespace Khaled\PhpMvc\http;

class Connection
{
    public function method(): string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}
