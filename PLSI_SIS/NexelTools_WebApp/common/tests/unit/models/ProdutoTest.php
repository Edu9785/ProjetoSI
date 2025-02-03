<?php

namespace common\tests\unit\models;

use common\models\Categoria;
use common\models\Imagem;
use common\models\Imagemproduto;
use common\models\Produto;
use common\models\Profile;
use common\models\User;
use common\tests\UnitTester;
use frontend\models\Favorito;
use frontend\models\Linhacarrinho;
use Yii;

class ProdutoTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;
    protected $produtoId;
    protected $profileId;
    protected $categoriaId;
    protected $userId;

    protected function _before()
    {

        $this->categoriaId = $this->tester->haveRecord(Categoria::class, [
            'id' => 1,
            'tipo' => 'Ferramentas manuais'
        ]);

        $this->userId = $this->tester->haveRecord(User::class, [
            'username' => 'tester',
            'auth_key' => 'authkey',
            'password_hash' => 'passwordhash',
            'email' => 'tester@example.com',
        ]);

        $this->profileId = $this->tester->haveRecord(Profile::class, [
            'id_user' => $this->userId,
            'nome' => 'tester',
            'telemovel' => 912345678,
            'nif' => 123456789,
            'morada' => 'rua 123',
            'avaliacao' => 0,
        ]);

        $this->produtoId = $this->tester->haveRecord(Produto::class, [
            'id_vendedor' => $this->profileId,
            'desc' => 'Descrição do produto',
            'preco' => 10,
            'id_tipo' => $this->categoriaId,
            'nome' => 'Produto',
        ]);

    }

    public function testValidarCamposObrigatorios()
    {
        $produto = new Produto();

        $produto->id_vendedor = null;
        $this->assertFalse($produto->validate(), 'Validação falhou quando o campo id_vendedor não foi preenchido');
        $produto->desc = null;
        $this->assertFalse($produto->validate(), 'Validação falhou quando o campo desc não foi preenchido');
        $produto->preco = null;
        $this->assertFalse($produto->validate(), 'Validação falhou quando o campo preco não foi preenchido');
        $produto->id_tipo = null;
        $this->assertFalse($produto->validate(), 'Validação falhou quando o campo id_tipo não foi preenchido');
        $produto->nome = null;
        $this->assertFalse($produto->validate(), 'Validação falhou quando o campo nome não foi preenchido');
    }



    public function testRelacionamentoComCategorias()
    {
        $produto = Produto::findOne($this->produtoId);

        $this->assertNotNull($produto->categoria);
        $this->assertEquals('Ferramentas manuais', $produto->categoria->tipo);
    }

    public function testRelacionamentoComProfile()
    {
        $produto = Produto::findOne($this->produtoId);

        $this->assertNotNull($produto->profile->user->username);
        $this->assertEquals('tester', $produto->profile->user->username);
    }

    public function testValidarPreco()
    {
        $produto = new Produto();
        $produto->preco = -1;
        $this->assertFalse($produto->validate(['preco']));
    }

    public function testValidarTiposDeValores()
    {
        $produto = new Produto();

        $produto->id_vendedor = "texto";
        $this->assertFalse($produto->validate(), 'Validação falhou quando o campo id_vendedor tem valor inválido (texto)');
        $produto->desc = 1;
        $this->assertFalse($produto->validate(), 'Validação falhou quando o campo desc tem valor inválido (número)');
        $produto->preco = "preco";
        $this->assertFalse($produto->validate(), 'Validação falhou quando o campo preco tem valor inválido (texto)');
        $produto->id_tipo = "categoria";
        $this->assertFalse($produto->validate(), 'Validação falhou quando o campo id_tipo tem valor inválido (texto)');
        $produto->nome = 23;
        $this->assertFalse($produto->validate(), 'Validação falhou quando o campo nome tem valor inválido (número)');

    }


    public function testCreateProduto()
    {
        $produto = new Produto();
        $produto->id_vendedor = $this->profileId;
        $produto->desc = "Descrição do produto";
        $produto->preco = 10;
        $produto->id_tipo = $this->categoriaId;
        $produto->nome = "Produto Exemplo";

        $this->assertTrue($produto->save(), 'Produto não guardado!');

        $produto = Produto::findOne($produto->id);
        $this->assertNotNull($produto, 'Produto não encontrado.');
        $this->assertEquals($produto->nome, $produto->nome, 'Nome do produto incorreto.');
    }

    public function testReadProduto()
    {
        $produto = Produto::findOne($this->produtoId);
        $this->assertNotNull($produto, 'Produto não encontrado.');
        $this->assertEquals($produto->nome, $produto->nome, 'Nome do produto incorreto.');
    }

    public function testUpdateProduto()
    {
        $produto = Produto::findOne($this->produtoId);
        $produto->nome = 'Produto atualizado';
        $this->assertTrue($produto->save(), 'Produto não atualizado.');
        $this->assertNotNull($produto, 'Produto não encontrado.');
        $this->assertEquals('Produto atualizado', $produto->nome, 'Nome do produto não atualizado.');
    }

    public function testDeleteProduto()
    {

        $produto = Produto::findOne($this->produtoId);
        $this->assertNotNull($produto, 'Produto não encontrado.');
        $produto->delete();
        $produtoDeletado = Produto::findOne($this->produtoId);
        $this->assertNull($produtoDeletado, 'Produto não deletado.');
    }

}
