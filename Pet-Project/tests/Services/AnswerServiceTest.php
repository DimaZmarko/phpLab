<?php

namespace App\Tests\Services;

use App\Entity\Answer;
use App\Entity\Question;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Services\AnswerService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnswerServiceTest extends TestCase
{
    private $answerRepositoryMock;
    private $questionRepositoryMock;
    private $entityManagerInterfaceMock;
    private $answerService;
    private $validatorMock;
    private $requestMock;
    private $loggerMock;

    public function setUp()
    {
        $this->answerRepositoryMock = $this->getMockBuilder(AnswerRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->questionRepositoryMock = $this->getMockBuilder(QuestionRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->entityManagerInterfaceMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->validatorMock = $this->getMockBuilder(ValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->answerService = new AnswerService(
            $this->answerRepositoryMock,
            $this->questionRepositoryMock,
            $this->entityManagerInterfaceMock,
            $this->validatorMock,
            $this->loggerMock
        );
    }

    public function tearDown()
    {
        $this->answerRepositoryMock = null;
        $this->questionRepositoryMock = null;
        $this->entityManagerInterfaceMock = null;
        $this->loggerMock = null;
        $this->answerService = null;
    }

    /**
     * @dataProvider getOneAnswerDataProvider
     */
    public function testGetAnswer($id, $answer, $expected)
    {
        $this->answerRepositoryMock
            ->expects($this->any())
            ->method('find')
            ->with($id)
            ->willReturn($answer);

        $result = $this->answerService->getAnswer($id);

        $this->assertEquals($expected, $result);
    }

    public function testGetAnswerNegative()
    {
        $id = 999;
        $this->answerRepositoryMock
            ->expects($this->any())
            ->method('find')
            ->with($id)
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $this->answerService->getAnswer($id);

    }

    /**
     * @dataProvider getAllAnswersDataProvider
     */
    public function testGetAllAnswers($answers, $expected)
    {
        $this->answerRepositoryMock
            ->expects($this->any())
            ->method('findAll')
            ->willReturn($answers);

        $result = $this->answerService->getAllAnswers();

        $this->assertEquals($expected, $result);
    }

    public function testCreate()
    {
        $questionMock = $this->getMockBuilder(Question::class)
            ->disableOriginalConstructor()
            ->getMock();

        $answer = new Answer();
        $answer->setContent('test')
            ->setCorrect(1)
            ->setQuestion($questionMock);

        $this->questionRepositoryMock->expects($this->once())
            ->method('find')
            ->with('1')
            ->willReturn($questionMock);

        $this->validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($answer)
            ->willReturn([]);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('persist')
            ->with($answer);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('flush');

        $result = $this->answerService->create(['content' => 'test', 'correct' => 1, 'parent_id' => 1]);

        $this->assertEquals($answer->getId(), $result['id']);
        $this->assertEquals($answer->getContent(), 'test');
        $this->assertEquals($answer->getCorrect(), 1);
    }


    /**
     * @dataProvider getAnswerDataProvider
     */
    public function testEdit($id, $answer)
    {
        $this->answerRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($answer);

        $this->validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($answer)
            ->willReturn([]);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('flush');

        $this->answerService->edit(['content' => 'new name', 'correct' => 1], $id);

        $this->assertEquals($answer->getContent(), 'new name');
        $this->assertEquals($answer->getCorrect(), 1);
    }

    public function testEditNegative()
    {
        $id = 999;

        $this->answerRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);

        $this->answerService->edit(['content' => 'new name', 'correct' => 1], $id);
    }

    /**
     * @dataProvider getAnswerDataProvider
     */
    public function testDelete($id, $answer)
    {
        $this->answerRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($answer);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('remove')
            ->with($answer);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('flush');

        $result = $this->answerService->delete($id);

        $this->assertNull($result);
    }

    public function testDeleteNegative()
    {
        $id = 999;

        $this->answerRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);

        $this->answerService->delete($id);
    }

    public function getOneAnswerDataProvider()
    {
        $id = 1;
        $answer = new Answer();
        $answer->setContent('Name 1');

        return [
            [$id, $answer, $answer]
        ];
    }

    public function getAllAnswersDataProvider()
    {
        $a1 = new Answer();
        $a1->setContent('Name 1')
            ->setCorrect(1);
        $answer1 = [$a1];

        $a2 = new Answer();
        $a2->setContent('Name 2')
            ->setCorrect(0);
        $answers2 = [$a1, $a2];

        return [
            [$answer1, $answer1],
            [$answers2, $answers2]
        ];
    }

    public function getAnswerDataProvider()
    {
        $answer = new Answer();
        $answer->setContent('Name 1')
            ->setCorrect(0);

        return [
            [1, $answer],
        ];
    }
}