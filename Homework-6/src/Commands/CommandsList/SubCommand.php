<?php

namespace Calculator\Commands\CommandsList;

use Calculator\Commands\Command;

class SubCommand extends Validation implements Command
{
    public function execute($value1, $value2 = null)
    {
        $rules = [$value1 => 'numeric', $value2 => 'numeric'];
        $messages = ['numeric' => 'Another error message!', 'required' => 'Variable is required!'];
        $this->checkValid($rules, $messages);

        return $value1 - $value2;
    }
}