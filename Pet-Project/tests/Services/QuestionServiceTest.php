<?php

namespace App\Tests\Services;

use App\Entity\Question;
use App\Entity\Quiz;
use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use App\Services\QuestionService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuestionServiceTest extends TestCase
{
    private $questionRepositoryMock;
    private $quizRepositoryMock;
    private $entityManagerInterfaceMock;
    private $questionService;
    private $validatorMock;
    private $requestMock;
    private $loggerMock;

    public function setUp()
    {
        $this->questionRepositoryMock = $this->getMockBuilder(QuestionRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
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
        $this->questionService = new QuestionService(
            $this->questionRepositoryMock,
            $this->quizRepositoryMock,
            $this->entityManagerInterfaceMock,
            $this->validatorMock,
            $this->loggerMock
        );
    }

    public function tearDown()
    {
        $this->questionRepositoryMock = null;
        $this->quizRepositoryMock = null;
        $this->entityManagerInterfaceMock = null;
        $this->loggerMock = null;
        $this->questionService = null;
    }

    /**
     * @dataProvider getOneQuestionDataProvider
     */
    public function testGetQuestion($id, $question, $expected)
    {
        $this->questionRepositoryMock
            ->expects($this->any())
            ->method('find')
            ->with($id)
            ->willReturn($question);

        $result = $this->questionService->getQuestion($id);

        $this->assertEquals($expected, $result);
    }

    public function testGetQuestionNegative()
    {
        $id = 999;
        $this->questionRepositoryMock
            ->expects($this->any())
            ->method('find')
            ->with($id)
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $this->questionService->getQuestion($id);

    }

    /**
     * @dataProvider getAllQuestionsDataProvider
     */
    public function testGetAllQuestions($questions, $expected)
    {
        $this->questionRepositoryMock
            ->expects($this->any())
            ->method('findAll')
            ->willReturn($questions);

        $result = $this->questionService->getAllQuestion();

        $this->assertEquals($expected, $result);
    }

    public function testCreate()
    {
        $quizMock = $this->getMockBuilder(Quiz::class)
            ->disableOriginalConstructor()
            ->getMock();

        $question = new Question();
        $question->setContent('test')
            ->setQuiz($quizMock);

        $this->quizRepositoryMock->expects($this->once())
            ->method('find')
            ->with('1')
            ->willReturn($quizMock);

        $this->validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($question)
            ->willReturn([]);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('persist')
            ->with($question);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('flush');

        $result = $this->questionService->create(['content' => 'test', 'parent_id' => 1]);

        $this->assertEquals($question->getId(), $result['id']);
        $this->assertEquals($question->getContent(), 'test');
    }

    /**
     * @dataProvider getQuestionDataProvider
     */
    public function testEdit($id, $question)
    {
        $this->questionRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($question);

        $this->validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($question)
            ->willReturn([]);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('flush');

        $this->questionService->edit(['content' => 'new name'], $id);

        $this->assertEquals($question->getContent(), 'new name');
    }

    /**
     * @dataProvider getQuestionDataProvider
     */
    public function testDelete($id, $question)
    {
        $this->questionRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($question);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('remove')
            ->with($question);

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('flush');

        $result = $this->questionService->delete($id);

        $this->assertNull($result);
    }

    public function getOneQuestionDataProvider()
    {
        $id = 1;
        $question = new Question();
        $question->setContent('Name 1');

        return [
            [$id, $question, $question]
        ];
    }

    public function getAllQuestionsDataProvider()
    {
        $q1 = new Question();
        $q1->setContent('Name 1');
        $question1 = [$q1];

        $q2 = new Question();
        $q2->setContent('Name 2');
        $questions2 = [$q1, $q2];

        return [
            [$question1, $question1],
            [$questions2, $questions2]
        ];
    }

    public function getQuestionDataProvider()
    {
        $question = new Question();
        $question->setContent('Name 1');

        return [
            [1, $question],
        ];
    }
}