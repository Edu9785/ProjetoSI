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
        $I->see('Marketplace');
        $I->click('Marketplace');
        $I->waitForElement('.btnVerProduto');
        $I->click('a.btnVerProduto');
        $I->see('Adicionar ao Carrinho');
        $I->click('.btnCart');
        $I->see('Carrinho');
        $I->seeInCurrentUrl('carrinhocompra/index');
        $I->see('Sumário');
        $I->click('Tratar pedido');
        $I->selectOption('select[name="Compra[id_metodoexpedicao]"]', 'Ctt Express');
        $I->selectOption('select[name="Compra[id_metodopagamento]"]', 'visa');
        $I->scrollTo('.btn.btn-block.btn-primary.font-weight-bold.py-3');
        $I->click('.btn.btn-block.btn-primary.font-weight-bold.py-3');
        $I->see('Compra realizada com sucesso! Obrigado!');
        $I->seeInCurrentUrl('compra/view');
    }

}
