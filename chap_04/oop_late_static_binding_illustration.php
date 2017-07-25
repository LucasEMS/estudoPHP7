<?php
class Test2
{
    public static $test = 'TEST2';
    public static function getEarlyTest()
    {
        return self::$test;
    }
    public static function getLateTest()
    {
        return static::$test;
    }
}

class Child extends Test2
{
    public static $test = 'CHILD';
}

echo Test2::$test . PHP_EOL;
echo Child::$test . PHP_EOL;
echo Child::getEarlyTest() . PHP_EOL;
echo Child::getLateTest() . PHP_EOL;