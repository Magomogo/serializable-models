<?php


class Company implements PersistedInterface
{
    private $id;
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function name()
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

    public function meta()
    {
        return array($this->name);
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