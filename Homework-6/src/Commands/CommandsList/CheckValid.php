<?php

namespace Calculator\Commands\CommandsList;

use Calculator\Commands\Command;
use Calculator\Commands\CommandsList\CommandException;

abstract class  CheckValid implements Command
{
    protected function checkParams($value1, $value2)
    {
        if ((!is_numeric($value1)) || (!is_numeric($value2))) {
            throw new CommandException;
        }
    }

    public function execute($value1, $value2)
    {
    }

}