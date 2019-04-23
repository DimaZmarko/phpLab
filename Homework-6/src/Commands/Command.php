<?php

namespace Calculator\Commands;

interface Command
{
    public function execute($value1, $value2);
}