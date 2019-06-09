<?php

namespace App\Controller\Admin;

use App\Services\QuestionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @var QuestionService
     */
    private $questionService;

    /**
     * QuestionController constructor.
     * @param QuestionService $questionService
     */
    public function __construct(
        QuestionService $questionService
    ) {
        $this->questionService = $questionService;
    }

    /**
     * @Route("/admin/question/create", name="adminAddQuestion")
     */
    public function adminAddQuestion(Request $request)
    {
        if ($request->isMethod('post')) {

            $args = [
                'content' => $request->get('content'),
                'parent_id' => $request->get('parent_id')
            ];
            $newQuestion = $this->questionService->create($args);

            if (count($newQuestion['errors']) > 0) {
                return $this->redirectToRoute('adminAddQuestion', [
                    'parent_id' => $request->get('parent_id'),
                    'errors' => (string)$newQuestion['errors']
                ]);
            }

            return $this->redirectToRoute('adminEditQuestion', [
                'id' => $newQuestion['id'],
                'success' => 'Question Created'
            ]);
        }

        return $this->render('admin/addQuestion.html.twig');
    }

    /**
     * @Route("/admin/question/{id}", name="adminEditQuestion", requirements={"id"="\d+"})
     */
    public function adminEditQuestion(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $args = [
                'content' => $request->get('content')
            ];
            $updateQuestion = $this->questionService->edit($args, $id);

            if (count($updateQuestion['errors']) > 0) {
                return $this->redirectToRoute('adminEditQuestion', [
                    'id' => $id,
                    'errors' => (string)$updateQuestion['errors']
                ]);
            }

            return $this->redirectToRoute('adminEditQuestion', [
                'id' => $id,
                'success' => 'Question Edited'
            ]);
        }

        $question = $this->questionService->getQuestion($id);

        return $this->render('admin/editQuestion.html.twig', [
            'question' => $question,
            'answers' => $question->getAnswers()->toArray()
        ]);
    }

    /**
     * @Route("/admin/question/{id}/delete", name="adminDeleteQuestion", requirements={"id"="\d+"})
     */
    public function adminDeleteQuestion($id)
    {
        $this->questionService->delete($id);
        return $this->redirectToRoute('admin', ['success' => 'Question Deleted']);
    }
}
