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
                $id => self::serializedCreditCardCurrentVersion()
            ),
            $storage->querySerializedData('CreditCard')
        );
    }

    private static function serializedCreditCardWithoutAggregatedProperties()
    {
        return <<<'STRING'
{{"pan":"9500000000000001","paymentSystem":"VISA","validTo":"2015-12-31T00:00:00+07:00"}}
STRING;
    }

    private static function serializedCreditCardCurrentVersion()
    {
        return <<<'STRING'
C:10:"CreditCard":102:{{"properties":{"pan":"9500000000000001","paymentSystem":"VISA","validTo":"2015-12-31T00:00:00+07:00"}}}
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