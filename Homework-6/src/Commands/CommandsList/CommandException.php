<?php

namespace Calculator\Commands\CommandsList;

use Exception;

class CommandException extends Exception
{
    public function errorMessage()
    {
        $errorMsg = 'Error on line ' . $this->getLine() . ' in ' . $this->getFile() . ' ' . $this->getMessage();
        return $errorMsg;
    }
}