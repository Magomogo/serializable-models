<?php

use Mockery as m;
use Test\ObjectMother as TestObj;
use Person as Model;

class PersonTest extends \PHPUnit_Framework_TestCase
{
    public function testCreatingANewPerson()
    {
        TestObj\Person::maxim();
    }

    public function testReadItsPropertiesToImplementSomeBusinessLogic()
    {
        $this->assertEquals(
            'Mr. John Doe',
            self::person()->politeTitle()
        );
    }

    public function testStateCanBeChangedByAMessage()
    {
        $person = self::person();
        $person->phoneNumberIsChanged('335-65-66');

        $this->assertContains('Phone: 335-65-66', $person->contactInfo());
    }

    public function testHasAccessToCreditCardModel()
    {
        $this->assertEquals('VISA, 9500 **** **** 0001', self::person()->paymentInfo());
    }

    public function testBehaviorWhenNoCreditCard()
    {
        $this->assertNull(self::personWithoutCreditCard()->paymentInfo());
        $this->assertFalse(self::personWithoutCreditCard()->ableToPay());
    }

    public function testCanBeTaggedWithAKeymarker()
    {
        $person = self::person();
        $person->tag(TestObj\Keymarker::friend());
        $person->tag(TestObj\Keymarker::IT());

        $this->assertEquals('Friend, IT', $person->taggedAs());
    }

//----------------------------------------------------------------------------------------------------------------------

    private static function person()
    {
        return new Model('Mr.', 'John', 'Doe', '+7923-117-2801', 'maxim@xiag.ch', TestObj\CreditCard::datatransTesting());
    }

    private static function personWithoutCreditCard()
    {
        return new Model('Mr.', 'John', 'Doe', '+7923-117-2801', 'maxim@xiag.ch', null);
    }
}
