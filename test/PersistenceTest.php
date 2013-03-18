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

        $this->assertEquals(
            ObjectMother\Person::maxim(1),
            $this->storage()->load($id)
        );
    }

    public function testPersonAndItsCreditCardAreStoredSeparately()
    {
        $this->markTestIncomplete('Not implemented');
        
        $this->storage()->save(ObjectMother\Person::maxim());

        $this->assertEquals(
            array(
                array('id' => 1, 'className' => 'CreditCard'),
                array('id' => 2, 'className' => 'Person'),
            ),
            $this->fixture->db->fetchAll("SELECT id, className FROM objects")
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
