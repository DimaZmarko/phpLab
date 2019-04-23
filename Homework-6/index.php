<?php

require_once 'vendor/autoload.php';

use Calculator\Calculator;
use Calculator\Commands\Command;
use Calculator\Commands\CommandsList\SumCommand;
use Calculator\Commands\CommandsList\PowCommand;
use Calculator\Commands\CommandsList\SubCommand;

$calc = new Calculator();

$calc->addCommand('+', new SumCommand());
$calc->addCommand('-', new SubCommand());
$calc->addCommand('^', new PowCommand());

echo $calc->init(2)
    ->computing('+', '1')
    ->computing('-', -1)
    ->computing('^', 4)
    ->getResult();


