<?php

namespace app\core;

/**
 * Class Request
 * 
 * @package app\core
 */

class Request
{
    public function get_path()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function get_method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}