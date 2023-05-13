<?php

namespace app\core;

/**
 * Class Router
 *
 * @package app\core
 */
class Router
{
    /**
     * @var array
     */
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

    /**
     * @description Add get route
     * @param $path
     * @param $callback
     * @return void
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * @description Add post route
     * @param $path
     * @param $callback
     * @return void
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @description Resolve route
     * @return array|false|mixed|string|string[]
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->set_status_code(404);
            return $this->renderView('error_404');
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            $callback[0] = new $callback[0](); // Create an instance of the class
        }
        return call_user_func($callback, $this->request);
    }

    /**
     * @description Render the view with layout
     * @param $view
     * @param $params
     * @return array|false|string|string[]
     */
    public function renderView($view, $params = [])
    {
        $layout_content = $this->layoutContent();
        $view_content = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $view_content, $layout_content);
    }

    /**
     * @param $view_content
     * @return array|false|string|string[]
     */
    public function renderContent($view_content)
    {
        $layout_content = $this->layoutContent();
        return str_replace('{{content}}', $view_content, $layout_content);
    }

    /**
     * @return false|string
     */
    protected function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/main.php";
        return ob_get_clean();
    }

    /**
     * @description Render the view without layout
     * @param $view
     * @param $params
     * @return false|string
     */
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