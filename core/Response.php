<?php

namespace app\core;

/**
 * Class Response
 *
 * @package app\core
 */
class Response
{
    public function set_status_code($code)
    {
        http_response_code($code);
    }
}