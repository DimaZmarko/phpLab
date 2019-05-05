<?php

namespace Calculator\Commands;

interface Validator
{
    public function checkValid(array $rules, array $messages);
}