<?php
namespace Test\ObjectMother;

use CreditCard as Model;

class CreditCard
{
    public static function datatransTesting()
    {
        return new Model('9500000000000001', 'VISA', new \DateTime('31-12-2015'));
    }
}
