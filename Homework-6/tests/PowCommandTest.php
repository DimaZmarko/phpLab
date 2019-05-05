<?php

namespace tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Calculator\Commands\CommandsList\PowCommand;

class PowCommandTest extends TestCase
{
    protected $powInstance;

    protected function setUp() : void
    {
        $this->powInstance = new PowCommand();
    }

    public function testExecute()
    {
        $this->assertEquals($this->powInstance->Execute(2, 2), 4);
        $this->expectException(Exception::class);
        $this->powInstance->Execute(2, 'aa');
    }
}
