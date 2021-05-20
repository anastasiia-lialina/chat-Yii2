<?php

class MessagesCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('messages/index');
    }

    public function openMessagesIndex(\FunctionalTester $I)
    {
        $I->see('Чат', 'h1');

    }

    public function checkFormSubmitNoData(FunctionalTester $I)
    {
        $I->submitForm('#send-message-form', []);
        $I->see('Чат', 'h1');
        $I->seeValidationError('Необходимо заполнить «Сообщение».');
    }

    public function checkSubmitCorrectData(FunctionalTester $I)
    {
        $I->submitForm('#send-message-form', [
            'Messages[text]' => 'hello!',
        ]);
        $I->see('Hello', 'p');
    }
}