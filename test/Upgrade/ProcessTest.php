<?php

namespace Upgrade;

use org\bovigo\vfs\vfsStream;
use Mockery as m;

class ProcessTest extends \PHPUnit_Framework_TestCase {

    protected function setUp()
    {
        vfsStream::setup('previousVersion', null, array(
            'CreditCard.php' => '<?php namespace previousVersion; class CreditCard {} ?>',
            'CreditCard' => array(
                'Properties.php' => '<?php namespace previousVersion\\CreditCard; class Properties {} ?>'
            ),
            'Job' => array(
                'Record' => array(
                    'Single.php' => '<?php namespace previousVersion\\Job\\Record; class Single {} ?>'
                )
            )
        ));
    }

    public function testIteratesOverEachFileInDirectoryWithPreviousVersion()
    {
        $mapper = m::mock();
        $mapper->shouldReceive('map')->with(anInstanceOf('previousVersion\\CreditCard'))->once()
            ->andReturn(new FakePersistedObject);
        $mapper->shouldReceive('map')->with(anInstanceOf('previousVersion\\CreditCard\\Properties'))->once()
            ->andReturn(new FakePersistedObject);
        $mapper->shouldReceive('map')->with(anInstanceOf('previousVersion\\Job\\Record\\Single'))->once()
            ->andReturn(new FakePersistedObject);

        $process = self::process($mapper);

        $process->doUpgrade(self::storageContainingThreeObjectsMock());
    }

    public function testSavesUpgradedObjectsInTheStorage()
    {
        $storage = self::storageContainingThreeObjectsMock();
        $storage->shouldReceive('save')->with(anInstanceOf('Upgrade\\FakePersistedObject'))->times(3);

        $mapper = m::mock(array('map' => new FakePersistedObject()));
        self::process($mapper)->doUpgrade($storage);
    }

//----------------------------------------------------------------------------------------------------------------------

    /**
     * @param $mapper
     * @return Process
     */
    private static function process($mapper)
    {
        return new Process(vfsStream::url('previousVersion'), 'previousVersion', $mapper);
    }

    /**
     * @return \Storage
     */
    private static function storageContainingThreeObjectsMock()
    {
        $storage = m::mock();
        $storage->shouldIgnoreMissing();
        $storage->shouldReceive('querySerializedData')->with('CreditCard')->andReturn(
            array(1 => 'O:10:"CreditCard":0:{}')
        );
        $storage->shouldReceive('querySerializedData')->with('CreditCard\\Properties')->andReturn(
            array(2 => 'O:21:"CreditCard\Properties":0:{}')
        );
        $storage->shouldReceive('querySerializedData')->with('Job\\Record\\Single')->andReturn(
            array(3 => 'O:17:"Job\Record\Single":0:{}')
        );
        return $storage;
    }

}

//----------------------------------------------------------------------------------------------------------------------

class FakePersistedObject implements \PersistedInterface
{
    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }

    public function id()
    {
        // TODO: Implement id() method.
    }

    public function persisted($id)
    {
        // TODO: Implement persisted() method.
    }
}