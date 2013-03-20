<?php

namespace CreditCard;

class PropertiesTest extends \PHPUnit_Framework_TestCase
{
    public function testJsonSerializable()
    {
        $this->assertEquals(
            '{"pan":"1234567890","paymentSystem":"Fake","validTo":"2013-02-01T00:00:00+07:00"}',
            json_encode(
                new Properties(
                    array('pan' => '1234567890', 'paymentSystem' => 'Fake', 'validTo' => new \DateTime('2013-02-01')
                ))
            )
        );
    }
}
