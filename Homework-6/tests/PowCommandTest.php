<?php

namespace tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Calculator\Commands\CommandsList\PowCommand;

class PowCommandTest extends TestCase
{
    protected $exponentiationInstance;

    protected function setUp() : void
    {
        $this->exponentiationInstance = new PowCommand();
    }

    public function testExecute()
    {
        $this->assertEquals($this->exponentiationInstance->Execute(2, 2), 4);
        $this->expectException(Exception::class);
        $this->exponentiationInstance->Execute(2, 'frost');
    }

}
