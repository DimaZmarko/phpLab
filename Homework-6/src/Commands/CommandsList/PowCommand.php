<?php

namespace Calculator\Commands\CommandsList;

class PowCommand extends CheckValid
{
    public function execute($base, $exp)
    {
        $this->checkParams($base, $exp);
        return pow($base, $exp);
    }
}