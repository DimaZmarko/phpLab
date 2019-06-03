<?php

namespace App\Controller\Client;

use App\Entity\Answer;
use App\Entity\Quiz;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $quizRepository = $this->getDoctrine()
            ->getRepository(Quiz::class);

        $search = $request->get('search');
        if ($search) {
            $quizes = $quizRepository->search($search);

        } else {
            $quizes = $quizRepository->findAll();
        }

        return $this->render('quiz/index.html.twig', [
            'quizes' => $quizes
        ]);
    }

    /**
     * @Route("/quiz/{id}", name="quizById", requirements={"id"="\d+"})
     */
    public function quizById($id)
    {
        $quiz = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->find($id);

        if (!$quiz) {
            throw $this->createNotFoundException(
                'No quiz found for id '. $id
            );
        }

        $questions = $quiz->getQuestions()->toArray();

        return $this->render('quiz/singleQuiz.html.twig', [
            'quiz' => $quiz,
            'questions' => $questions
        ]);
    }

    /**
     * @Route("/quiz_result/", name="quizResult")
     */
    public function quizResult(Request $request)
    {
        $questionId = $request->get('questionId');

        $result = 0;
        $answerRepository = $this->getDoctrine()
            ->getRepository(Answer::class);

        foreach ($questionId as $question) {

            $answer = $answerRepository->findOneBy(array('correct' => 1, 'question' => $question));

            if ($answer && ($answer->getId() == $request->get('question_' . $question))) {
                $result++;
            }
        }

        return $this->render('quiz/resultQuiz.html.twig', [
            'result' => $result
        ]);
    }
}
