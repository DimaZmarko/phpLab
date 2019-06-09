<?php

namespace App\Services;

use App\Entity\Answer;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnswerService
{
    /**
     * @var AnswerRepository
     */
    private $answerRepository;
    /**
     * @var QuestionRepository
     */
    private $questionRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * AnswerService constructor.
     * @param AnswerRepository $answerRepository
     * @param QuestionRepository $questionRepository
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param LoggerInterface $logger
     */
    public function __construct(
        AnswerRepository $answerRepository,
        QuestionRepository $questionRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        LoggerInterface $logger
    ) {
        $this->answerRepository = $answerRepository;
        $this->questionRepository = $questionRepository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @param int $id
     * @return Answer|null
     */
    public function getAnswer(int $id)
    {
        $answer = $this->answerRepository->find($id);

        if (!$answer) {
            throw new NotFoundHttpException(
                'No answer found for id ' . $id
            );
        }
        return $answer;
    }

    /**
     * @param array $args
     * @return array
     */
    public function create(array $args)
    {
        $parentQuestion = $this->questionRepository->find($args['parent_id']);

        $answer = new Answer();
        $answer->setContent($args['content'])
            ->setCorrect($args['correct'])
            ->setQuestion($parentQuestion);

        $errors = $this->validator->validate($answer);

        if (count($errors) > 0) {
            $this->logger->info('There are validations errors when user add new Answer',
                ['errors' => $errors]);
        } else {
            $this->entityManager->persist($answer);
            $this->entityManager->flush();
        }


        return ['errors' => $errors, 'id' => $answer->getId()];
    }

    /**
     * @param array $args
     * @param int $id
     * @return array
     */
    public function edit(array $args, int $id)
    {
        $answer = $this->answerRepository->find($id);

        if (!$answer) {
            throw new NotFoundHttpException(
                'No answer found for id ' . $id
            );
        }

        $answer->setContent($args['content'])
            ->setCorrect($args['correct']);

        $errors = $this->validator->validate($answer);

        if (count($errors) > 0) {
            $this->logger->info('There are validations errors when user edit Answer',
                ['errors' => $errors]);
        } else {
            $this->entityManager->flush();
        }

        return ['errors' => $errors, 'id' => $answer->getId()];
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $answer = $this->answerRepository->find($id);

        if (!$answer) {
            throw new NotFoundHttpException(
                'No answer found for id ' . $id
            );
        }
        $this->entityManager->remove($answer);
        $this->entityManager->flush();
    }
}