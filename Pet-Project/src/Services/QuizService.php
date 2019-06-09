<?php

namespace App\Services;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuizService
{
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
     * QuizService constructor.
     * @param QuizRepository $quizRepository
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param LoggerInterface $logger
     */
    public function __construct(
        QuizRepository $quizRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        LoggerInterface $logger
    ) {
        $this->quizRepository = $quizRepository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @param int $id
     * @return Quiz|null
     */
    public function getQuiz(int $id)
    {
        $quiz = $this->quizRepository->find($id);

        if (!$quiz) {
            throw new NotFoundHttpException(
                'No quiz found for id ' . $id
            );
        }
        return $quiz;
    }

    /**
     * @param array $args
     * @return array
     */
    public function create(array $args)
    {
        $quiz = new Quiz();
        $quiz->setTitle($args['title'])
            ->setDescription($args['desc']);

        $errors = $this->validator->validate($quiz);

        if (count($errors) > 0) {
            $this->logger->info('There are validations errors when user add new Quiz',
                ['errors' => $errors]);
        } else {
            $this->entityManager->persist($quiz);
            $this->entityManager->flush();
        }

        return ['errors' => $errors, 'id' => $quiz->getId()];
    }

    /**
     * @param array $args
     * @param int $id
     * @return array
     */
    public function edit(array $args, int $id)
    {
        $quiz = $this->quizRepository->find($id);

        if (!$quiz) {
            throw new NotFoundHttpException(
                'No quiz found for id ' . $id
            );
        }

        $quiz->setTitle($args['title'])
            ->setDescription($args['desc']);

        $errors = $this->validator->validate($quiz);

        if (count($errors) > 0) {
            $this->logger->info('There are validations errors when user edit Quiz',
                ['errors' => $errors]);
        } else {
            $this->entityManager->flush();
        }

        return ['errors' => $errors, 'id' => $quiz->getId()];
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $quiz = $this->quizRepository->find($id);

        if (!$quiz) {
            throw new NotFoundHttpException(
                'No quiz found for id ' . $id
            );
        }
        $this->entityManager->remove($quiz);
        $this->entityManager->flush();
    }
}