<?php

namespace App\Controller\Admin;

use App\Services\QuizService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    /**
     * @var QuizService
     */
    private $quizService;

    /**
     * QuizController constructor.
     * @param QuizService $quizService
     */
    public function __construct(
        QuizService $quizService
    ) {
        $this->quizService = $quizService;
    }

    /**
     * @Route("/admin/quiz/create", name="adminAddQuiz")
     */
    public function adminAddQuiz( Request $request)
    {
        if ($request->isMethod('post')) {

            $args = [
                'title' => $request->get('title'),
                'desc' => $request->get('description')
            ];

            $newQuiz = $this->quizService->create($args);

            if (count($newQuiz['errors']) > 0) {
                return $this->redirectToRoute('adminAddQuiz', [
                    'errors' => (string)$newQuiz['errors']
                ]);
            }

            return $this->redirectToRoute('adminEditQuiz', [
                'id' => $newQuiz['id'],
                'success' => 'Quiz Created'
            ]);
        }

        return $this->render('admin/addQuiz.html.twig');
    }

    /**
     * @Route("/admin/quiz/{id}", name="adminEditQuiz", requirements={"id"="\d+"})
     */
    public function adminEditQuiz(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $args = [
                'title' => $request->get('title'),
                'desc' => $request->get('description')
            ];

            $editQuiz = $this->quizService->edit($args, $id);

            if (count($editQuiz['errors']) > 0) {
                return $this->redirectToRoute('adminEditQuiz', [
                    'id' => $id,
                    'errors' => (string)$editQuiz['errors']
                ]);
            }

            return $this->redirectToRoute('adminEditQuiz', [
                'id' => $id,
                'success' => 'Quiz Edited'
            ]);
        }

        $quiz = $this->quizService->getQuiz($id);

        return $this->render('admin/editQuiz.html.twig', [
            'quiz' => $quiz,
            'questions' => $quiz->getQuestions()->toArray()
        ]);
    }

    /**
     * @Route("/admin/quiz/{id}/delete", name="adminDeleteQuiz", requirements={"id"="\d+"})
     */
    public function adminDeleteQuiz($id)
    {
        $this->quizService->delete($id);
        return $this->redirectToRoute('admin', ['success' => 'Quiz Deleted']);
    }
}
