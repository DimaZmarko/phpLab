<?php

namespace Src\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Src\Models\Quiz;

class QuizController
{
    public function testAction(Request $request, $year)
    {
        $leapyear = new Quiz();

        if ($leapyear->isLeapYear($year)) {
            return new Response('YES');
        }

        return new Response('NOPE');
    }

    public function indexAction()
    {
        return new Response('Hello');
    }
}