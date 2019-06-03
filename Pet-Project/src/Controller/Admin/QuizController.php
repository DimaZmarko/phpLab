<?php

namespace App\Controller\Admin;

use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuizController extends AbstractController
{
    /**
     * @Route("/admin/quiz/create", name="adminAddQuiz")
     */
    public function adminAddQuiz(ValidatorInterface $validator, Request $request)
    {
        if ($request->isMethod('post')) {

            $entityManager = $this->getDoctrine()->getManager();

            $quiz = new Quiz();
            $quiz->setTitle($request->get('title'));
            $quiz->setDescription($request->get('description'));

            $entityManager->persist($quiz);
            $entityManager->flush();

            $errors = $validator->validate($quiz);
            if (count($errors) > 0) {
                return $this->redirectToRoute('adminAddQuiz', ['errors' => (string)$errors]);
            }

            return $this->redirectToRoute('adminEditQuiz', [
                'id' => $quiz->getId(),
                'success' => 'Quiz Created']);
        }

        return $this->render('admin/addQuiz.html.twig');
    }

    /**
     * @Route("/admin/quiz/{id}", name="adminEditQuiz", requirements={"id"="\d+"})
     */
    public function adminEditQuiz(ValidatorInterface $validator, Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $entityManager = $this->getDoctrine()->getManager();
            $quiz = $entityManager->getRepository(Quiz::class)->find($id);

            if (!$quiz) {
                throw $this->createNotFoundException(
                    'No quiz found for id ' . $id
                );
            }
            $quiz->setTitle($request->get('title'));
            $quiz->setDescription($request->get('description'));

            $entityManager->flush();

            $errors = $validator->validate($quiz);
            if (count($errors) > 0) {
                return $this->redirectToRoute('adminEditQuiz', [
                    'id' => $id,
                    'errors' => (string)$errors]);
            }

            return $this->redirectToRoute('adminEditQuiz', [
                'id' => $id,
                'success' => 'Quiz Edited']);
        }

        $quiz = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->find($id);

        $questions = $quiz->getQuestions()->toArray();

        return $this->render('admin/editQuiz.html.twig', [
            'quiz' => $quiz,
            'questions' => $questions
        ]);
    }

    /**
     * @Route("/admin/quiz/{id}/delete", name="adminDeleteQuiz", requirements={"id"="\d+"})
     */
    public function adminDeleteQuiz($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $quiz = $entityManager->getRepository(Quiz::class)
            ->find($id);

        if (!$quiz) {
            throw $this->createNotFoundException(
                'No quiz found for id ' . $id
            );
        }

        $entityManager->remove($quiz);
        $entityManager->flush();

        return $this->redirectToRoute('admin', ['success' => 'Quiz Deleted']);
    }
}
