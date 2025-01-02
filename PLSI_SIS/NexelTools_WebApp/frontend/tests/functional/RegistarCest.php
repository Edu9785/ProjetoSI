<?php


namespace frontend\tests\functional;

use common\models\User;
use frontend\tests\FunctionalTester;

class RegistarCest
{
    public function _before(FunctionalTester $I)
    {
        $I->haveRecord(User::class,[
            'username' => 'tester',
            'password_hash' => \Yii::$app->security->generatePasswordHash('tester123'),
            'email' => 'tester@gmail.com',
            'status' => 10,
        ]);
    }

    public function testRegistarUtilizador(FunctionalTester $I)
    {
        $I->amOnPage('site/signup');
        $I->fillField('#signupform-username', 'User');
        $I->fillField('#signupform-nome', 'user');
        $I->fillField('#signupform-email', 'user@gmail.com');
        $I->fillField('#signupform-password', 'user123');
        $I->fillField('#signupform-morada', 'rua123');
        $I->fillField('#signupform-nif', '123456789');
        $I->fillField('#signupform-telemovel', '912345678');
        $I->click('Registar');
        $I->seeInCurrentUrl('index');
    }

    public function testRegistarUtilizadorInvalido(FunctionalTester $I)
    {
        $I->amOnPage('site/signup');
        $I->fillField('#signupform-username', 'User');
        $I->fillField('#signupform-nome', 'user');
        $I->fillField('#signupform-email', 'user.com');
        $I->fillField('#signupform-password', 'user123');
        $I->fillField('#signupform-morada', 'rua123');
        $I->fillField('#signupform-nif', 'joao');
        $I->fillField('#signupform-telemovel', '912345678');
        $I->click('Registar');
        $I->seeInCurrentUrl('signup');
    }

    public function testRegistarUtilizadorExistente(FunctionalTester $I)
    {
        $I->amOnPage('site/signup');
        $I->fillField('#signupform-username', 'User');
        $I->fillField('#signupform-nome', 'user');
        $I->fillField('#signupform-email', 'user@gmail.com');
        $I->fillField('#signupform-password', 'user123');
        $I->fillField('#signupform-morada', 'rua123');
        $I->fillField('#signupform-nif', '123456789');
        $I->fillField('#signupform-telemovel', '912345678');
        $I->click('Registar');
        $I->seeInCurrentUrl('signup');
    }
}
