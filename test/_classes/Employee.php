<?php

class Employee extends Person
{
    /**
     * @var Company
     */
    private $company;

    /**
     * @param Company $company
     * @param Person\Properties $properties
     * @param CreditCard $cc
     */
    public function __construct($company, $properties, $cc)
    {
        parent::__construct($properties, $cc);
        $this->company = $company;
    }

    public function greeting()
    {
        return $this->politeTitle() . ' from ' . $this->company->name();
    }

    public function serialize()
    {
        $data = $this->serializableState();
        $data['company'] = $this->company->id();

        return json_encode($data);
    }

    public function unserialize($serialized)
    {
        parent::unserialize($serialized);
        $data = json_decode($serialized);
        $this->company = Storage::get()->load($data->company);
    }
}