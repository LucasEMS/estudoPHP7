<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/Demo.php';

class SimpleClassTest extends TestCase{
    protected $demo;
    public function setup()
    {
        $this->demo = new Demo();
    }
    
    public function teardown()
    {
        unset($this->demo);
    }
    
    public function testAdd()
    {
        $this->assertEqual(2, $this->demo->add(1,1));
    }
    
    public function testSub()
    {
        $this->assertEqual(0, $this->demo->sub(1, 1));
    }

}