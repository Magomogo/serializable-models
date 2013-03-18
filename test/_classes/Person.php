<?php

class Person implements PersistedInterface, Serializable
{
    private $id;

    /**
     * @var Person\Properties
     */
    private $properties;

    /**
     * @var CreditCard
     */
    private $creditCard;

    /**
     * @var array()
     */
    private $tags = array();

    /**
     * @param Person\Properties $properties
     * @param CreditCard $cc
     */
    public function __construct($properties, $cc)
    {
        $this->properties = $properties;
        $this->creditCard = $cc;
    }

    public function politeTitle()
    {
        return $this->properties->title . ' ' . $this->properties->firstName . ' ' . $this->properties->lastName;
    }

    public function contactInfo()
    {
        return 'Phone: ' . $this->properties->phone . "\n" . 'Email: ' . $this->properties->email;
    }

    public function phoneNumberIsChanged($newNumber)
    {
        $this->properties->phone = $newNumber;
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
        $meta = array_merge(
            (array)$this->properties,
            $this->creditCard->meta()
        );
        foreach ($this->tags as $tag) {
            $meta = array_merge($meta, $tag->meta());
        }
        return $meta;
    }

    public function serialize()
    {
        $storedTags = array();
        foreach ($this->tags as $tag) {
            $storedTags[] = Storage::get()->save($tag)->id();
        }

        return serialize(array(
            'properties' => $this->properties,
            'creditCard' => Storage::get()->save($this->creditCard)->id(),
            'tags' => $storedTags
        ));
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->properties = $data['properties'];
        $this->creditCard = Storage::get()->load($data['creditCard']);
        $this->tags = array();
        foreach ($data['tags'] as $tagId) {
            $this->tags[] = Storage::get()->load($tagId);
        }
    }
}