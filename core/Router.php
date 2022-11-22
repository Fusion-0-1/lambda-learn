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
    public Response $response;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->set_status_code(404);
            return $this->renderView('error_404'); //TODO: use renderOnlyView and create a separate page here
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            $callback[0] = new $callback[0](); // Create an instance of the class
        }
        return call_user_func($callback, $this->request);
    }

    public function renderView($view, $params = [])
    {
        $layout_content = $this->layoutContent();
        $view_content = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $view_content, $layout_content);
    }

    public function renderContent($view_content)
    {
        $layout_content = $this->layoutContent();
        return str_replace('{{content}}', $view_content, $layout_content);
    }

    protected function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/main.php";
        return ob_get_clean();
    }

    public function renderOnlyView($view, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}