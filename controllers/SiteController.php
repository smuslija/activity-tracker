<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SiteController  extends Controller
{
    public  function home()
    {
        $params =[
            "name" => "Sokol"
        ];
        return $this->render('home', $params);
    }

    public  function contact()
    {
        return $this->render('contact');
    }

    public static function handleContact(Request $request)
    {
        //access request instance
        $body = $request->getBody();
        var_dump($body);
        return('Handle submitting data from controller');
    }
}