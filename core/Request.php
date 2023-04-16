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
                if (is_array($value)) {
                    // If the value is an array, recursively sanitize each element
                    $subArray = $this->sanitizeArray($value);
                    $body[$key] = $subArray;
                } else {
                    // Special Characters - < > " ' & are encoded to HTML entities : &lt; &gt; &quot; &apos; &amp;
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
        if ($this->isPost()) {
            $postArray = $this->sanitizeArray($_POST);
            foreach ($postArray as $key => $value) {
                // Append each key with square brackets to differentiate levels of nesting
                $body[$key] = $value;
            }
        }
        return $body;
    }

    private function sanitizeArray($array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                // If the nested value is an array, recursively sanitize each element
                $result[$key] = $this->sanitizeArray($value);
            } else {
                // If the value is a scalar, sanitize using FILTER_SANITIZE_SPECIAL_CHARS
                $result[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $result;
    }

    public function getFile()
    {
        return $_FILES['file'];
    }
}