<?php

namespace App\Tests\Controllers\api\v1;

use App\Controller\api\v1\QuizApi;
use App\Entity\Quiz;
use App\Services\QuizService;
use FOS\RestBundle\View\View;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizApiTest extends TestCase
{
    private $quizServiceMock;
    private $quizApiController;
    private $requestMock;

    protected function setUp()
    {
        $this->quizServiceMock = $this->getMockBuilder(QuizService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quizApiController = new QuizApi($this->quizServiceMock);
    }

    protected function tearDown()
    {
        $this->quizServiceMock = null;
        $this->quizApiController = null;
    }

    /**
     * @dataProvider getAllQuizzesDataProvider
     */
    public function testAllQuizzes($quizzes)
    {
        $this->quizServiceMock
            ->expects($this->once())
            ->method('getAllQuizzes')
            ->willReturn($quizzes);

        $result = $this->quizApiController->allQuizzes();

        $response = new View($quizzes, Response::HTTP_OK);

        $this->assertEquals($response, $result);
    }

    public function testOneQuiz()
    {
        $id = 1;

        $quiz = new Quiz();
        $quiz->setTitle('test')
            ->setDescription('desc 1');

        $this->quizServiceMock
            ->expects($this->once())
            ->method('getQuiz')
            ->with($id)
            ->willReturn($quiz);

        $result = $this->quizApiController->oneQuiz($id);

        $response = new View($quiz, Response::HTTP_OK);

        $this->assertEquals($response, $result);
    }

    public function testCreateQuiz()
    {
        $id = 1;
        $args = ['title' => 'test', 'desc' => 'desc 1'];
        $responseArray = ['errors'=> [], 'id' => $id];

        $this->requestMock
            ->expects($this->exactly(2))
            ->method('get')
            ->with($this->logicalOr(
                $this->equalTo('title'),
                $this->equalTo('description')
            ))
            ->will($this->returnCallback(array($this, 'quizCallback')));

        $this->quizServiceMock->expects($this->once())
            ->method('create')
            ->with($args)
            ->willReturn($responseArray);

        $result = $this->quizApiController->createQuiz($this->requestMock);

        $response = new View($responseArray, Response::HTTP_CREATED);

        $this->assertEquals($response, $result);
    }

    public function testEditQuiz()
    {
        $id = 1;
        $args = ['title' => 'test', 'desc' => 'desc 1'];
        $responseArray = ['errors'=> [], 'id' => $id];

        $this->requestMock
            ->expects($this->exactly(2))
            ->method('get')
            ->with($this->logicalOr(
                $this->equalTo('title'),
                $this->equalTo('description')
            ))
            ->will($this->returnCallback(array($this, 'quizCallback')));

        $this->quizServiceMock->expects($this->once())
            ->method('edit')
            ->with($args, $id)
            ->willReturn($responseArray);

        $result = $this->quizApiController->editQuiz($this->requestMock, $id);

        $response = new View('Quiz edited', Response::HTTP_OK);

        $this->assertEquals($response, $result);
    }

    public function testDeleteQuiz()
    {
        $id = 1;

        $this->quizServiceMock->expects($this->once())
            ->method('delete')
            ->with($id);

        $result = $this->quizApiController->deleteQuiz($id);

        $response = new View('Quiz deleted', Response::HTTP_OK);

        $this->assertEquals($response, $result);
    }

    public function getAllQuizzesDataProvider()
    {
        $q1 = new Quiz();
        $q1->setTitle('Name 1')
            ->setDescription('desc 1');


        $q2 = new Quiz();
        $q2->setTitle('Name 2')
            ->setDescription('desc 2');

        return [
            [$q1],
            [$q2]
        ];
    }

    public function quizCallback($key)
    {
        if ($key == 'title') {
            return 'test';
        } elseif ($key == 'description') {
            return 'desc 1';
        }
    }
}