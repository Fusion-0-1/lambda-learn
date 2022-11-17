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

    public function resolve()
    {
        $path = $this->request->get_path();
        $method = $this->request->get_method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->set_status_code(404);
            return " Not found";
        }
        if (is_string($callback)) {
            return $this->render_view($callback);
        }
        return call_user_func($callback);
    }

    public function render_view($view)
    {
        $layout_content = $this->layout_content();
        $view_content = $this->render_only_view($view);
        return str_replace('{{content}}', $view_content, $layout_content);
    }

    protected function layout_content()
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/main.php";
        return ob_get_clean();
    }

    protected function render_only_view($view)
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}