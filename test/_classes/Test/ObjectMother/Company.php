<?php
namespace Test\ObjectMother;

use Company as Model;

class Company
{
    public static function xiag()
    {
        return new Model('XIAG');
    }

    public static function nstu()
    {
        return new Model('NSTU');
    }
}
