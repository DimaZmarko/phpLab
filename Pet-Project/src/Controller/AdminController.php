<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @Route("/admin/quiz/", name="adminAddQuiz")
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
                return $this->redirectToRoute('adminAddQuiz', array('errors' => (string) $errors));
            }

            return $this->redirectToRoute('admin', array('success' => 'Quiz Created'));
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
                    'No quiz found for id '. $id
                );
            }
            $quiz->setTitle($request->get('title'));
            $quiz->setDescription($request->get('description'));

            $entityManager->flush();

            $errors = $validator->validate($quiz);
            if (count($errors) > 0) {
                return $this->redirectToRoute('adminAddQuiz', array('errors' => (string) $errors));
            }

            return $this->redirectToRoute('admin', array('success' => 'Quiz Created'));
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
                'No quiz found for id '. $id
            );
        }

        $entityManager->remove($quiz);
        $entityManager->flush();

        return $this->redirectToRoute('admin', array('success' => 'Quiz Deleted'));
    }

    /**
     * @Route("/admin/question/create", name="adminAddQuestion")
     */
    public function adminAddQuestion(ValidatorInterface $validator, Request $request)
    {
        if ($request->isMethod('post')) {

            $entityManager = $this->getDoctrine()->getManager();

            $quiz = $entityManager->getRepository(Quiz::class)->find($request->get('parent_id'));

            $question = new Question();
            $question->setContent($request->get('content'));
            $question->setQuiz($quiz);


            $entityManager->persist($question);
            $entityManager->flush();

            $errors = $validator->validate($question);
            if (count($errors) > 0) {
                return $this->redirectToRoute('adminAddQuestion', array('errors' => (string) $errors));
            }

            return $this->redirectToRoute('admin', array('success' => 'Quiz Created'));
        }

        return $this->render('admin/addQuestion.html.twig');
    }

    /**
     * @Route("/admin/question/{id}", name="adminEditQuestion", requirements={"id"="\d+"})
     */
    public function adminEditQuestion(ValidatorInterface $validator, Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $entityManager = $this->getDoctrine()->getManager();
            $question = $entityManager->getRepository(Question::class)->find($id);

            if (!$question) {
                throw $this->createNotFoundException(
                    'No question found for id '. $id
                );
            }
            $question->setContent($request->get('content'));

            $entityManager->flush();

            $errors = $validator->validate($question);
            if (count($errors) > 0) {
                return $this->redirectToRoute('adminEditQuestion', array('errors' => (string) $errors));
            }

            return $this->redirectToRoute('admin', array('success' => 'Question Edited'));
        }

        $question = $this->getDoctrine()
            ->getRepository(Question::class)
            ->find($id);

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
                'No question found for id '. $id
            );
        }

        $entityManager->remove($question);
        $entityManager->flush();

        return $this->redirectToRoute('admin', array('success' => 'Question Deleted'));
    }

    /**
     * @Route("/admin/answer/create", name="adminAddAnswer")
     */
    public function adminAddAnswer(ValidatorInterface $validator, Request $request)
    {
        if ($request->isMethod('post')) {

            $entityManager = $this->getDoctrine()->getManager();

            $question = $entityManager->getRepository(Question::class)->find($request->get('parent_id'));

            $answer = new Answer();
            $answer->setContent($request->get('content'));
            $answer->setQuestion($question);
            $answer->setCorrect($request->get('correct'));

            $entityManager->persist($answer);
            $entityManager->flush();

            $errors = $validator->validate($answer);
            if (count($errors) > 0) {
                return $this->redirectToRoute('adminAddAnswer', array('errors' => (string) $errors));
            }

            return $this->redirectToRoute('admin', array('success' => 'Answer Created'));
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
                return $this->redirectToRoute('adminEditAnswer', array('errors' => (string) $errors));
            }

            return $this->redirectToRoute('admin', array('success' => 'Answer Edited'));
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

        return $this->redirectToRoute('admin', array('success' => 'Answer Deleted'));
    }


}
