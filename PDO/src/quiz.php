<?php

namespace src\quiz;

use PDO;
use function core\view\view;
use Symfony\Component\HttpFoundation\Response;

/**
 * @return Response
 */
function allQuizes()
{
    global $app;
    /** @var Symfony\Component\HttpFoundation\Request*/
    global $request;

    $pageNumber = $request->get('page');
    $page = (!isset($pageNumber)) ? 1 : $pageNumber;
    $pageResult = ($page - 1) * 4;
    $quizPerPage = 10;

    $STH = $app['db']->prepare("SELECT * from quiz_items limit :page, :per_page");
    $STH->bindParam(':page', $pageResult, PDO::PARAM_INT);
    $STH->bindParam(':per_page', $quizPerPage, PDO::PARAM_INT);
    $STH->execute();
    $result_quiz = $STH->fetchAll(PDO::FETCH_ASSOC);

    return view(['layout.php', 'quizes/index.php'], ['quizes' => $result_quiz]);
}


/**
 * @return Response
 */
function search()
{
    global $app;
    global $request;

    $search = $request->get('search');

    $STH = $app['db']->prepare('SELECT * FROM quiz_items WHERE quize_title LIKE :keywords');
    $STH->bindValue(':keywords', '%' . $search .'%');
    $STH->execute();
    $result = $STH->fetchAll(PDO::FETCH_ASSOC);

    return view(['layout.php', 'quizes/search.php'], ['result' => $result]);
}



/**
 * @param $id
 * @return Response
 */
function quizById($id)
{
    global $app;

    $STH = $app['db']->prepare("SELECT * FROM questions WHERE quiz_id = :id");
    $STH->bindParam(':id', $id, PDO::PARAM_INT);
    $STH->execute();
    $questions = $STH->fetchAll(PDO::FETCH_ASSOC);

    $STH = $app['db']->prepare("SELECT * FROM answers WHERE question_id = :id");
    $questionAnswers = [];

    foreach ($questions as $question){

        $STH->bindParam(':id', $question['id'], PDO::PARAM_INT);
        $STH->execute();

        $questionAnswers[] = [
            'question_id' => $question['id'],
            'question_name' => $question['content'],
            'answers' => $STH->fetchAll(PDO::FETCH_ASSOC)

        ];
    }

    return view(['layout.php', 'quizes/quizById.php'], ['questions' => $questionAnswers]);
}

/**
 * @return Response
 */
function quizResult()
{
    global $app;
    global $request;


    $questionId = $request->get('questionId');
    $result = 0;
    foreach ($questionId as $question){
        $STH = $app['db']->prepare("SELECT * FROM answers WHERE correct = 1 AND question_id = :id ");
        $STH->bindParam(':id', $question, PDO::PARAM_INT);
        $STH->execute();
        $answer = $STH->fetch(PDO::FETCH_OBJ);

        if($answer->id == $request->get('question_'.$question)){
            $result++;

        }
    }


    return view(['layout.php', 'quizes/result.php'], ['result' => $result]);
}