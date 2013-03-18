<?php
namespace Test\ObjectMother;

use Person as Model;

class Person
{
    public static function maxim($id = null)
    {
        $m = new Model('Mr.', 'Maxim', 'Gnatenko', '+7923-117-2801', 'maxim@xiag.ch', CreditCard::datatransTesting());
        if ($id) {
            $m->persisted($id);
        }
        return $m;
    }
}
