<?php


namespace frontend\tests\acceptance;

use frontend\models\Carrinhocompra;
use frontend\tests\AcceptanceTester;

class CompraCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function testCompra(AcceptanceTester $I)
    {
       $I->amOnPage('/login');
       $I->fillField('input[name="LoginForm[username]"]', 'Teste');
       $I->fillField('input[name="LoginForm[password]"]', 'teste123');
       $I->click('Login');
       $I->see('Teste');
       $I->click('<i class="fas fa-shopping-cart text-primary"></i>');
       $I->see('Carrinho');
       $I->click('Tratar Pedido');
       $I->selectOption('select[name="Compra[id_metodoexpedicao]"]', 'Ctt Express');
       $I->selectOption('select[name="Compra[id_metodopagamento]"]', 'visa');
       $I->click('Fazer Compra');
    }
}
