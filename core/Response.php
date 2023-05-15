<?php

namespace app\core;

/**
 * Class Response
 *
 * @package app\core
 */
class Response
{
    /**
     * @description Set status code of response
     * @param $code
     * @return void
     */
    public function set_status_code($code)
    {
        http_response_code($code);
    }
}