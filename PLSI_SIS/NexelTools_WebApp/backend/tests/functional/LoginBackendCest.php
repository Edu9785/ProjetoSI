<?php


namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\User;

class LoginBackendCest
{

    public function _before(FunctionalTester $I)
    {
        //utilizador admin
        $I->haveRecord(User::class,[
           'username' => 'adminUser',
            'password_hash' => \Yii::$app->security->generatePasswordHash('admin123'),
            'email' => 'adminUser@gmail.com',
            'status' => 10,
        ]);

        $auth = \Yii::$app->authManager;
        $adminRole = $auth->getRole('admin');
        $adminId = $I->grabRecord(User::class, ['username' => 'adminUser'])->id;
        $auth->assign($adminRole, $adminId);

        //utilizador com role utilizador
        $I->haveRecord(User::class,[
            'username' => 'user',
            'password_hash' => \Yii::$app->security->generatePasswordHash('user123'),
            'email' => 'user@gmail.com',
            'status' => 10,
        ]);

        $auth = \Yii::$app->authManager;
        $role = $auth->getRole('utilizador');
        $userId = $I->grabRecord(User::class, ['username' => 'user'])->id;
        $auth->assign($role, $userId);
    }

    public function testLoginBackend(FunctionalTester $I)
    {
        $I->amOnPage('site/login');
        $I->fillField('input[name="LoginForm[username]"]', 'adminUser');
        $I->fillField('input[name="LoginForm[password]"]', 'admin123');
        $I->click('Login');
        $I->see('Bem-vindo');
        $I->seeInCurrentUrl('index');
    }

    public function testLoginSemRole(FunctionalTester $I)
    {
        $I->amOnPage('site/login');
        $I->fillField('input[name="LoginForm[username]"]', 'user');
        $I->fillField('input[name="LoginForm[password]"]', 'user123');
        $I->click('Login');
        $I->see('Login permitido apenas para administradores');
        $I->amOnPage('login');
    }
}
