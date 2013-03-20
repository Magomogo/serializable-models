<?php
namespace Test\ObjectMother;

use CreditCard as Model;
use CreditCard\Properties as Properties;

class CreditCard
{
    public static function datatransTesting($id = null)
    {
        $cc = new Model(new Properties(
            array(
                'pan' => '9500000000000001',
                'paymentSystem' => 'VISA',
                'validTo' => new \DateTime('2015-12-31T00:00:00+07:00')
            )
        ));
        if ($id) {
            $cc->persisted($id);
        }
        return $cc;
    }
}
