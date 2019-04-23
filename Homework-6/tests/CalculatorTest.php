<?php

namespace tests;

use Calculator\Calculator;
use PHPUnit\Framework\TestCase;
use Calculator\Commands\CommandsList\SumCommand;
use ReflectionClass;

class CalculatorTest extends TestCase
{
    protected $calculator;
    protected $sumCommandObj;

    protected function setUp() : void
    {
        $this->calculator = new Calculator();
        $this->sumCommandObj = new SumCommand();
        $reflection = new ReflectionClass($this->calculator);
        $property = $reflection->getProperty('operationsKeys');
        $property->setAccessible(true);
        $property->setValue($this->calculator, ['-' => $this->sumCommandObj]);
    }

    public function testInit()
    {
        $this->calculator->init(8);
        $this->assertAttributeEquals(8, 'result', $this->calculator);
    }

    public function testAddCommand()
    {
        $this->calculator->addCommand('+', $this->sumCommandObj);
        $this->assertAttributeEquals(['-' => $this->sumCommandObj, '+' => $this->sumCommandObj], 'operationsKeys', $this->calculator);
    }

    public function testGetResult()
    {
        $reflection = new ReflectionClass($this->calculator);
        $property = $reflection->getProperty('result');
        $property->setAccessible(true);
        $property->setValue($this->calculator, 7);

        $result = $this->calculator->getResult();
        $this->assertAttributeEquals($result, 'result', $this->calculator);
    }

    public function testComputing()
    {
        $reflection = new ReflectionClass($this->calculator);
        $property = $reflection->getProperty('result');
        $property->setAccessible(true);
        $property->setValue($this->calculator, 10);

        $this->calculator->computing('-', 2);
        $this->assertAttributeEquals(12, 'result', $this->calculator);
    }
}
