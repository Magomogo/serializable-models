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
     * @param $title
     * @param $firstName
     * @param $lastName
     * @param $phone
     * @param $email
     * @param CreditCard $cc
     */
    public function __construct($company, $title, $firstName, $lastName, $phone, $email, $cc)
    {
        parent::__construct($title, $firstName, $lastName, $phone, $email, $cc);
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
}