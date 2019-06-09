<?php

namespace App\Controller\Admin;

use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @var QuizRepository
     */
    private $quizRepository;

    /**
     * AdminController constructor.
     * @param QuizRepository $quizRepository
     */
    public function __construct(
        QuizRepository $quizRepository
    )
    {
        $this->quizRepository = $quizRepository;
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $quizes = $this->quizRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'quizes' => $quizes
        ]);
    }
}
