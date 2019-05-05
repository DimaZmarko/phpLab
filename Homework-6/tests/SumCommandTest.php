<?php

namespace tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Calculator\Commands\CommandsList\SumCommand;

class SumCommandTest extends TestCase
{
    protected $addInstance;

    protected function setUp() : void
    {
        $this->addInstance = new SumCommand();
    }

    public function testExecute()
    {
        $this->assertEquals($this->addInstance->Execute(2, 2), 4);

        $this->expectException(Exception::class);
        $this->addInstance->Execute(2, 'kk');
    }
}
