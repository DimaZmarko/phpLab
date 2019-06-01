<?php
$app = [
    'name' => 'Quiz',

    'routes' => [
        'quizes' => [
            'path' => '/',
            'file' => 'quiz.php',
            'function' => 'src\\quiz\\allQuizes',
        ],
        'search' => [
            'path' => '/quiz/find-words',
            'file' => 'quiz.php',
            'function' => 'src\\quiz\\search',
        ],
        'quiz_by_id' => [
            'path' => '/quiz/{id}',
            'file' => 'quiz.php',
            'function' => 'src\\quiz\\quizById',
        ],
        'result' => [
            'path' => '/result',
            'file' => 'quiz.php',
            'function' => 'src\\quiz\\quizResult',
        ],
        'admin' => [
            'path' => '/admin',
            'file' => 'quiz.php',
            'function' => 'src\\quiz\\admin'
        ],
    ],
];

$app['db'] = new PDO("mysql:host=localhost;dbname=quiz", 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));