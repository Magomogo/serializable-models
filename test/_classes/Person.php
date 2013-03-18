<?php

class Person
{
    private $title;

    private $firstName;

    private $lastName;

    private $phone;

    private $email;

    /**
     * @var
     */
    private $creditCard;

    /**
     * @var array()
     */
    private $tags;

    /**
     * @param $title
     * @param $firstName
     * @param $lastName
     * @param $phone
     * @param $email
     * @param CreditCard $cc
     */
    public function __construct($title, $firstName, $lastName, $phone, $email, $cc)
    {
        $this->title = $title;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->email = $email;
        $this->creditCard = $cc;
    }

    public function politeTitle()
    {
        return $this->title . ' ' . $this->firstName . ' ' . $this->lastName;
    }

    public function contactInfo()
    {
        return 'Phone: ' . $this->phone . "\n" . 'Email: ' . $this->email;
    }

    public function phoneNumberIsChanged($newNumber)
    {
        $this->phone = $newNumber;
    }

    public function paymentInfo()
    {
        return $this->ableToPay() ?
            $this->creditCard->paymentSystem() . ', ' . $this->creditCard->maskedPan() : null;
    }

    public function ableToPay()
    {
        return !is_null($this->creditCard);
    }

    public function tag(Keymarker $keymarker)
    {
        $this->tags[] = $keymarker;
    }

    public function taggedAs()
    {
        return join(', ', $this->tags);
    }
}