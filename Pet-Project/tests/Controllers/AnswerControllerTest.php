<?php

namespace App\Tests\Controllers;

use App\Controller\Admin\AnswerController;
use App\Services\AnswerService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class AnswerControllerTest extends WebTestCase
{
    private $answerServiceMock;
    private $answerController;
    private $requestMock;

    public function setUp()
    {
        $this->answerServiceMock = $this->getMockBuilder(AnswerService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->answerController = new AnswerController(
            $this->answerServiceMock
        );
    }

    protected function tearDown()
    {
        $this->answerServiceMock = null;
    }


    public function testAdminAddAnswer()
    {

        $id = 1;

        $this->requestMock
            ->expects($this->once())
            ->method('isMethod')
            ->willReturn(true);

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
            ->with(['content' => 'test', 'parent_id' => 1, 'correct' => 1])
            ->willReturn(['errors'=> [], 'id' => $id]);


        $redirectMock = $this->getMockBuilder(RedirectResponse::class)
            ->disableOriginalConstructor()
            ->getMock();

        $redirectMock->expects($this->once())
            ->method('redirectToRoute');

        $this->answerController->adminAddAnswer($this->requestMock);

    }

    public function testAdminEditAnswer()
    {

    }

    public function testAdminDeleteAnswer()
    {

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