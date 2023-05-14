<?php

namespace Unit;

use app\core\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideRegNoType
     */
    public function testGetUserType(string $regNo, string $expected)
    {
        $this->assertEquals($expected, User::getUserType($regNo));
    }

    /* TODO: Move data provider */
    public static function provideRegNoType(): array
    {
        return [
            ['2020/CS/0001', 'Student'],
            ['2020/IS/0001', 'Student'],
            ['2020/LC/0001', 'Lecturer'],
            ['2020/AD/0010', 'Admin'],
//            ['2020/IT/001', 'Invalid'],
        ];
    }

//    /**
//     * @test
//     * @dataProvider provideAuthentication
//     */
//    public function testAuthenticateUser(string $regNo, string $password, bool $expectedResult)
//    {
//        $result = User::authenticateUser($regNo, $password);
//        $this->assertEquals($expectedResult, $result);
//    }
//
//    public function provideAuthentication(): array
//    {
//        return [
//            ['2020/CS/0011', '20000011@CS', true],
//            ['2003/LC/0004', '20030004@LC', true],
//            ['55555', 'qwerty123', true],
//            ['99999', 'invalid', false],
//        ];
//    }

}