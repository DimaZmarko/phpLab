<?php

namespace App\Controller\Admin;

use App\Services\AnswerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
    /**
     * @var AnswerService
     */
    private $answerService;

    /**
     * AnswerController constructor.
     * @param AnswerService $answerService
     */
    public function __construct(
        AnswerService $answerService
    ) {
        $this->answerService = $answerService;
    }

    /**
     * @Route("/admin/answer/create", name="adminAddAnswer")
     */
    public function adminAddAnswer(Request $request)
    {
        if ($request->isMethod('post')) {

            $args = [
                'content' => $request->get('content'),
                'parent_id' => $request->get('parent_id'),
                'correct' => $request->get('correct')
            ];

            $newAnswer = $this->answerService->create($args);

            if (count($newAnswer['errors']) > 0) {

                return $this->redirectToRoute('adminAddAnswer', [
                    'parent_id' => $request->get('parent_id'),
                    'errors' => (string)$newAnswer['errors']
                ]);
            }
            return $this->redirectToRoute('adminEditAnswer', [
                'id' => $newAnswer['id'],
                'success' => 'Answer Created'
            ]);
        }
        return $this->render('admin/addAnswer.html.twig');
    }

    /**
     * @Route("/admin/answer/{id}", name="adminEditAnswer", requirements={"id"="\d+"})
     */
    public function adminEditAnswer(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $args = [
                'content' => $request->get('content'),
                'correct' => $request->get('correct')
            ];

            $editAnswer = $this->answerService->edit($args, $id);


            if (count($editAnswer['errors']) > 0) {

                return $this->redirectToRoute('adminEditAnswer', [
                    'id' => $id,
                    'errors' => (string)$editAnswer['errors']
                ]);
            }
            return $this->redirectToRoute('adminEditAnswer', [
                'id' => $id,
                'success' => 'Answer Edited'
            ]);
        }
        return $this->render('admin/editAnswer.html.twig', [
            'answer' => $this->answerService->getAnswer($id)
        ]);
    }

    /**
     * @Route("/admin/answer/{id}/delete", name="adminDeleteAnswer", requirements={"id"="\d+"})
     */
    public function adminDeleteAnswer($id)
    {
        $this->answerService->delete($id);
        return $this->redirectToRoute('admin', ['success' => 'Answer Deleted']);
    }
}
