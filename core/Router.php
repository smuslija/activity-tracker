<?php

namespace app\core;

class Router
{   
    protected array $routes = [];

    public Request $request;
    public Response $response;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
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
        $path =  $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        
        if($callback === false)
        {
            $this->response->setStatusCode(404);
            return $this->renderView('_404');
        }
        
        if(is_string($callback))
        {
            return $this->renderView($callback);
        }

        //Creteing instance of Controller
        if(is_array($callback))
        {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        } 
        return call_user_func($callback, $this->request);
    }

    public function renderView($view, $params = [])
    {
        $viewContent = $this->viewContent($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent );
    }
    
    public function viewContent($view, $params)
    {
        foreach($params as $key => $value){
            //creates a variable with name from the $key and value from $value
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";   
        return ob_get_clean();     
    }

    public function layoutContent()
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }
}