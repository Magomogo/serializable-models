<?php

namespace Upgrade;

class ProcessTest extends \PHPUnit_Framework_TestCase {

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
    }

//----------------------------------------------------------------------------------------------------------------------

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
