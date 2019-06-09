<?php

namespace App\Tests\Services;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use App\Services\QuizService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuizServiceTest extends TestCase
{
    private $quizRepositoryMock;
    private $entityManagerInterfaceMock;
    private $quizService;
    private $validatorMock;
    private $requestMock;
    private $loggerMock;

    public function setUp()
    {
        $this->quizRepositoryMock = $this->getMockBuilder(QuizRepository::class)
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
        $this->quizService = new QuizService(
            $this->quizRepositoryMock,
            $this->entityManagerInterfaceMock,
            $this->validatorMock,
            $this->loggerMock
        );
    }

    public function tearDown()
    {
        $this->quizRepositoryMock = null;
        $this->entityManagerInterfaceMock = null;
        $this->quizService = null;
    }

    /**
     * @dataProvider getOneQuizDataProvider
     */
    public function testGetQuiz($id, $quiz, $expected)
    {
        $this->quizRepositoryMock
            ->expects($this->any())
            ->method('find')
            ->with($id)
            ->willReturn($quiz);

        $result = $this->quizService->getQuiz($id);

        $this->assertEquals($expected, $result);
    }

    public function testGetQuizNegative()
    {
        $id = 999;
        $this->quizRepositoryMock
            ->expects($this->any())
            ->method('find')
            ->with($id)
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $this->quizService->getQuiz($id);

    }

    public function testCreate()
    {
        $quiz = new Quiz();
        $quiz->setTitle('test title')
            ->setDescription('test Description');

        $this->validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($quiz)
            ->willReturn([]);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('persist')
            ->with($quiz);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('flush');

        $result = $this->quizService->create(['title' => 'test title', 'desc' => 'test Description']);

        $this->assertEquals($quiz->getId(), $result['id']);
        $this->assertEquals($quiz->getTitle(), 'test title');
    }

    /**
     * @dataProvider getQuizDataProvider
     */
    public function testEdit($id, $quiz)
    {
        $this->quizRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($quiz);

        $this->validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($quiz)
            ->willReturn([]);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('flush');

        $this->quizService->edit(['title' => 'new title', 'desc' => 'new description'], $id);

        $this->assertEquals($quiz->getTitle(), 'new title');
        $this->assertEquals($quiz->getDescription(), 'new description');
    }
    public function testEditNegative()
    {
        $id = 999;

        $this->quizRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);

        $this->quizService->edit(['title' => 'new title', 'desc' => 'new description'], $id);
    }

    /**
     * @dataProvider getQuizDataProvider
     */
    public function testDelete($id, $quiz)
    {
        $this->quizRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($quiz);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('remove')
            ->with($quiz);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('flush');

        $result = $this->quizService->delete($id);

        $this->assertNull($result);
    }

    public function testDeleteNegative()
    {
        $id = 999;

        $this->quizRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);

        $this->quizService->delete($id);
    }

    public function getOneQuizDataProvider()
    {
        $id = 1;
        $quiz = new Quiz();
        $quiz->setTitle('Name 1')
            ->setDescription('DEscription');

        return [
            [$id, $quiz, $quiz]
        ];
    }

    public function getQuizDataProvider()
    {
        $quiz = new Quiz();
        $quiz->setTitle('Title title')
            ->setDescription('Desc desc');

        return [
            [1, $quiz],
        ];
    }
}