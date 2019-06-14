<?php

namespace App\Controller\api\v1;

use App\Services\AnswerService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AnswerApi
 * @package App\Controller\api\v1
 */
class AnswerApi extends AbstractFOSRestController
{
    /**
     * @var AnswerService
     */
    private $answerService;

    /**
     * AnswerApi constructor.
     * @param AnswerService $answerService
     */
    public function __construct(
        AnswerService $answerService
    )
    {
        $this->answerService = $answerService;
    }

    /**
     * @Rest\Get("/api/v1/answers", name="apiAllAnswers")
     */
    public function allAnswers()
    {
        $result = $this->answerService->getAllAnswers();
        return $this->view($result, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/v1/answers/{id}", name="apiOneAnswer", requirements={"id"="\d+"})
     */
    public function oneAnswer($id)
    {
        $result = $this->answerService->getAnswer($id);
        return $this->view($result, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/v1/answers/create", name="apiCreateAnswer")
     */
    public function createAnswer(Request $request)
    {
        $args = [
            'content' => $request->get('content'),
            'parent_id' => $request->get('parent_id'),
            'correct' => $request->get('correct')
        ];

        $newAnswer = $this->answerService->create($args);

        if (count($newAnswer['errors']) > 0) {
            return $this->view($newAnswer['errors'], Response::HTTP_BAD_REQUEST);
        }

        return $this->view($newAnswer, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Patch("/api/v1/answers/edit/{id}", name="apiEditAnswer", requirements={"id"="\d+"})
     */
    public function editAnswer(Request $request, $id)
    {
        $args = [
            'content' => $request->get('content'),
            'correct' => $request->get('correct')
        ];

        $editAnswer = $this->answerService->edit($args, $id);

        if (count($editAnswer['errors']) > 0) {
            return $this->view($editAnswer['errors'], Response::HTTP_BAD_REQUEST);
        }

        return $this->view('Answer edited', Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/v1/answers/delete/{id}", name="apiDeleteAnswer", requirements={"id"="\d+"})
     */
    public function deleteAnswer($id)
    {
        $this->answerService->delete($id);
        return $this->view('Answer deleted', Response::HTTP_OK);
    }

}