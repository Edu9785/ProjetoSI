<?php


namespace frontend\tests\acceptance;
use Helper\Acceptance;
use common\models\Categoria;
use common\models\Imagem;
use common\models\Imagemproduto;
use common\models\Produto;
use common\models\Profile;
use common\models\User;
use frontend\tests\AcceptanceTester;

class CompraProdutoCest
{
    protected $userId;
    protected $profileId;
    protected $categoriaId;
    protected $produtoId;
    protected $imagemId;

    public function _before(AcceptanceTester $I)
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

        $imagemId = $I->haveRecord(Imagem::class, [
            'imagens' => 'uploads/gKGUNK8iN23L8K7veuzv985AgPPE3zY0.png'
        ]);

        $I->haveRecord(Imagemproduto::class, [
            'id_imagem' => $imagemId,
            'id_produto' => $this->produtoId,
        ]);

        $I->amOnPage('site/login');
        $I->fillField('LoginForm[username]', 'Teste');
        $I->fillField('LoginForm[password]', 'Teste123');
        $I->click('Login');
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
