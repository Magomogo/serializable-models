<?php
namespace Test\ObjectMother;

use Employee as EmployeeModel;
use Person\Properties as Properties;

class Employee
{
    /**
     * @param null $id
     * @param null|\Company $company
     * @return \Employee
     */
    public static function maxim($id = null, $company = null)
    {
        return new EmployeeModel(
            $company ?: Company::xiag(),
            new Properties(array(
                'title' => 'Mr.',
                'firstName' => 'Maxim',
                'lastName' => 'Gnatenko',
                'phone' => '+7923-117-2801',
                'email' => 'maxim@xiag.ch',
            )),
            CreditCard::datatransTesting()
        );
    }

}
