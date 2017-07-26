<?php
// NOTE: only works in PHP 7.1 and above!

class Test
{
    public const TEST_WHOLE_WORLD   = 'visible.everywhere';
    protected const TEST_INHERITED  = 'this.can.be.seen.in.child.classes';
    private const TEST_LOCAL        = 'local.to.class.Test.only';
    public static function getTestInherited()
    {
        return static::TEST_INHERITED;
    }
    public static function getTestLocal()
    {
        return static::TEST_LOCAL;
    }
}

class Child extends Test
{
    // some other code
}

echo Test::TEST_WHOLE_WORLD;    // returns 'visible.everywhere';
echo PHP_EOL;
echo Test::getTestInherited();  // returns 'this.can.be.seen.in.child.classes';
echo PHP_EOL;
echo Test::getTestLocal();      // returns 'local.to.class.Test.only'
echo PHP_EOL;
echo Child::TEST_WHOLE_WORLD;   // returns 'visible.everywhere';
echo PHP_EOL;
echo Child::getTestInherited(); // returns 'this.can.be.seen.in.child.classes';
echo PHP_EOL;
// all of the following generate errors
echo Test::TEST_INHERITED;  // error: can't access protected property outside of class definition
echo PHP_EOL;
echo Test::TEST_LOCAL;      // error: can't access private property outside of class definition
echo PHP_EOL;
echo Child::TEST_INHERITED; // error: can't acesss protected property outside of class definition
echo PHP_EOL;
echo Child::TEST_LOCAL;     // error: unknow constant
echo PHP_EOL;
echo Child::getTestLocal(); // error: unknow constant