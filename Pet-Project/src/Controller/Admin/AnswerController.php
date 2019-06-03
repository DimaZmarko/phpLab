<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnswerController extends AbstractController
{
    /**
     * @Route("/admin/answer/create", name="adminAddAnswer")
     */
    public function adminAddAnswer(ValidatorInterface $validator, Request $request)
    {
        if ($request->isMethod('post')) {

            $parentQuestion = $request->get('parent_id');
            $entityManager = $this->getDoctrine()->getManager();

            $question = $entityManager->getRepository(Question::class)->find($parentQuestion);

            $answer = new Answer();
            $answer->setContent($request->get('content'));
            $answer->setQuestion($question);
            $answer->setCorrect($request->get('correct'));

            $entityManager->persist($answer);
            $entityManager->flush();

            $errors = $validator->validate($answer);
            if (count($errors) > 0) {
                return $this->redirectToRoute('adminAddAnswer', ['errors' => (string) $errors]);
            }

            return $this->redirectToRoute('adminEditAnswer', [
                'id' => $answer->getId(),
                'success' => 'Answer Created']);
        }

        return $this->render('admin/addAnswer.html.twig');
    }

    /**
     * @Route("/admin/answer/{id}", name="adminEditAnswer", requirements={"id"="\d+"})
     */
    public function adminEditAnswer(ValidatorInterface $validator, Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $entityManager = $this->getDoctrine()->getManager();
            $answer = $entityManager->getRepository(Answer::class)->find($id);

            if (!$answer) {
                throw $this->createNotFoundException(
                    'No answer found for id '. $id
                );
            }
            $answer->setContent($request->get('content'));
            $answer->setCorrect($request->get('correct'));
            $entityManager->flush();

            $errors = $validator->validate($answer);
            if (count($errors) > 0) {
                return $this->redirectToRoute('adminEditAnswer', [
                    'id' => $id,
                    'errors' => (string) $errors]);
            }

            return $this->redirectToRoute('adminEditAnswer', [
                'id' => $id,
                'success' => 'Answer Edited']);
        }

        $answer = $this->getDoctrine()
            ->getRepository(Answer::class)
            ->find($id);

        return $this->render('admin/editAnswer.html.twig', [
            'answer' => $answer
        ]);
    }

    /**
     * @Route("/admin/answer/{id}/delete", name="adminDeleteAnswer", requirements={"id"="\d+"})
     */
    public function adminDeleteAnswer($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $answer = $entityManager->getRepository(Answer::class)
            ->find($id);

        if (!$answer) {
            throw $this->createNotFoundException(
                'No answer found for id '. $id
            );
        }

        $entityManager->remove($answer);
        $entityManager->flush();

        return $this->redirectToRoute('admin', ['success' => 'Answer Deleted']);
    }
}
