<?php


namespace frontend\tests\functional;

use common\models\Categoria;
use common\models\Produto;
use common\models\Profile;
use common\models\User;
use frontend\tests\FunctionalTester;

class ProdutoCest
{
    protected $categoriaId;
    protected $userId;
    protected $profileId;
    protected $produtoId;

    public function _before(FunctionalTester $I)
    {
        $this->categoriaId = $I->haveRecord(Categoria::class,[
            'tipo' => 'ferramentas manuais'
        ]);

        $this->userId = $I->haveRecord(User::class, [
            'username' => 'tester',
            'auth_key' => 'authkey',
            'password_hash' => 'passwordhash',
            'email' => 'tester@example.com',
        ]);

        $this->profileId = $I->haveRecord(Profile::class, [
            'id_user' => $this->userId,
            'nome' => 'tester',
            'telemovel' => 912345678,
            'nif' => 123456789,
            'morada' => 'rua 123',
            'avaliacao' => 0,
        ]);

        $this->produtoId = $I->haveRecord(Produto::class, [
            'id_vendedor' => $this->profileId,
            'desc' => 'Descrição do produto',
            'preco' => 10,
            'id_tipo' => $this->categoriaId,
            'nome' => 'Produto',
        ]);
    }

    public function testCriarProduto(FunctionalTester $I)
    {
        $I->amOnPage('produto/create?id_vendedor='.$this->profileId);
        $I->fillField('#produto-nome', 'Produto Teste');
        $I->fillField('#produto-preco', '99.99');
        $I->fillField('#produto-desc', 'Descrição do produto de teste');
        $I->selectOption('#produto-id_tipo', $this->categoriaId);
        $I->attachFile('input[type="file"]', 'imagem.png');
        $I->click('Confirmar');
        $I->seeInCurrentUrl('produto/view');
        $I->see('Produto Teste');
    }

}
