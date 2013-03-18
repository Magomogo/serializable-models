<?php

class CreditCard
{
    private $pan;
    private $paymentSystem;
    private $validTo;

    /**
     * @param string $pan
     * @param string $paymentSystem
     * @param DateTime $validTo
     */
    public function __construct($pan, $paymentSystem, $validTo)
    {
        $this->pan = $pan;
        $this->paymentSystem = $paymentSystem;
        $this->validTo = $validTo;
    }

    public function maskedPan()
    {
        return substr($this->pan, 0, 4) . ' **** **** ' . substr($this->pan, 12, 4);
    }

    public function paymentSystem()
    {
        return $this->paymentSystem;
    }

}