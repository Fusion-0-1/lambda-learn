<?php

namespace app\core;

/**
 * Class Request
 * 
 * @package app\core
 */

class Request
{
    /**
     * @description Get path from url
     * @return mixed|string
     */
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    /**
     * @description Get method from url
     * @return string
     */
    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @description Check if request is get
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->method() === 'get';
    }

    /**
     * @description Check if request is post
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->method() === 'post';
    }

    /**
     * @description Get body from url
     * @return array
     */
    public function getBody()
    {
        $body = [];
        if ($this->isGet()) {
            $getArray = $this->sanitizeArray($_GET);
            foreach ($getArray as $key => $value) {
                // Append each key with square brackets to differentiate levels of nesting
                $body[$key] = $value;
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

    /**
     * @param $array
     * @return array
     */
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

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $_FILES['file'];
    }

    public function query()
    {
    }
}