<?php

class Keymarker implements PersistedInterface
{
    private $id;

    /**
     * @var string
     */
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function id()
    {
        return $this->id;
    }

    public function persisted($id)
    {
        $this->id = $id;
    }

    public function serialize()
    {
        return json_encode(array('name' => $this->name));
    }

    public function unserialize($serialized)
    {
        $this->name = json_decode($serialized)->name;
    }
}