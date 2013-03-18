<?php
namespace Test\ObjectMother;

use CreditCard as Model;

class CreditCard
{
    public static function datatransTesting($id = null)
    {
        $cc = new Model('9500000000000001', 'VISA', new \DateTime('31-12-2015'));
        if ($id) {
            $cc->persisted($id);
        }
        return $cc;
    }
}
