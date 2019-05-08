<?php

namespace tests\unit\models;

class ContactFormTest extends \Codeception\Test\Unit
{
    private $model;
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testEmailIsSentOnContact()
    {
        /** @var ContactForm $model */
        $this->model = $this->getMockBuilder('app\models\ContactForm')
            ->setMethods(['validate'])
            ->getMock();

        $this->model->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->model->attributes = [
            'name' => 'Tester',
            'email' => 'vytenis.vaiciunas@ktu.edu',
            'subject' => 'subject',
            'body' => 'body',
        ];

        expect_that($this->model->contact());

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('vytenis.vaiciunas@ktu.edu');
        expect($emailMessage->getFrom())->hasKey('vytvai5@stud.if.ktu.lt');
        expect($emailMessage->getSubject())->equals('subject');
        //expect($emailMessage->toString())->contains('body');
    }
}
