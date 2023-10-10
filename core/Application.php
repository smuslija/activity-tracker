<?php

namespace app\core;

class Application
{   
    public static Application $app;
    public static string $ROOT_DIR;

    public Request $request;
    public Response $response;
    public Router $router;

    public function __construct($rootPath)
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo($this->router->resolve());
    }
}