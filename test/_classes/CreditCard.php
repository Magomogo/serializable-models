<?php

class CreditCard implements PersistedInterface
{
    private $id;
    private $properties;

    /**
     * @param CreditCard\Properties $properties
     */
    public function __construct($properties)
    {
        $this->properties = $properties;
    }

    public function maskedPan()
    {
        return substr($this->properties->pan, 0, 4) . ' **** **** ' . substr($this->properties->pan, 12, 4);
    }

    public function paymentSystem()
    {
        return $this->properties->paymentSystem;
    }

    public function id()
    {
        return $this->id;
    }

    public function persisted($id)
    {
        $this->id = $id;
    }

    public function meta()
    {
        return array($this->properties->paymentSystem);
    }

    public function serialize()
    {
        return json_encode(
            array('properties' => $this->properties)
        );
    }

    public function unserialize($serialized)
    {
        $data = json_decode($serialized);
        $this->properties = new CreditCard\Properties($data->properties);
    }

}