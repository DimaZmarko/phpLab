<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Calculator\Commands\CommandsList\SqrtCommand;

class SqrtCommandTest extends TestCase
{
    protected $sqrtInstance;

    protected function setUp() : void
    {
        $this->sqrtInstance = new SqrtCommand();
    }

    public function testExecute()
    {
        $this->assertEquals($this->sqrtInstance->Execute(4), 2);
    }
}
