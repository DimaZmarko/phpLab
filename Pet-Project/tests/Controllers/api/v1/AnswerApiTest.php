<?php

namespace App\Tests\Controllers\api\v1;

use App\Controller\api\v1\AnswerApi;
use App\Entity\Answer;
use App\Services\AnswerService;
use FOS\RestBundle\View\View;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnswerApiTest extends TestCase
{
    private $answerServiceMock;
    private $answerApiController;
    private $requestMock;

    protected function setUp()
    {
        $this->answerServiceMock = $this->getMockBuilder(AnswerService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->answerApiController = new AnswerApi($this->answerServiceMock);
    }

    protected function tearDown()
    {
        $this->answerServiceMock = null;
        $this->answerApiController = null;
    }

    /**
     * @dataProvider getAllAnswersDataProvider
     */
    public function testAllAnswers($answers)
    {
        $this->answerServiceMock
            ->expects($this->once())
            ->method('getAllAnswers')
            ->willReturn($answers);

        $result = $this->answerApiController->allAnswers();

        $response = new View($answers, Response::HTTP_OK);

        $this->assertEquals($response, $result);
    }

    public function testOneAnswer()
    {
        $id = 1;

        $answer = new Answer();
        $answer->setContent('Name 1')
            ->setCorrect(0);

        $this->answerServiceMock
            ->expects($this->once())
            ->method('getAnswer')
            ->with($id)
            ->willReturn($answer);

        $result = $this->answerApiController->oneAnswer($id);

        $response = new View($answer, Response::HTTP_OK);

        $this->assertEquals($response, $result);
    }

    public function testCreateAnswer()
    {
        $id = 1;
        $args = ['content' => 'test', 'parent_id' => 1, 'correct' => 1];
        $responseArray = ['errors'=> [], 'id' => $id];

        $this->requestMock
            ->expects($this->exactly(3))
            ->method('get')
            ->with($this->logicalOr(
                $this->equalTo('parent_id'),
                $this->equalTo('content'),
                $this->equalTo('correct')
            ))
            ->will($this->returnCallback(array($this, 'answerCallback')));

        $this->answerServiceMock->expects($this->once())
            ->method('create')
            ->with($args)
            ->willReturn($responseArray);

        $result = $this->answerApiController->createAnswer($this->requestMock);

        $response = new View($responseArray, Response::HTTP_CREATED);

        $this->assertEquals($response, $result);
    }

    public function testEditAnswer()
    {
        $id = 1;
        $args = ['content' => 'test', 'correct' => 1];
        $responseArray = ['errors'=> [], 'id' => $id];

        $this->requestMock
            ->expects($this->exactly(2))
            ->method('get')
            ->with($this->logicalOr(
                $this->equalTo('content'),
                $this->equalTo('correct')
            ))
            ->will($this->returnCallback(array($this, 'answerCallback')));

        $this->answerServiceMock->expects($this->once())
            ->method('edit')
            ->with($args, $id)
            ->willReturn($responseArray);

        $result = $this->answerApiController->editAnswer($this->requestMock, $id);

        $response = new View('Answer edited', Response::HTTP_OK);

        $this->assertEquals($response, $result);
    }

    public function testDeleteAnswer()
    {
        $id = 1;

        $this->answerServiceMock->expects($this->once())
            ->method('delete')
            ->with($id);

        $result = $this->answerApiController->deleteAnswer($id);

        $response = new View('Answer deleted', Response::HTTP_OK);

        $this->assertEquals($response, $result);
    }

    public function getAllAnswersDataProvider()
    {
        $a1 = new Answer();
        $a1->setContent('Name 1')
            ->setCorrect(1);


        $a2 = new Answer();
        $a2->setContent('Name 2')
            ->setCorrect(0);

        return [
            [$a1],
            [$a2]
        ];
    }

    public function answerCallback($key)
    {
        if ($key == 'correct') {
            return true;
        } elseif ($key == 'content') {
            return 'test';
        } elseif ($key == 'parent_id') {
            return '1';
        }
    }
}