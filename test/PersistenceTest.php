<?php

use Test\DbFixture;
use Test\ObjectMother;

class PersistenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DbFixture
     */
    private $fixture;

    protected function setUp()
    {
        $this->fixture = new DbFixture();
        $this->fixture->install();
    }

    public function testFixtureHasCorrectTablesCreated()
    {
        $this->assertEquals(array(), $this->fixture->db->fetchAll("SELECT * FROM objects"));
    }

    public function testAPersonHavingCreditCardFitsInTheStorage()
    {
        $id = $this->storage()->save(ObjectMother\Person::maxim())->id();

        print_r($this->fixture->db->fetchAll("SELECT * FROM objects"));

        $this->assertEquals(
            ObjectMother\Person::maxim('2', '1'),
            $this->storage()->load($id)
        );
    }

    public function testPersonAndItsCreditCardAreStoredSeparately()
    {
        $this->storage()->save(ObjectMother\Person::maxim());

        $this->assertEquals(
            array(
                array('id' => 1, 'className' => 'CreditCard'),
                array('id' => 2, 'className' => 'Person'),
            ),
            $this->fixture->db->fetchAll("SELECT id, className FROM objects")
        );
    }

    public function testPersonHavingTagsPersists()
    {
        $person = ObjectMother\Person::maxim();
        $person->tag(ObjectMother\Keymarker::friend());
        $person->tag(ObjectMother\Keymarker::IT());
        $id = $this->storage()->save($person)->id();

        $this->assertEquals(
            $person,
            $this->storage()->load($id)
        );

        $this->assertEquals(
            array(
                array('className' => 'Keymarker'),
                array('className' => 'Keymarker'),
                array('className' => 'CreditCard'),
                array('className' => 'Person'),
            ),
            $this->fixture->db->fetchAll("SELECT className FROM objects")
        );
    }

    public function testEmployeeIsPersists()
    {
        $xiag = $this->storage()->save(ObjectMother\Company::xiag());
        $employee = $this->storage()->save(ObjectMother\Employee::maxim(null, $xiag), $xiag->id());

        $this->assertEquals(
            $employee,
            $this->storage()->load($employee->id())
        );
    }

    public function testCompanyIsPersists()
    {
        $xiag = $this->storage()->save(ObjectMother\Company::xiag());

        $this->assertEquals(
            $xiag,
            $this->storage()->load($xiag->id())
        );
    }

    public function testKeymarkerIsPersists()
    {
        $keymarker = $this->storage()->save(ObjectMother\Keymarker::IT());

        $this->assertEquals(
            $keymarker,
            $this->storage()->load($keymarker->id())
        );
    }

//----------------------------------------------------------------------------------------------------------------------

    /**
     * @return Storage
     */
    private function storage()
    {
        return new Storage($this->fixture->db);
    }
}
