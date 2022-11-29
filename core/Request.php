<?php

namespace app\core;

/**
 * Class Request
 * 
 * @package app\core
 */

class Request
{
    public function getPath()
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

    public function isGet(): bool
    {
        return $this->method() === 'get';
    }

    public function isPost(): bool
    {
        return $this->method() === 'post';
    }

    public function getBody()
    {
        $body = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                // Special Characters - < > " ' & are encoded to HTML entities : &lt; &gt; &quot; &apos; &amp;
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                // Special Characters - < > " ' & are encoded to HTML entities : &lt; &gt; &quot; &apos; &amp;
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}