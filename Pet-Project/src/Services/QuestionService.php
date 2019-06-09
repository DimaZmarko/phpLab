<?php

namespace App\Services;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuestionService
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;
    /**
     * @var QuizRepository
     */
    private $quizRepository;
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
     * QuestionService constructor.
     * @param QuestionRepository $questionRepository
     * @param QuizRepository $quizRepository
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param LoggerInterface $logger
     */
    public function __construct(
        QuestionRepository $questionRepository,
        QuizRepository $quizRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        LoggerInterface $logger
    ) {
        $this->questionRepository = $questionRepository;
        $this->quizRepository = $quizRepository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @param int $id
     * @return Question|null
     */
    public function getQuestion(int $id)
    {
        $question = $this->questionRepository->find($id);

        if (!$question) {
            throw new NotFoundHttpException(
                'No question found for id ' . $id
            );
        }
        return $question;
    }

    /**
     * @param array $args
     * @return array
     */
    public function create(array $args)
    {
        $parentQuiz = $this->quizRepository->find($args['parent_id']);

        $question = new Question();
        $question->setContent($args['content'])
            ->setQuiz($parentQuiz);

        $errors = $this->validator->validate($question);

        if (count($errors) > 0) {
            $this->logger->info('There are validations errors when user add new Question',
                ['errors' => $errors]);
        } else {
            $this->entityManager->persist($question);
            $this->entityManager->flush();
        }

        return ['errors' => $errors, 'id' => $question->getId()];
    }

    /**
     * @param array $args
     * @param int $id
     * @return array
     */
    public function edit(array $args, int $id)
    {
        $question = $this->questionRepository->find($id);

        if (!$question) {
            throw new NotFoundHttpException(
                'No question found for id ' . $id
            );
        }

        $question->setContent($args['content']);

        $errors = $this->validator->validate($question);

        if (count($errors) > 0) {
            $this->logger->info('There are validations errors when user edit Question',
                ['errors' => $errors]);
        } else {
            $this->entityManager->flush();
        }

        return ['errors' => $errors, 'id' => $question->getId()];
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $question = $this->questionRepository->find($id);

        if (!$question) {
            throw new NotFoundHttpException(
                'No question found for id ' . $id
            );
        }
        $this->entityManager->remove($question);
        $this->entityManager->flush();
    }
}