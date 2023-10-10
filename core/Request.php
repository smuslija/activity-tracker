<?php
 
namespace app\core;

class Request
{
    public static function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        $position = strpos($path, '?');

        if($position === false){
            return $path;
        }

        return substr($path, 0 ,$position);
    }

    public static function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet()
    {
        if ($this->method() === 'get')
        {
            return true;
        }
    }
    
    public function isPost()
    {
        if ($this->method() === 'post')
        {
            return true;
        }
    }

    public  function getBody()
    {
        $body = [];

        if($this->method() === 'get')
        {   
            //iterate the superglobal GET
            foreach($_GET as $key => $value)
            {
                //Look the $key, take vthe value, sanitize it and put it inside body
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if($this->method() == 'post')
        {
             //iterate the superglobal POST
             foreach($_POST as $key => $value)
             {
                 //Look the $key, take vthe value, sanitize it and put it inside body
                 $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
             }
        }
        return $body;
    }
}