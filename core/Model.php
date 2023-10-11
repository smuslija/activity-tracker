<?php

namespace app\core;
 
abstract class Model
{
    public function loadData($data)
    {
        //Iterate the data coming from request class
        //If RegisterModel has property === to $key, assign $key'value to the prop
        foreach($data as $key=>$value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    public function validate()
    {

    }
}