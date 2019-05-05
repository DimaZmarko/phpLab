<?php

require_once 'vendor/autoload.php';

use Calculator\Calculator;
use Calculator\Commands\CommandsList\SumCommand;
use Calculator\Commands\CommandsList\PowCommand;
use Calculator\Commands\CommandsList\SubCommand;
use Calculator\Commands\CommandsList\SqrtCommand;

$calc = new Calculator();

$calc->addCommand('+', new SumCommand());
$calc->addCommand('-', new SubCommand());
$calc->addCommand('^', new PowCommand());
$calc->addCommand('sqrt', new SqrtCommand());

echo $calc->init(2)
    ->computing('+', '1')
    ->computing('-', -1)
    ->computing('^', '2')
    ->computing('sqrt')
    ->computing('+', 12)
    ->computing('sqrt')
    ->getResult();


