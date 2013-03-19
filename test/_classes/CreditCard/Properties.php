<?php

namespace CreditCard;

class Properties 
{
    public $pan;

    public $paymentSystem;

    public $validTo;

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