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

    public function meta()
    {
        return array_merge(
            parent::meta(),
            $this->company->meta()
        );
    }

    public function serialize()
    {
        $data = $this->serializableState();
        $data['company'] = $this->company->id();

        return serialize($data);
    }

    public function unserialize($serialized)
    {
        parent::unserialize($serialized);
        $data = unserialize($serialized);
        $this->company = Storage::get()->load($data['company']);
    }
}