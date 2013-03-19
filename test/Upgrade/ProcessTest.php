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

    /*
        public function testTransformsPreviousRepresentationOfObjectIntoCurrent()
        {
            $this->markTestIncomplete('Not implemented');

            $process = new Process();

            $this->assertEquals(
                self::serializedCreditCardCurrentVersion(),
                $process->doUpgrade(
                    self::serializedCreditCardWithoutAggregatedProperties()
                )
            );
        }*/

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
            m::mock(
                '',
                function ($mock) {
                    $mock->shouldReceive('fetch')->andReturn(
                        array('id' => 1, 'serialized' => 'O:10:"CreditCard":0:{}'),
                        false
                    );
                }
            )
        );
        $storage->shouldReceive('querySerializedData')->with('CreditCard\\Properties')->andReturn(
            m::mock(
                '',
                function ($mock) {
                    $mock->shouldReceive('fetch')->andReturn(
                        array('id' => 2, 'serialized' => 'O:21:"CreditCard\Properties":0:{}'),
                        false
                    );
                }
            )
        );
        $storage->shouldReceive('querySerializedData')->with('Job\\Record\\Single')->andReturn(
            m::mock(
                '',
                function ($mock) {
                    $mock->shouldReceive('fetch')->andReturn(
                        array('id' => 3, 'serialized' => 'O:17:"Job\Record\Single":0:{}'),
                        false
                    );
                }
            )
        );
        return $storage;
    }

    private static function serializedCreditCardWithoutAggregatedProperties()
    {
        return <<<'STRING'
C:10:"CreditCard":207:{a:3:{s:3:"pan";s:16:"9500000000000001";s:13:"paymentSystem";s:4:"VISA";s:7:"validTo";O:8:"DateTime":3:{s:4:"date";s:19:"2015-12-31 00:00:00";s:13:"timezone_type";i:3;s:8:"timezone";s:16:"Asia/Novosibirsk";}}}
STRING;
    }

    private static function serializedCreditCardCurrentVersion()
    {
        return <<<'STRING'
C:10:"CreditCard":258:{a:1:{s:10:"properties";O:21:"CreditCard\Properties":3:{s:3:"pan";s:16:"9500000000000001";s:13:"paymentSystem";s:4:"VISA";s:7:"validTo";O:8:"DateTime":3:{s:4:"date";s:19:"2015-12-31 00:00:00";s:13:"timezone_type";i:3;s:8:"timezone";s:16:"Asia/Novosibirsk";}}}}
STRING;
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

    public function meta()
    {
        // TODO: Implement meta() method.
    }
}