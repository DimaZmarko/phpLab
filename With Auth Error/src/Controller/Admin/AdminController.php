<?php

namespace App\Controller\Admin;

use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $quizes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findAll();

        return $this->render('admin/index.html.twig', [
            'quizes' => $quizes
        ]);
    }
}
