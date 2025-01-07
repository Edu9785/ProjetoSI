<?php


namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class FavoritoCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(39);
    }


    public function testAdicionarFavorito(FunctionalTester $I)
    {
        $I->amOnPage('/produto/view?id=13');
        $I->see('Martelo');
        $I->click('.btnAddFav');
        $I->see('Lista de favoritos');
        $I->seeInCurrentUrl('index');
        $I->see('Martelo');
    }
}
