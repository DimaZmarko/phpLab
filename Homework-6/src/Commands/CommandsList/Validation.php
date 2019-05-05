<?php

namespace Calculator\Commands\CommandsList;

use Calculator\Commands\Validator;

class Validation extends CommandException implements Validator
{
    public function checkEmpty($value, $message)
    {
        if ((empty($value))) {
            throw new CommandException($message);
        }
    }

    public function checkNum($value, $message)
    {
        if ((!is_numeric($value))) {
            throw new CommandException($message);
        }
    }

    public function checkValid(array $rules, array $messages)
    {
        foreach ($rules as $k => $v) {
            switch ($v) {
                case 'numeric':
                    $message = array_key_exists($v, $messages) ? $messages[$v] : 'Not valid';
                    $this->checkNum($k, $message);
                    break;
                case 'required':
                    $message = array_key_exists($v, $messages) ? $messages[$v] : 'Not valid';
                    $this->checkEmpty($k, $message);
                    break;

            }
        }
    }
}