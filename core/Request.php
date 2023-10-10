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

    public static function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public static function getBody()
    {
        $body = [];

        if(self::getMethod() === 'get')
        {   
            //iterate the superglobal GET
            foreach($_GET as $key => $value)
            {
                //Look the $key, take vthe value, sanitize it and put it inside body
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if(self::getMethod() == 'post')
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