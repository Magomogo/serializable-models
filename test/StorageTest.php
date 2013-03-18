<?php
use Test\DbFixture;
use Test\ObjectMother\CreditCard;

class StorageTest extends PHPUnit_Framework_TestCase
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

    public function testInsertsInStorage()
    {
        $cc = CreditCard::datatransTesting();
        $this->assertNull($cc->id());
        $cc = $this->storage()->save($cc);
        $this->assertNotNull($cc->id());
        $this->assertContains('CreditCard', $this->fixture->db->fetchArray('SELECT * FROM objects'));
    }

    public function testLoadsFromStorage()
    {
        $id = $this->storage()->save(CreditCard::datatransTesting())->id();

        $this->assertEquals(CreditCard::datatransTesting(1), $this->storage()->load($id));
    }

    public function testUpdatesStorage()
    {
        $cc = CreditCard::datatransTesting();
        $this->storage()->save($cc);
        $this->storage()->save($cc);

        $this->assertEquals(1, $cc->id());
    }

//----------------------------------------------------------------------------------------------------------------------

    private function storage()
    {
        return new Storage($this->fixture->db);
    }
}
