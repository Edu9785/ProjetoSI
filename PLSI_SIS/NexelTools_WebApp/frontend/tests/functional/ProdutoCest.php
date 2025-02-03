<?php


namespace frontend\tests\functional;

use common\models\Categoria;
use common\models\Produto;
use common\models\Profile;
use common\models\User;
use frontend\tests\FunctionalTester;

class ProdutoCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(39);
    }

    public function testCriarProduto(FunctionalTester $I)
    {
        $I->amOnPage('site/index');
        $I->click('button.btnPerfil');
        $I->click('a.btnVerPerfil');
        $I->see('Perfil');
        $I->click('a.btnPublicar');
        $I->see('Publicar Produto');
        $I->see('Nome:', 'label');
        $I->see('Preço:', 'label');
        $I->see('Descrição:', 'label');
        $I->see('Categoria', 'label');
        $I->see('Imagens:', 'label');
        $I->fillField('Produto[nome]', 'Produto Teste');
        $I->fillField('Produto[preco]', '29.99');
        $I->fillField('Produto[desc]', 'Descrição detalhada do produto teste.');
        $I->selectOption('Produto[id_tipo]', '18');
        $I->attachFile('input[type="file"]', 'test-image.jpg');
        $I->click('Confirmar');
        $I->see('Produto Teste');
        $I->seeInCurrentUrl('produto/view');
    }

    public function testVisualizarProduto(FunctionalTester $I)
    {
        $I->amOnPage('/produto/view?id=9');
        $I->see('Trator Agrícula');
        $I->see('10000');
    }

    public function testEditarProduto(FunctionalTester $I)
    {
        $I->amOnPage('/produto/update?id=9');
        $I->fillField('Produto[nome]', 'Produto Teste Editado');
        $I->click('Confirmar');
        $I->seeInCurrentUrl('/produto/view');
        $I->see('Produto Teste Editado');
    }
}
