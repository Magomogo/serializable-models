<?php
namespace Test\ObjectMother;

use Keymarker as Model;

class Keymarker
{
    public static function friend()
    {
        return new Model('Friend');
    }

    public static function IT()
    {
        return new Model('IT');
    }

}
