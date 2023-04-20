<?php

namespace app\core;

/**
 * Class Application
 *
 * @property $config
 * @property DbConnection $db
 * @package app\core
 */
class Application
{
    public static string $ROOT_DIR;

    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public static DbConnection $db;
    public static Mailer $mailer;
    public static AdminConfiguration $admin_config;

    public function __construct($root_path, $config = [], $admin_config = [])
    {
        self::$ROOT_DIR = $root_path;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        static::$db = DbConnection::getDatabaseInstance($config['db']);
        static::$mailer = Mailer::getMailerInstance($config['mailer']);
        static::$admin_config = new AdminConfiguration($admin_config);
        session_start();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}