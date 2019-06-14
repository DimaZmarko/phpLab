<?php

namespace App\Controller\api\v1;

use App\Services\QuestionService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class QuestionApi
 * @package App\Controller\api\v1
 */
class QuestionApi extends AbstractFOSRestController
{
    /**
     * @var QuestionService
     */
    private $questionService;

    /**
     * QuestionApi constructor.
     * @param QuestionService $questionService
     */
    public function __construct(
        QuestionService $questionService
    )
    {
        $this->questionService = $questionService;
    }

    /**
     * @Rest\Get("/api/v1/questions", name="apiAllQuestions")
     */
    public function allQuestion()
    {
        $result = $this->questionService->getAllQuestion();
        return $this->view($result, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/v1/questions/{id}", name="apiOneQuestion", requirements={"id"="\d+"})
     */
    public function oneQuestion($id)
    {
        $result = $this->questionService->getQuestion($id);
        return $this->view($result, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/v1/question/create", name="apiCreateQuestion")
     */
    public function createQuestion(Request $request)
    {
        $args = [
            'content' => $request->get('content'),
            'parent_id' => $request->get('parent_id')
        ];

        $newQuestion = $this->questionService->create($args);

        if (count($newQuestion['errors']) > 0) {
            return $this->view($newQuestion['errors'], Response::HTTP_BAD_REQUEST);
        }
        return $this->view($newQuestion, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Patch("/api/v1/questions/edit/{id}", name="apiEditQuestion", requirements={"id"="\d+"})
     */
    public function editQuestion(Request $request, $id)
    {
        $args = [
            'content' => $request->get('content'),
        ];

        $editQuestion = $this->questionService->edit($args, $id);

        if (count($editQuestion['errors']) > 0) {
            return $this->view($editQuestion['errors'], Response::HTTP_BAD_REQUEST);
        }
        return $this->view('Question edited', Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/v1/questions/delete/{id}", name="apiDeleteQuestion", requirements={"id"="\d+"})
     */
    public function deleteQuestion($id)
    {
        $this->questionService->delete($id);
        return $this->view('Question deleted', Response::HTTP_OK);
    }

}