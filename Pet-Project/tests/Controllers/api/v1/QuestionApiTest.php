<?php

namespace App\Tests\Controllers\api\v1;

use App\Controller\api\v1\QuestionApi;
use App\Entity\Question;
use App\Services\QuestionService;
use FOS\RestBundle\View\View;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionApiTest extends TestCase
{
    private $questionServiceMock;
    private $questionApiController;
    private $requestMock;

    protected function setUp()
    {
        $this->questionServiceMock = $this->getMockBuilder(QuestionService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->questionApiController = new QuestionApi($this->questionServiceMock);
    }

    protected function tearDown()
    {
        $this->questionServiceMock = null;
        $this->questionApiController = null;
    }

    /**
     * @dataProvider getAllQuestionsDataProvider
     */
    public function testAllQuestion($questions)
    {
        $this->questionServiceMock
            ->expects($this->once())
            ->method('getAllQuestion')
            ->willReturn($questions);

        $result = $this->questionApiController->allQuestion();

        $response = new View($questions, Response::HTTP_OK);

        $this->assertEquals($response, $result);
    }

    public function testOneQuestion()
    {
        $id = 1;

        $question = new Question();
        $question->setContent('Name 1');

        $this->questionServiceMock
            ->expects($this->once())
            ->method('getQuestion')
            ->with($id)
            ->willReturn($question);

        $result = $this->questionApiController->oneQuestion($id);

        $response = new View($question, Response::HTTP_OK);

        $this->assertEquals($response, $result);
    }

    public function testCreateAnswer()
    {
        $id = 1;
        $args = ['content' => 'test', 'parent_id' => 1];
        $responseArray = ['errors'=> [], 'id' => $id];

        $this->requestMock
            ->expects($this->exactly(2))
            ->method('get')
            ->with($this->logicalOr(
                $this->equalTo('parent_id'),
                $this->equalTo('content')
            ))
            ->will($this->returnCallback(array($this, 'questionCallback')));

        $this->questionServiceMock->expects($this->once())
            ->method('create')
            ->with($args)
            ->willReturn($responseArray);

        $result = $this->questionApiController->createQuestion($this->requestMock);

        $response = new View($responseArray, Response::HTTP_CREATED);

        $this->assertEquals($response, $result);
    }

    public function testEditQuestion()
    {
        $id = 1;
        $args = ['content' => 'test'];
        $responseArray = ['errors'=> [], 'id' => $id];

        $this->requestMock
            ->expects($this->exactly(1))
            ->method('get')
            ->with($this->logicalOr(
                $this->equalTo('content')
            ))
            ->will($this->returnCallback(array($this, 'questionCallback')));

        $this->questionServiceMock->expects($this->once())
            ->method('edit')
            ->with($args, $id)
            ->willReturn($responseArray);

        $result = $this->questionApiController->editQuestion($this->requestMock, $id);

        $response = new View('Question edited', Response::HTTP_OK);

        $this->assertEquals($response, $result);
    }

    public function testDeleteQuestion()
    {
        $id = 1;

        $this->questionServiceMock->expects($this->once())
            ->method('delete')
            ->with($id);

        $result = $this->questionApiController->deleteQuestion($id);

        $response = new View('Question deleted', Response::HTTP_OK);

        $this->assertEquals($response, $result);
    }

    public function getAllQuestionsDataProvider()
    {
        $q1 = new Question();
        $q1->setContent('Name 1');

        $q2 = new Question();
        $q2->setContent('Name 2');

        return [
            [$q1],
            [$q2]
        ];
    }

    public function questionCallback($key)
    {
        if ($key == 'content') {
            return 'test';
        } elseif ($key == 'parent_id') {
            return '1';
        }
    }
}