<?php

namespace app\core;

/**
 * Class Router
 *
 * @package app\core
 */
class Router
{
    protected array $routes = [];
    public Request $request;

    /**
     * @param request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->get_path();
        $method = $this->request->get_method();
        $callback = $this->routes[$method][$path];
        if ($callback === false) {
            echo " Note found";
            exit;
        }
        echo call_user_func($callback);
    }
}