<?php
use Test\ObjectMother\Keymarker as TestKeymarker;

class KeymarkerTest extends \PHPUnit_Framework_TestCase
{
    public function testCanBeRepresentedAsAString()
    {
        $this->assertEquals('Friend', strval(TestKeymarker::friend()));
    }
}
