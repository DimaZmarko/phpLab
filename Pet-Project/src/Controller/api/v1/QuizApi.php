<?php

namespace App\Controller\api\v1;

use App\Services\QuizService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class QuizApi
 * @package App\Controller\api\v1
 */
class QuizApi extends AbstractFOSRestController
{
    /**
     * @var QuizService
     */
    private $quizService;

    /**
     * QuizApi constructor.
     * @param QuizService $quizService
     */
    public function __construct(
        QuizService $quizService
    ) {
        $this->quizService = $quizService;
    }

    /**
     * @Rest\Get("/api/v1/quizzes", name="apiAllQuizzes")
     */
    public function allQuizzes()
    {
        $result = $this->quizService->getAllQuizzes();
        return $this->view($result, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/v1/quizzes/{id}", name="apiAllQuizzes", requirements={"id"="\d+"})
     */
    public function oneQuiz($id)
    {
        $result = $this->quizService->getQuiz($id);
        return $this->view($result, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/v1/quizzes/create", name="apiCreateQuiz")
     */
    public function createQuiz(Request $request)
    {
        $args = [
            'title' => $request->get('title'),
            'desc' => $request->get('description')
        ];

        $newQuiz = $this->quizService->create($args);

        if (count($newQuiz['errors']) > 0) {
            return $this->view($newQuiz['errors'], Response::HTTP_BAD_REQUEST);
        }

        return $this->view($newQuiz, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Patch("/api/v1/quizzes/edit/{id}", name="apiEditQuiz", requirements={"id"="\d+"})
     */
    public function editQuiz(Request $request, $id)
    {
        $args = [
            'title' => $request->get('title'),
            'desc' => $request->get('description')
        ];

        $editQuiz = $this->quizService->edit($args, $id);

        if (count($editQuiz['errors']) > 0) {
            return $this->view($editQuiz['errors'], Response::HTTP_BAD_REQUEST);
        }

        return $this->view('Quiz edited', Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/v1/quizzes/delete/{id}", name="apiDeleteQuiz", requirements={"id"="\d+"})
     */
    public function deleteQuiz($id)
    {
        $this->quizService->delete($id);
        return $this->view('Quiz deleted', Response::HTTP_OK);
    }

}