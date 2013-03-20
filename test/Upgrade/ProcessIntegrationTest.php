<?php

namespace Upgrade;

use CreditCard;
use Mockery as m;
use Test\DbFixture;

class ProcessIntegrationTest extends \PHPUnit_Framework_TestCase
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

    public function testTransformsPreviousRepresentationOfObjectIntoCurrent()
    {
        $process = new Process(__DIR__ . '/previousVersions', 'previousVersions', new TestCreditCardMapper);

        $storage = new \Storage($this->fixture->db);
        $id = self::saveCreditCardPreviousVersion($this->fixture->db);

        $process->doUpgrade($storage);

        $this->assertEquals(
            array(
                array(
                    'id' => $id,
                    'serialized' => self::serializedCreditCardCurrentVersion()
                )
            ),
            $storage->querySerializedData('CreditCard')->fetchAll()
        );
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

    /**
     * @param \Doctrine\DBAL\Connection $db
     * @return string
     */
    private static function saveCreditCardPreviousVersion($db)
    {
        $db->insert('objects', array(
                'className' => 'CreditCard',
                'serialized' => self::serializedCreditCardWithoutAggregatedProperties()
            ));
        return $db->lastInsertId();
    }
}

//----------------------------------------------------------------------------------------------------------------------

class TestCreditCardMapper implements MapperInterface
{

    /**
     * @param \PersistedInterface $previousVersion
     * @return \PersistedInterface $currentVersion
     */
    public function map($previousVersion)
    {
        $cc = new CreditCard(new CreditCard\Properties(array(
            'pan' => $this->readProperty($previousVersion, 'pan'),
            'paymentSystem' => $this->readProperty($previousVersion, 'paymentSystem'),
            'validTo' => $this->readProperty($previousVersion, 'validTo'),
        )));

        return $cc;
    }

    private function readProperty($obj, $name)
    {
        $reflectedClass = new \ReflectionClass($obj);
        $property = $reflectedClass->getProperty($name);
        $property->setAccessible(true);

        return $property->getValue($obj);
    }
}