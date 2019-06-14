<?php

namespace App\Controller\Client;

use App\Repository\AnswerRepository;
use App\Repository\QuizRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @var QuizRepository
     */
    private $quizRepository;
    /**
     * @var AnswerRepository
     */
    private $answerRepository;

    /**
     * ClientController constructor.
     * @param QuizRepository $quizRepository
     * @param AnswerRepository $answerRepository
     */
    public function __construct(
        QuizRepository $quizRepository,
        AnswerRepository $answerRepository
    ) {
        $this->quizRepository = $quizRepository;
        $this->answerRepository = $answerRepository;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $quizzes = $this->quizRepository->search($search);

        } else {
            $quizzes = $this->quizRepository->findAll();
        }

        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizzes
        ]);
    }

    /**
     * @Route("/quiz/{id}", name="quizById", requirements={"id"="\d+"})
     */
    public function quizById($id)
    {
        $quiz = $this->quizRepository->find($id);

        if (!$quiz) {
            throw new NotFoundHttpException(
                'No quiz found for id ' . $id
            );
        }

        return $this->render('quiz/singleQuiz.html.twig', [
            'quiz' => $quiz,
            'questions' => $quiz->getQuestions()->toArray()
        ]);
    }

    /**
     * @Route("/quiz_result/", name="quizResult")
     */
    public function quizResult(Request $request)
    {
        $questionId = $request->get('questionId');
        $result = 0;

        foreach ($questionId as $question) {

            $answer = $this->answerRepository->findOneBy(array('correct' => 1, 'question' => $question));

            if ($answer && ($answer->getId() == $request->get('question_' . $question))) {
                $result++;
            }
        }

        return $this->render('quiz/resultQuiz.html.twig', [
            'result' => $result
        ]);
    }
}
