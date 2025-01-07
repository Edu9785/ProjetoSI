<?php


namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class CarrinhocompraCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(39);
    }


    public function testAdicionarProdutoCarrinho(FunctionalTester $I)
    {
        $I->amOnPage('/produto/view?id=13');
        $I->see('Martelo');
        $I->click('Adicionar ao Carrinho');
        $I->see('Carrinho');
        $I->seeInCurrentUrl('index');
        $I->see('Martelo');
    }
}
