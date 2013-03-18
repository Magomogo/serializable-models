<?php
namespace Test\ObjectMother;

use Person as Model;
use Person\Properties as Properties;

class Person
{
    public static function maxim($id = null, $ccId = null)
    {
        $m = new Model(new Properties(array(
            'title' => 'Mr.',
            'firstName' => 'Maxim',
            'lastName' => 'Gnatenko',
            'phone' => '+7923-117-2801',
            'email' => 'maxim@xiag.ch',
            )),
            CreditCard::datatransTesting($ccId)
        );
        if ($id) {
            $m->persisted($id);
        }
        return $m;
    }
}
