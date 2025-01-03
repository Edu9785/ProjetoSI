<?php


namespace frontend\tests\acceptance;
use tests\Helper\Acceptance;
use common\models\Categoria;
use common\models\Imagem;
use common\models\Imagemproduto;
use common\models\Produto;
use common\models\Profile;
use common\models\User;
use frontend\tests\AcceptanceTester;

class CompraProdutoCest
{

    public function _before(AcceptanceTester $I)
    {

    }


    public function testComprarProduto(AcceptanceTester $I)
    {
        $I->wantTo('Comprar um produto');

        $I->amOnPage('/produto/view?id=' .$this->produtoId);
        $I->see('.btnCart');
        $I->click('.btnCarte');
        $I->seeInCurrentUrl();
    }
}
