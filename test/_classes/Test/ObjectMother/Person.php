<?php
namespace Test\ObjectMother;

use Person as Model;

class Person
{
    public static function maxim()
    {
        return new Model('Mr.', 'Maxim', 'Gnatenko', '+7923-117-2801', 'maxim@xiag.ch', CreditCard::datatransTesting());
    }
}
