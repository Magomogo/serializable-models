<?php

use Test\ObjectMother\Company as TestCompany;

use Mockery as m;

class CompanyTest extends \PHPUnit_Framework_TestCase
{
    public function testAnInstance()
    {
        new Company('Name');
    }

    public function testProperties()
    {
        $this->assertEquals('XIAG', TestCompany::xiag()->name());
    }
}
