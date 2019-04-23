<?php

namespace Calculator\Commands\CommandsList;

class SumCommand extends CheckValid
{
    public function execute($value1, $value2)
    {
        $this->checkParams($value1, $value2);
        return $value1 + $value2;
    }
}