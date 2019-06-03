<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuestionController extends AbstractController
{
    /**
     * @Route("/admin/question/create", name="adminAddQuestion")
     */
    public function adminAddQuestion(ValidatorInterface $validator, Request $request)
    {
        if ($request->isMethod('post')) {

            $parentQuiz = $request->get('parent_id');

            $entityManager = $this->getDoctrine()->getManager();

            $quiz = $entityManager->getRepository(Quiz::class)->find($parentQuiz);

            $question = new Question();
            $question->setContent($request->get('content'));
            $question->setQuiz($quiz);

            $entityManager->persist($question);
            $entityManager->flush();

            $errors = $validator->validate($question);
            if (count($errors) > 0) {
                return $this->redirectToRoute('adminAddQuestion', ['errors' => (string)$errors]);
            }

            return $this->redirectToRoute('adminEditQuestion', [
                'id' => $question->getId(),
                'success' => 'Question Created']);
        }

        return $this->render('admin/addQuestion.html.twig');
    }

    /**
     * @Route("/admin/question/{id}", name="adminEditQuestion", requirements={"id"="\d+"})
     */
    public function adminEditQuestion(ValidatorInterface $validator, Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $question = $entityManager->getRepository(Question::class)->find($id);

        if (!$question) {
            throw $this->createNotFoundException(
                'No question found for id ' . $id
            );
        }

        if ($request->isMethod('post')) {

            $question->setContent($request->get('content'));

            $entityManager->flush();

            $errors = $validator->validate($question);
            if (count($errors) > 0) {
                return $this->redirectToRoute('adminEditQuestion', [
                    'id' => $id,
                    'errors' => (string)$errors]);
            }

            return $this->redirectToRoute('adminEditQuestion', [
                'id' => $id,
                'success' => 'Question Edited']);
        }

        $answers = $question->getAnswers()->toArray();

        return $this->render('admin/editQuestion.html.twig', [
            'question' => $question,
            'answers' => $answers
        ]);
    }

    /**
     * @Route("/admin/question/{id}/delete", name="adminDeleteQuestion", requirements={"id"="\d+"})
     */
    public function adminDeleteQuestion($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $question = $entityManager->getRepository(Question::class)
            ->find($id);

        if (!$question) {
            throw $this->createNotFoundException(
                'No question found for id ' . $id
            );
        }

        $entityManager->remove($question);
        $entityManager->flush();

        return $this->redirectToRoute('admin', ['success' => 'Question Deleted']);
    }
}
