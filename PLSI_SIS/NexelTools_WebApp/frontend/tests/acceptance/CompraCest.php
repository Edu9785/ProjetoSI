<?php


namespace frontend\tests\acceptance;

use frontend\models\Carrinhocompra;
use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class CompraCest
{
    public function _before(AcceptanceTester $I)
    {

    }

    public function testCompra(AcceptanceTester $I)
    {
        $I->amOnPage('site/login');
        $I->see('username');
        $I->fillField('input[name="LoginForm[username]"]', 'Teste');
        $I->fillField('input[name="LoginForm[password]"]', 'teste123');
        $I->click('.btnLogin');
        $I->amOnPage('produto/view?id=13');
        $I->see('Martelo');
        $I->click('.btnCart');
        $I->see('Carrinho');
        $I->seeInCurrentUrl('carrinhocompra/index');
        $I->click('Tratar pedido');
        $I->selectOption('select[name="Compra[id_metodoexpedicao]"]', 'Ctt Express');
        $I->selectOption('select[name="Compra[id_metodopagamento]"]', 'visa');
        $I->click('Fazer Compra');
        $I->see('Compra realizada com sucesso! Obrigado!');
        $I->seeInCurrentUrl('compra/view');
    }
}
