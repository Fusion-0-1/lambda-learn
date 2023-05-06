<?php

namespace Unit;

use app\core\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideRegNo
     */
    public function testGetUserType(string $regNo, string $expected)
    {
        $this->assertEquals($expected, User::getUserType($regNo));
    }

    /* TODO: Move data provider */
    public static function provideRegNo(): array
    {
        return [
            ['2020/CS/001', 'Student'],
            ['2020/IS/001', 'Student'],
            ['2020/LC/001', 'Lecturer'],
            ['2020/AD/001', 'Admin'],
            ['2020/IT/001', 'Invalid'],
        ];
    }
}