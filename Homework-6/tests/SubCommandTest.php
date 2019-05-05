<?php

namespace tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Calculator\Commands\CommandsList\SubCommand;

class SubCommandTest extends TestCase
{
    protected $subtractionInstance;

    protected function setUp() : void
    {
        $this->subtractionInstance = new SubCommand();
    }

    public function testExecute()
    {
        $this->assertEquals($this->subtractionInstance->Execute(2, 2), 0);

        $this->expectException(Exception::class);
        $this->subtractionInstance->Execute(2, 'uu');
    }
}
