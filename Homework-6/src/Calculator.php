<?php

namespace Calculator;

use Exception;
use Calculator\Commands\Command;

class Calculator
{
    private $result;
    private $operationsKeys;

    public function init($value)
    {
        $this->result = $value;
        return $this;
    }

    public function addCommand($operationKey, Command $operationInstance)
    {
        $this->operationsKeys[$operationKey] = $operationInstance;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function computing($operation, $value = null)
    {
        $operationObj = $this->operationsKeys[$operation];

        try {
            $this->result = $operationObj->execute($this->getResult(), $value);
            return $this;

        } catch (Exception $e) {
            echo 'Exception  ', $e->errorMessage(), "\n";
            return $this;
        }
    }
}