<?php

namespace Calculator\Commands\CommandsList;

use Calculator\Commands\Command;

class PowCommand extends Validation implements Command
{
    public function execute($base, $exp = null)
    {
        $rules = [$base => 'numeric', $exp => 'numeric'];
        $messages = ['numeric' => 'Value must be only numeric!', 'required' => 'Variable is required!'];
        $this->checkValid($rules, $messages);

        return pow($base, $exp);
    }
}