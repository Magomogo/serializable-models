<?php

use Test\ObjectMother\CreditCard as TestCard;

class CreditCardTest extends \PHPUnit_Framework_TestCase
{
    public function testDatatransTestingCreditCard()
    {
        $this->assertEquals(
            '9500 **** **** 0001',
            TestCard::datatransTesting()->maskedPan()
        );
    }
}
