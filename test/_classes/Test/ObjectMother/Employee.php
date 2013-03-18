<?php
namespace Test\ObjectMother;

use Employee as EmployeeModel;

class Employee
{
    public static function maxim($id = null)
    {
        return new EmployeeModel(Company::xiag(), 'Mr.', 'Maxim', 'Gnatenko', '+7923-117-2801', 'maxim@xiag.ch',
            CreditCard::datatransTesting());
    }

}
