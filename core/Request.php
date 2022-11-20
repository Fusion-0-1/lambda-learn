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

    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function is_get(): bool
    {
        return $this->method() === 'get';
    }

    public function is_post(): bool
    {
        return $this->method() === 'post';
    }

    public function get_body()
    {
        $body = [];
        if ($this->is_get()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->is_post()) {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}