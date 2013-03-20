<?php
namespace previousVersions;

class CreditCard implements \PersistedInterface
{
    private $id;
    private $pan;
    private $paymentSystem;
    private $validTo;

    /**
     * @param string $pan
     * @param string $paymentSystem
     * @param \DateTime $validTo
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
        return json_encode(
            array('pan' => $this->pan, 'paymentSystem' => $this->paymentSystem, 'validTo' => $this->validTo)
        );
    }

    public function unserialize($serialized)
    {
        $data = json_decode($serialized);
        $this->pan = $data->pan;
        $this->paymentSystem = $data->paymentSystem;
        $this->validTo = new \Datetime($data->validTo);
    }

}