<?php

namespace Person;

class Properties 
{
    public $title;

    public $firstName;

    public $lastName;

    public $phone;

    public $email;

    public function __construct($properties)
    {
        foreach ($properties as $name => $value) {
            $this->$name = $value;
        }
    }

    public function __set($name, $value)
    {
        trigger_error('Undefined property: ' . $name, E_USER_NOTICE);
    }

}