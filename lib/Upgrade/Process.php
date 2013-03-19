<?php

namespace Upgrade;

class Process 
{
    /**
     * @param string $serializedObject previous version
     * @return string serialized object of current version
     */
    public function doUpgrade($serializedObject)
    {
        spl_autoload_register(array($this, 'autoloader'));
        $previousCreditCard = self::previosObject($serializedObject, 'recentVersions\v0_1\CreditCard');
        spl_autoload_unregister(array($this, 'autoloader'));

        print_r($previousCreditCard);

        return $serializedObject;
    }

    public function autoloader($className)
    {
        include dirname(dirname(__DIR__)) . '/test/Upgrade/' . str_replace('\\', '/', $className) . '.php';
    }

//----------------------------------------------------------------------------------------------------------------------

    private static function previosObject($serialized, $className) {
        return unserialize(sprintf(
                'C:%d:"%s"%s',
                strlen($className),
                $className,
                strstr(strstr($serialized, '"'), ':')
            ));
    }

}