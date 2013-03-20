<?php

namespace CreditCard;

class Properties implements \JsonSerializable
{
    public $pan;

    public $paymentSystem;

    /**
     * @var \DateTime
     */
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

    function jsonSerialize()
    {
        return array_merge(
            get_object_vars($this),
            array(
                'validTo' => $this->validTo ? $this->validTo->format('c') : null
            )
        );
    }
}