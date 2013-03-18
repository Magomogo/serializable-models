<?php


class Employee extends Person
{
    private $id;
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
        return array_merge(
            parent::meta(),
            array($this->company->meta())
        );
    }

}